<?php
// controller/ImportController.php

class ImportController {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Muestra formulario de importación
     */
    public function index() {
        require __DIR__ . '/../views/importacion/importar_txt.php';
    }

    /**
     * Procesa el archivo subido y reemplaza la tabla seleccionada
     */
    public function import() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['txt_file'], $_POST['tipo'])) {
            header('HTTP/1.1 400 Bad Request');
            exit('Solicitud inválida');
        }

        $tipo = $_POST['tipo']; // 'clientes' o 'productos'
        $tmpPath = $_FILES['txt_file']['tmp_name'];
        if (!is_uploaded_file($tmpPath)) {
            exit('Error al subir el archivo');
        }

        // Leer líneas
        $lines = file($tmpPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!$lines) {
            exit('Archivo vacío o formato inválido');
        }

        // Determinar tabla y columnas
        if ($tipo === 'clientes') {
            $table = 'clientes';
            $columns = ['numero_cliente', 'nombre'];
        } elseif ($tipo === 'productos') {
            $table = 'productos';
            $columns = ['PRODUCT_ID','UM','PRODUCT_NAME','DESCRIPTION','Codigo_Marca','Fecha_Ultima_Venta','precio_abierto_superiorcosto','FechaUltimoMovimiento','CODE_PROV_O_ALT'];
        } else {
            exit('Tipo inválido');
        }

        // Iniciar transacción
        $this->pdo->beginTransaction();
        // Vaciar tabla
        $this->pdo->exec("TRUNCATE TABLE {$table}");

        // Preparar inserción
        $placeholders = implode(',', array_fill(0, count($columns), '?'));
        $sql = "INSERT INTO {$table} (" . implode(',', $columns) . ") VALUES ({$placeholders})";
        $stmt = $this->pdo->prepare($sql);

        // Insertar cada línea (TSV)
        foreach ($lines as $line) {
            $data = explode("	", $line);
            // Validar cantidad de columnas
            if (count($data) !== count($columns)) {
                $this->pdo->rollBack();
                exit('Formato de línea inválido: ' . htmlspecialchars($line));
            }
            $stmt->execute($data);
        }

        $this->pdo->commit();
        header('Location: ' . BASE_URL . '?r=import/index&success=1');
        exit;
    }
}
