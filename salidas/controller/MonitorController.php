<?php
// controller/MonitorController.php

class MonitorController {
    private $pdo;
    private $salidaModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->salidaModel = new Salida($pdo);
    }

    /**
     * Mostrar monitor de salidas "cambio_fisico" pendientes
     */
    public function index() {
        $all = $this->salidaModel->getAll();
        $pendientes = array_filter($all, function($s) {
            return $s['tipo'] === 'cambio_fisico' && $s['estado'] === 'pendiente';
        });
        require __DIR__ . '/../views/salidas/monitor.php';
    }

    /**
     * Marcar una salida pendiente como concluida
     */
    public function concluir() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            $this->salidaModel->updateStatus($id, 'concluido');
        }
        header('Location: ' . BASE_URL . '?r=monitor/index');
        exit;
    }
}
