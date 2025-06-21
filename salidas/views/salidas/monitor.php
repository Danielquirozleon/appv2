<?php
// views/salidas/monitor.php
require_once __DIR__ . '/../templates/layout.php';
?>
<div class="container mt-4">
    <h2>Monitor de Cambios Físicos Pendientes</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Número</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach (\$pendientes as \$s): ?>
            <tr>
                <td><?= htmlspecialchars(\$s['numero_salida']) ?></td>
                <td><?= htmlspecialchars(\$s['numero_cliente']) ?></td>
                <td><?= htmlspecialchars(\$s['fecha']) ?></td>
                <td>
                    <a href="<?= BASE_URL ?>?r=monitor/concluir&id=<?= \$s['id'] ?>" class="btn btn-success btn-sm">Concluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
