<?php
// model/Modulo.php

class Modulo {
    /**
     * @var PDO Instancia de conexión
     */
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obtiene todos los módulos
     * @return array
     */
    public function getAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM modulos');
        return $stmt->fetchAll();
    }

    /**
     * Obtiene un módulo por ID
     * @param int $id
     * @return array|null
     */
    public function getById(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM modulos WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Crea un nuevo módulo
     * @param string $nombre
     * @return bool
     */
    public function create(string $nombre): bool {
        $stmt = $this->pdo->prepare('INSERT INTO modulos (nombre) VALUES (:nombre)');
        return $stmt->execute(['nombre' => $nombre]);
    }

    /**
     * Actualiza el nombre de un módulo
     * @param int $id
     * @param string $nombre
     * @return bool
     */
    public function update(int $id, string $nombre): bool {
        $stmt = $this->pdo->prepare('UPDATE modulos SET nombre = :nombre WHERE id = :id');
        return $stmt->execute(['nombre' => $nombre, 'id' => $id]);
    }

    /**
     * Elimina un módulo
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM modulos WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
