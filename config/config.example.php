<?php
// Copia este archivo como config/config.php y ajusta tus datos.
return [
    'app_name' => 'BiblioTech',
    'debug'    => true, // pon false al entregar el proyecto
    'db' => [
        'host'    => '127.0.0.1',
        'port'    => 3306,   // cambia a 3307 si tu MySQL usa otro puerto
        'name'    => 'bibliotech',
        'user'    => 'root',
        'pass'    => '',
        'charset' => 'utf8mb4',
    ],
];
