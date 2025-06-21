<?php
// model/UsuarioModulo.php

class UsuarioModulo {
    /**
     * @var PDO Instancia de conexión
     */
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obtiene todos los módulos asignados a un usuario
     * @param int $userId
     * @return array
     */
    public function getByUserId(int $userId): array {
        $stmt = $this->pdo->prepare(
            'SELECT um.modulo_id, m.nombre
             FROM usuario_modulo um
             JOIN modulos m ON um.modulo_id = m.id
             WHERE um.usuario_id = :userId'
        );
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Asigna un módulo a un usuario
     * @param int $userId
     * @param int $moduleId
     * @return bool
     */
    public function create(int $userId, int $moduleId): bool {
        $stmt = $this->pdo->prepare(
            'INSERT IGNORE INTO usuario_modulo (usuario_id, modulo_id) VALUES (:userId, :moduleId)'
        );
        return $stmt->execute(['userId' => $userId, 'moduleId' => $moduleId]);
    }

    /**
     * Elimina un módulo de un usuario
     * @param int $userId
     * @param int $moduleId
     * @return bool
     */
    public function delete(int $userId, int $moduleId): bool {
        $stmt = $this->pdo->prepare(
            'DELETE FROM usuario_modulo WHERE usuario_id = :userId AND modulo_id = :moduleId'
        );
        return $stmt->execute(['userId' => $userId, 'moduleId' => $moduleId]);
    }

    /**
     * Reemplaza todos los módulos de un usuario
     * @param int $userId
     * @param array $moduleIds
     * @return bool
     */
    public function setAll(int $userId, array $moduleIds): bool {
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
