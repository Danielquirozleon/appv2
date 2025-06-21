<?php
// controller/ReportController.php

class ReportController {
    private $pdo;
    private $salidaModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->salidaModel = new Salida($pdo);
    }

    /**
     * Genera reporte de salidas totales por cliente o por producto
     * Opciones de filtrado: cliente, producto, rango de fechas
     */
    public function index() {
        $cliente   = $_GET['cliente']   ?? null;
        $producto  = $_GET['producto']  ?? null;
        $fechaIni  = $_GET['fecha_ini'] ?? null;
        $fechaFin  = $_GET['fecha_fin'] ?? null;

        // Obtiene todos y aplica filtros
        $all = $this->salidaModel->getAll();
        $filtered = array_filter($all, function($s) use ($cliente, $producto, $fechaIni, $fechaFin) {
            if ($cliente && $s['numero_cliente'] != $cliente) {
                return false;
            }
            if ($producto) {
                $detalle = new SalidaDetalle($this->pdo);
                $items = $detalle->getBySalidaId($s['id']);
                $found = false;
                foreach ($items as $it) {
                    if ($it['PRODUCT_ID'] === $producto) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) return false;
            }
            if ($fechaIni && strtotime($s['fecha']) < strtotime($fechaIni)) {
                return false;
            }
            if ($fechaFin && strtotime($s['fecha']) > strtotime($fechaFin)) {
                return false;
            }
            return true;
        });

        // Preparar datos de agregación
        $reportData = [];
        foreach ($filtered as $s) {
            $key = $cliente ? $s['numero_cliente'] : 'total';
            if (!isset($reportData[$key])) {
                $reportData[$key] = 0;
            }
            $items = (new SalidaDetalle($this->pdo))->getBySalidaId($s['id']);
            foreach ($items as $it) {
                $reportData[$key] += $it['cantidad'];
            }
        }

        require __DIR__ . '/../views/reportes/index.php';
    }

    /**
     * Exporta el reporte filtrado a PDF o Excel
     */
    public function export() {
        // Similar a index(), pero genera archivo usando PDF o PhpSpreadsheet
    }
}
