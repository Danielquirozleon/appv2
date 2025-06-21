<?php
// controller/SalidaController.php

class SalidaController {
    private $pdo;
    private $salidaModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->salidaModel = new Salida($pdo);
    }

    // Lista todas las salidas
    public function index() {
        $salidas = $this->salidaModel->getAll();
        require __DIR__ . '/../views/salidas/index.php';
    }

    // Muestra formulario para crear nueva salida
    public function nueva() {
        $clientes = (new Cliente($this->pdo))->getAll();
        require __DIR__ . '/../views/salidas/nueva.php';
    }

    // Guarda nueva salida
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'numero_cliente' => $_POST['numero_cliente'],
                'direccion_id'   => $_POST['direccion'],
                'usuario_id'     => $_SESSION['user_id'] ?? 1,
                'recibe_nombre'  => $_POST['recibe_nombre']
            ];

            $detalle = $_POST['detalle'] ?? [];

            $this->salidaModel->create($data, $detalle);
            header('Location: ?r=salidas/index');
            exit;
        }
    }

    // Muestra una salida específica
    public function ver() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $salida = $this->salidaModel->getById($id);
            require __DIR__ . '/../views/salidas/ver.php';
        } else {
            echo "ID no proporcionado.";
        }
    }
}
