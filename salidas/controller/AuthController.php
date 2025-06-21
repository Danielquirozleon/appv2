<?php
// controller/AuthController.php

class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Muestra formulario de login y procesa autenticación
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $usuarioModel = new Usuario($this->pdo);
            $user = $usuarioModel->getByUsername($username);

            if ($user && password_verify($password, $user['contrasena'])) {
                // Iniciar sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_rol'] = $user['rol'];
                header('Location: ?r=salida/nueva');
                exit;
            } else {
                $this->view('auth/login', ['error' => 'Credenciales incorrectas']);
            }
        } else {
            $this->view('auth/login');
        }
    }

    // Cierra la sesión
    public function logout() {
        session_destroy();
        header('Location: ?r=auth/login');
        exit;
    }

    // Carga una vista
    private function view($ruta, $data = []) {
        extract($data);
        require __DIR__ . '/../views/' . $ruta . '.php';
    }
}
