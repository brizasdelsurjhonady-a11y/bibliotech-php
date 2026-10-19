<?php
// Controlador frontal: todas las páginas pasan por aquí (index.php?r=ruta)
require __DIR__ . '/../app/bootstrap.php';

$route  = trim((string) ($_GET['r'] ?? 'inicio'), '/');
$routes = require APP_PATH . '/routes.php';

if (!isset($routes[$route])) {
    http_response_code(404);
    render('errors/404', ['title' => 'Página no encontrada'], Auth::check() ? 'app' : 'guest');
    exit;
}

[$roles, $archivo] = $routes[$route];
$GLOBALS['route'] = $route;

if ($roles !== null) {
    Auth::exigir($roles);
}

require APP_PATH . '/' . $archivo;