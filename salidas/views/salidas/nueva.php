<?php
// views/salidas/nueva.php
require_once __DIR__ . '/../templates/layout.php';
?>
<div class="container mt-4">
    <h2>Nueva Salida</h2>
    <form action="<?= BASE_URL ?>?r=salida/create" method="post">
        <div class="form-group mb-3">
            <label for="numero_salida">Número de Salida</label>
            <input type="text" name="numero_salida" id="numero_salida" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="numero_cliente">Número de Cliente</label>
            <input type="number" name="numero_cliente" id="numero_cliente" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="tipo">Tipo</label>
            <select name="tipo" id="tipo" class="form-control">
                <option value="cambio_fisico">Cambio Físico</option>
                <option value="complemento_entrega">Complemento de Entrega</option>
                <option value="motivo_libre">Motivo Libre</option>
                <option value="salida_oficina">Salida Oficina</option>
            </select>
        </div>
        <h4>Productos</h4>
        <div id="productos-list" class="mb-3"></div>
        <button type="button" id="add-product" class="btn btn-secondary mb-3">Agregar Producto</button>
        <button type="submit" class="btn btn-primary">Guardar Salida</button>
    </form>
</div>
<script src="<?= BASE_URL ?>assets/js/productos.js"></script>
<?php include __DIR__ . '/../templates/footer.php'; ?>
