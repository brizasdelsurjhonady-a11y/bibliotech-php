<?php

define('APP_PATH', __DIR__);

date_default_timezone_set('America/Lima');

require APP_PATH . '/helpers.php';
require APP_PATH . '/Database.php';
require APP_PATH . '/Auth.php';
require APP_PATH . '/menus.php';

session_name('bibliotech_sid');
session_set_cookie_params(['lifetime' => 0, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
session_start();

set_exception_handler(function (Throwable $ex) {
    http_response_code(500);
    $detalle = config('debug') ? $ex->getMessage() : '';
    render('errors/500', ['title' => 'Error del servidor', 'detalle' => $detalle], 'guest');
});