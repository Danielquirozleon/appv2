<?php
// views/importacion/importar_txt.php
require_once __DIR__ . '/../templates/layout.php';
?>
<div class="container mt-4">
    <h2>Importación Masiva</h2>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Importación exitosa.</div>
    <?php endif; ?>
    <form action="<?= BASE_URL ?>?r=import/import" method="post" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label for="tipo">Tipo de importación</label>
            <select name="tipo" id="tipo" class="form-control" required>
                <option value="clientes">Clientes</option>
                <option value="productos">Productos</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="txt_file">Archivo TXT (tabulado)</label>
            <input type="file" name="txt_file" id="txt_file" class="form-control" accept=".txt" required>
        </div>
        <button type="submit" class="btn btn-primary">Importar</button>
    </form>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>
