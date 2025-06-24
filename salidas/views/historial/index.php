<?php
// views/salidas/index.php
require_once __DIR__ . '/../templates/layout.php';
?>
<div class="container mt-4">
    <h2>Listado de Salidas</h2>
    <a href="<?= BASE_URL ?>?r=salida/nueva" class="btn btn-success mb-3">Nueva Salida</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Número</th>
                <th>Cliente</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach (\$salidas as \$s): ?>
            <tr>
                <td><?= htmlspecialchars(\$s['numero_salida']) ?></td>
                <td><?= htmlspecialchars(\$s['numero_cliente']) ?></td>
                <td><?= htmlspecialchars(\$s['tipo']) ?></td>
                <td><?= htmlspecialchars(\$s['fecha']) ?></td>
                <td><?= htmlspecialchars(\$s['estado']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>
