<?php
// controller/HistorialController.php

class HistorialController {
    private $pdo;
    private $salidaModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->salidaModel = new Salida($pdo);
    }

    /**
     * Lista salidas con filtros y muestra historial
     */
    public function index() {
        // Captura filtros
        $numero    = $_GET['numero']    ?? null;
        $cliente   = $_GET['cliente']   ?? null;
        $producto  = $_GET['producto']  ?? null;
        $fechaIni  = $_GET['fecha_ini'] ?? null;
        $fechaFin  = $_GET['fecha_fin'] ?? null;

        // Obtiene todos y filtra en memoria (o implementar método en modelo)
        $all = $this->salidaModel->getAll();
        $filtered = array_filter($all, function($s) use ($numero, $cliente, $producto, $fechaIni, $fechaFin) {
            if ($numero && stripos($s['numero_salida'], $numero) === false) {
                return false;
            }
            if ($cliente && $s['numero_cliente'] != $cliente) {
                return false;
            }
            // Para producto, revisar detalle (requiere unir modelo SalidaDetalle)
            if ($producto) {
                $detalleModel = new SalidaDetalle($this->pdo);
                $items = $detalleModel->getBySalidaId($s['id']);
                $found = false;
                foreach ($items as $it) {
                    if ($it['PRODUCT_ID'] === $producto) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    return false;
                }
            }
            if ($fechaIni && strtotime($s['fecha']) < strtotime($fechaIni)) {
                return false;
            }
            if ($fechaFin && strtotime($s['fecha']) > strtotime($fechaFin)) {
                return false;
            }
            return true;
        });

        require __DIR__ . '/../views/historial/index.php';
    }

    /**
     * Exporta el historial filtrado a PDF
     */
    public function exportPdf() {
        // Lógica similar a index() para filtros
        // Generar PDF usando biblioteca (FPDF, TCPDF)
        // Output PDF
    }

    /**
     * Exporta el historial filtrado a Excel
     */
    public function exportExcel() {
        // Lógica similar a index() para filtros
        // Generar Excel (PhpSpreadsheet)
        // Output Excel
    }
}
