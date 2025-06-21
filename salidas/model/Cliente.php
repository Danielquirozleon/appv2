<?php
// model/Cliente.php

class Cliente {
    private $pdo;
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    public function getAll(): array {
        return $this->pdo->query('SELECT * FROM clientes')->fetchAll();
    }
    public function getByNumero(int $numero): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM clientes WHERE numero_cliente = :n');
        $stmt->execute(['n' => $numero]);
        return $stmt->fetch() ?: null;
    }
    public function create(int $numero, string $nombre): bool {
        $stmt = $this->pdo->prepare('INSERT INTO clientes (numero_cliente, nombre) VALUES (:n, :nm)');
        return $stmt->execute(['n' => $numero, 'nm' => $nombre]);
    }
    public function update(int $numero, string $nombre): bool {
        $stmt = $this->pdo->prepare('UPDATE clientes SET nombre = :nm WHERE numero_cliente = :n');
        return $stmt->execute(['nm' => $nombre, 'n' => $numero]);
    }
    public function delete(int $numero): bool {
        $stmt = $this->pdo->prepare('DELETE FROM clientes WHERE numero_cliente = :n');
        return $stmt->execute(['n' => $numero]);
    }
}
