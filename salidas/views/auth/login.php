<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Salidas Internas</title>
    <link rel="stylesheet" href="/salidas/assets/css/styles.css">
</head>
<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container">
        <h2>Sistema de Salidas Internas - Login</h2>

        <?php if (!empty($error)): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="?r=auth/login">
            <div>
                <label for="username">Usuario</label>
                <input type="text" name="username" id="username" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
            </div>
            <div>
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div>
                <button type="submit">Entrar</button>
            </div>
        </form>
    </div>

    <?php include __DIR__ . '/../templates/footer.php'; ?>
</body>
</html>
