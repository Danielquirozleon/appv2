<?php
// router.php

// Carga configuración y conexión a BD
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';

// Inicia sesión y maneja timeout
session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_TIMEOUT)) {
    session_unset();
    session_destroy();
}
$_SESSION['LAST_ACTIVITY'] = time();

// Determina ruta: controlador/acción (p. ej. ?r=auth/login)
$route  = $_GET['r'] ?? 'auth/login';
if (!preg_match('/^[a-zA-Z0-9_]+(\/[a-zA-Z0-9_]+)?$/', $route)) {
    $route = 'auth/login';
}
[$ctrl, $action] = array_pad(explode('/', $route, 2), 2, 'index');
$controllerName = ucfirst($ctrl) . 'Controller';
$controllerFile = __DIR__ . '/controller/' . $controllerName . '.php';

// Despacho de controlador y acción
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerName)) {
        $controller = new $controllerName($pdo);
        if (method_exists($controller, $action)) {
            $controller->{$action}();
        } else {
            header('HTTP/1.0 404 Not Found');
            echo "Acción '{$action}' no encontrada.";
        }
    } else {
        header('HTTP/1.0 404 Not Found');
        echo "Controlador '{$controllerName}' no encontrado.";
    }
} else {
    header('HTTP/1.0 404 Not Found');
    echo "Controlador '{$controllerName}' no encontrado.";
}
