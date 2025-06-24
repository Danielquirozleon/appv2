<?php
// controller/DireccionController.php
class DireccionController {
    private $model;
    public function __construct(PDO $pdo) {
        $this->model = new Direccion($pdo);
    }
    /**
     * Devuelve las direcciones de un cliente en formato JSON
     */
    public function obtenerDirecciones() {
        header('Content-Type: application/json');
        $numCliente = $_GET['numero_cliente'] ?? '';
        echo json_encode($this->model->getByCliente($numCliente));
    }
}
