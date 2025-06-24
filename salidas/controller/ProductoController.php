<?php
// controller/ProductoController.php
class ProductoController {
    private $model;
    public function __construct(PDO $pdo) {
        $this->model = new Producto($pdo);
    }
    /**
     * Busca un producto y devuelve JSON
     */
    public function buscar() {
        header('Content-Type: application/json');
        $id = $_GET['PRODUCT_ID'] ?? '';
        $prod = $this->model->getById($id);
        if ($prod) {
            $prod['exists'] = true;
            echo json_encode($prod);
        } else {
            echo json_encode(['exists' => false]);
        }
    }
}
