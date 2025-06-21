<?php
// model/Producto.php

class Producto {
    private $pdo;
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    public function getAll(): array {
        return $this->pdo->query('SELECT * FROM productos')->fetchAll();
    }
    public function getById(string $id): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM productos WHERE PRODUCT_ID = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }
    public function create(array $data): bool {
        $sql = 'INSERT INTO productos (PRODUCT_ID, UM, PRODUCT_NAME, DESCRIPTION, Codigo_Marca, Fecha_Ultima_Venta, precio_abierto_superiorcosto, FechaUltimoMovimiento, CODE_PROV_O_ALT)'
             . ' VALUES (:PRODUCT_ID, :UM, :PRODUCT_NAME, :DESCRIPTION, :Codigo_Marca, :Fecha_Ultima_Venta, :precio_abierto_superiorcosto, :FechaUltimoMovimiento, :CODE_PROV_O_ALT)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
    public function update(string $id, array $data): bool {
        $sql = 'UPDATE productos SET UM = :UM, PRODUCT_NAME = :PRODUCT_NAME, DESCRIPTION = :DESCRIPTION, Codigo_Marca = :Codigo_Marca, Fecha_Ultima_Venta = :Fecha_Ultima_Venta, precio_abierto_superiorcosto = :precio_abierto_superiorcosto, FechaUltimoMovimiento = :FechaUltimoMovimiento, CODE_PROV_O_ALT = :CODE_PROV_O_ALT'
             . ' WHERE PRODUCT_ID = :PRODUCT_ID';
        $stmt = $this->pdo->prepare($sql);
        $data['PRODUCT_ID'] = $id;
        return $stmt->execute($data);
    }
    public function delete(string $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM productos WHERE PRODUCT_ID = :id');
        return $stmt->execute(['id' => $id]);
    }
}
