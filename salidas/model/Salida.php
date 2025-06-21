<?php
// model/Salida.php

class Salida {
    /**
     * @var PDO Instancia de conexión
     */
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obtiene todas las salidas
     * @return array
     */
    public function getAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM salidas');
        return $stmt->fetchAll();
    }

    /**
     * Obtiene una salida por ID, incluyendo detalle
     * @param int $id
     * @return array|null
     */
    public function getById(int $id): ?array {
        $stmt = $this->pdo->prepare(
            'SELECT s.*, sd.PRODUCT_ID, sd.cantidad
             FROM salidas s
             LEFT JOIN salidas_detalle sd ON s.id = sd.salida_id
             WHERE s.id = :id'
        );
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetchAll();
        return $result ?: null;
    }

    /**
     * Crea una nueva salida y sus detalles
     * @param array $data     Datos (numero_cliente, direccion_id, usuario_id, recibe_nombre)
     * @param array $items    Arreglo de items ['PRODUCT_ID'=>string,'cantidad'=>int]
     * @return bool
     */
    public function create(array $data, array $items): bool {
        $this->pdo->beginTransaction();

        $sql = 'INSERT INTO salidas (numero_cliente, direccion_id, usuario_id, recibe_nombre)'
             . ' VALUES (:numero_cliente, :direccion_id, :usuario_id, :recibe_nombre)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        $salidaId = $this->pdo->lastInsertId();

        $sqlItem = 'INSERT INTO salidas_detalle (salida_id, PRODUCT_ID, cantidad)'
                 . ' VALUES (:salida_id, :PRODUCT_ID, :cantidad)';
        $stmtItem = $this->pdo->prepare($sqlItem);
        foreach ($items as $it) {
            $stmtItem->execute([
                'salida_id'  => $salidaId,
                'PRODUCT_ID' => $it['PRODUCT_ID'],
                'cantidad'   => $it['cantidad']
            ]);
        }

        return $this->pdo->commit();
    }

    /**
     * Actualiza el estado de una salida
     * @param int $id
     * @param string $estado
     * @return bool
     */
    public function updateStatus(int $id, string $estado): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE salidas SET estado = :estado WHERE id = :id'
        );
        return $stmt->execute(['estado' => $estado, 'id' => $id]);
    }

    /**
     * Elimina una salida (y su detalle por cascade)
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare(
            'DELETE FROM salidas WHERE id = :id'
        );
        return $stmt->execute(['id' => $id]);
    }
}
