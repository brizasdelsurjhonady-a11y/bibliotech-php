<?php
// 'ruta' => [roles permitidos (null = pública, '*' = cualquier sesión), archivo]
$pronto = 'pages/proximamente.php';

return [
    // Comunes
    'inicio'   => [['*'], 'pages/inicio.php'],
    'login'    => [null,  'pages/auth/login.php'],
    'logout'   => [['*'], 'pages/auth/logout.php'],
    'catalogo' => [['*'], 'pages/catalogo.php'],

    // Administrador
    'admin/dashboard'     => [['administrador'], 'pages/admin/dashboard.php'],
    'admin/libros' => [['administrador'], 'pages/admin/libros.php'],
    'admin/categorias'    => [['administrador'], 'pages/admin/categorias.php'],
    'admin/usuarios'      => [['administrador'], 'pages/admin/usuarios.php'],
    'admin/configuracion' => [['administrador'], $pronto],
    'admin/reservas'      => [['administrador'], 'pages/admin/reservas.php'],
    'admin/prestamos'     => [['administrador'], 'pages/admin/prestamos.php'],
    'admin/multas'        => [['administrador'], 'pages/admin/multas.php'],

    // Bibliotecaria
    'biblio/libros'     => [['bibliotecario'], 'pages/biblio/libros.php'],
    'biblio/reservas'   => [['bibliotecario'], $pronto],
    'biblio/prestamos'  => [['bibliotecario'], $pronto],
    'biblio/multas'     => [['bibliotecario'], $pronto],

    // Estudiante
    'estudiante/reservas'   => [['estudiante'], $pronto],
    'estudiante/prestamos'  => [['estudiante'], $pronto],
];