<?php
// model/SalidaDetalle.php

class SalidaDetalle {
    /**
     * @var PDO Instancia de conexión
     */
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obtiene el detalle de una salida por salida_id
     * @param int $salidaId
     * @return array
     */
    public function getBySalidaId(int $salidaId): array {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM salidas_detalle WHERE salida_id = :salidaId'
        );
        $stmt->execute(['salidaId' => $salidaId]);
        return $stmt->fetchAll();
    }

    /**
     * Crea múltiples registros de detalle
     * @param int $salidaId
     * @param array $items Array de items ['PRODUCT_ID'=>string, 'cantidad'=>int]
     * @return bool
     */
    public function createBulk(int $salidaId, array $items): bool {
        $this->pdo->beginTransaction();
        $stmt = $this->pdo->prepare(
            'INSERT INTO salidas_detalle (salida_id, PRODUCT_ID, cantidad) VALUES (:salida_id, :PRODUCT_ID, :cantidad)'
        );
        foreach ($items as $item) {
            $stmt->execute([
                'salida_id'  => $salidaId,
                'PRODUCT_ID' => $item['PRODUCT_ID'],
                'cantidad'   => $item['cantidad']
            ]);
        }
        return $this->pdo->commit();
    }

    /**
     * Elimina detalle por salida_id
     * @param int $salidaId
     * @return bool
     */
    public function deleteBySalidaId(int $salidaId): bool {
        $stmt = $this->pdo->prepare(
            'DELETE FROM salidas_detalle WHERE salida_id = :salidaId'
        );
        return $stmt->execute(['salidaId' => $salidaId]);
    }
}
