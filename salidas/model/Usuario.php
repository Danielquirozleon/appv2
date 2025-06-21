<?php
// model/Usuario.php

class Usuario {
    private $pdo;
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    public function getByUsername(string $username): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE username = :username');
        $stmt->execute(['username' => $username]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Obtiene un usuario por su identificador
     */
    public function getById(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }
    public function create(string $username, string $password, string $rol): bool {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare(
            'INSERT INTO usuarios (username, password, rol) VALUES (:username, :password, :rol)'
        );
        return $stmt->execute([
            'username' => $username,
            'password' => $hash,
            'rol'      => $rol
        ]);
    }
    public function update(int $id, string $rol, bool $activo): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE usuarios SET rol = :rol, activo = :activo WHERE id = :id'
        );
        return $stmt->execute(['rol' => $rol, 'activo' => $activo, 'id' => $id]);
    }
    public function resetPassword(int $id, string $newPassword): bool {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare(
            'UPDATE usuarios SET password = :password WHERE id = :id'
        );
        return $stmt->execute(['password' => $hash, 'id' => $id]);
    }
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE usuarios SET activo = 0 WHERE id = :id'
        );
        return $stmt->execute(['id' => $id]);
    }
    public function getAll(): array {
        return $this->pdo->query('SELECT id, username, rol, activo FROM usuarios')->fetchAll();
    }
    public function getModules(int $userId): array {
        $stmt = $this->pdo->prepare(
            'SELECT m.id, m.nombre FROM modulos m\
             JOIN usuario_modulo um ON m.id = um.modulo_id\
             WHERE um.usuario_id = :userId'
        );
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll();
    }
    public function assignModule(int $userId, int $moduleId): bool {
        $stmt = $this->pdo->prepare(
            'INSERT IGNORE INTO usuario_modulo (usuario_id, modulo_id) VALUES (:userId, :moduleId)'
        );
        return $stmt->execute(['userId' => $userId, 'moduleId' => $moduleId]);
    }
    public function removeModule(int $userId, int $moduleId): bool {
        $stmt = $this->pdo->prepare(
            'DELETE FROM usuario_modulo WHERE usuario_id = :userId AND modulo_id = :moduleId'
        );
        return $stmt->execute(['userId' => $userId, 'moduleId' => $moduleId]);
    }
    public function setModules(int $userId, array $moduleIds): bool {
        $this->pdo->beginTransaction();
        $del = $this->pdo->prepare('DELETE FROM usuario_modulo WHERE usuario_id = :userId');
        $del->execute(['userId' => $userId]);
        $ins = $this->pdo->prepare('INSERT INTO usuario_modulo (usuario_id, modulo_id) VALUES (:userId, :moduleId)');
        foreach ($moduleIds as $modId) {
            $ins->execute(['userId' => $userId, 'moduleId' => $modId]);
        }
        return $this->pdo->commit();
    }
}
