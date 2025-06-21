<?php
// views/usuarios/index.php
require_once __DIR__ . '/../templates/layout.php';
?>
<div class="container mt-4">
    <h2>Gestión de Usuarios</h2>
    <a href="<?= BASE_URL ?>?r=user/form" class="btn btn-success mb-3">Nuevo Usuario</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Activo</th>
                <th>Módulos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
            <?php $mods = (new Usuario($pdo))->getModules($u['id']); ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['username']) ?></td>
                <td><?= htmlspecialchars($u['rol']) ?></td>
                <td><?= $u['activo'] ? 'Sí' : 'No' ?></td>
                <td>
                    <?php foreach ($mods as $m): ?>
                        <span class="badge bg-primary"><?= htmlspecialchars($m['nombre']) ?></span>
                    <?php endforeach; ?>
                </td>
                <td>
                    <a href="<?= BASE_URL ?>?r=user/form&id=<?= $u['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="<?= BASE_URL ?>?r=user/delete&id=<?= $u['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Desactivar usuario?'
