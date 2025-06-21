<?php
// config/app.php

// URL base de la aplicación (ajustar al entorno)
define('BASE_URL', 'http://localhost/sistema_salidas/');
// Nombre de la aplicación
define('APP_NAME', 'Sistema de Salidas Internas');
// Timeout de sesión en segundos
define('SESSION_TIMEOUT', 3600);
// Umbral de alerta en horas para recolecciones pendientes
define('RECOLECCION_ALERT_HOURS', 48);
// Formato de fecha
define('DATE_FORMAT', 'Y-m-d H:i:s');

// Autocarga de clases: busca en model/ y controller/
spl_autoload_register(function($class) {
    foreach (['model/', 'controller/'] as $path) {
        $file = __DIR__ . '/../' . $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
