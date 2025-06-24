<?php
// model/Direccion.php
class Direccion {
    private $pdo;
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    /**
     * Obtiene direcciones por número de cliente
     */
    public function getByCliente(string $numero_cliente): array {
        $stmt = $this->pdo->prepare('SELECT id, direccion FROM direcciones WHERE numero_cliente = :cliente');
        $stmt->execute(['cliente' => $numero_cliente]);
        return $stmt->fetchAll();
    }
}
