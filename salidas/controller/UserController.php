<?php
// controller/UserController.php

class UserController {
    private $pdo;
    private $usuarioModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->usuarioModel = new Usuario($pdo);
    }

    /**
     * Lista todos los usuarios con sus módulos
     */
    public function index() {
        $users = $this->usuarioModel->getAll();
        require __DIR__ . '/../views/usuarios/index.php';
    }

    /**
     * Muestra formulario de creación o edición de usuario
     */
    public function form() {
        $id = (int)($_GET['id'] ?? 0);
        $user = $id ? $this->usuarioModel->getById($id) : null;
        $modulos = (new Modulo($this->pdo))->getAll();
        $assigned = $id ? $this->usuarioModel->getModules($id) : [];
        require __DIR__ . '/../views/usuarios/form.php';
    }

    /**
     * Procesa creación o actualización de usuario y módulos
     */
    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $username = $_POST['username'];
            $rol = $_POST['rol'];
            $modules = $_POST['modules'] ?? [];

            if ($id) {
                $activo = isset($_POST['activo']);
                $this->usuarioModel->update($id, $rol, $activo);
                if ($modules) {
                    $this->usuarioModel->setModules($id, $modules);
                }
            } else {
                $password = $_POST['password'];
                $this->usuarioModel->create($username, $password, $rol);
                $newId = $this->pdo->lastInsertId();
                if ($modules) {
                    $this->usuarioModel->setModules($newId, $modules);
                }
            }

            header('Location: ' . BASE_URL . '?r=user/index');
            exit;
        }
    }

    /**
     * Desactiva un usuario
     */
    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            $this->usuarioModel->delete($id);
        }
        header('Location: ' . BASE_URL . '?r=user/index');
        exit;
    }
}
