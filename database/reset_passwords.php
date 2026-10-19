<?php
// Uso (solo en tu PC):  php database\reset_passwords.php
// Deja contraseñas conocidas para probar el sistema en local.
if (PHP_SAPI !== 'cli') {
    exit('Este script solo se ejecuta desde la terminal.');
}

require __DIR__ . '/../app/helpers.php';
require __DIR__ . '/../app/Database.php';

$clave = 'Biblio2026';
$hash  = password_hash($clave, PASSWORD_BCRYPT);

$usuarios = ['admin@bibliotech.test', 'biblio@bibliotech.test', 'carlos@bibliotech.test'];

foreach ($usuarios as $email) {
    $n = Database::query('UPDATE usuarios SET password_hash = ? WHERE email = ?', [$hash, $email])->rowCount();
    echo ($n ? '[OK] ' : '[--] ') . $email . PHP_EOL;
}
echo PHP_EOL . "Contraseña de prueba: {$clave}" . PHP_EOL;