<?php
require_once __DIR__ . '/_util.php';

listar_admin([
    'titulo'      => 'Usuarios',
    'ruta'        => 'admin/usuarios',
    'placeholder' => 'Buscar por nombre o correo',
    'from'        => 'usuarios u',
    'select'      => 'u.id, u.nombre, u.email, u.rol, u.estado, u.created_at',
    'buscar'      => ['u.nombre', 'u.email'],
    'orden'       => 'u.nombre',
    'filtro'      => [
        'name'    => 'rol',
        'label'   => 'Todos los roles',
        'columna' => 'u.rol',
        'options' => [
            'administrador' => 'Administrador',
            'bibliotecario' => 'Bibliotecario',
            'estudiante'    => 'Estudiante',
        ],
    ],
    'columnas'    => [['Nombre'], ['Rol'], ['Estado'], ['Registro']],
    'fila'        => fn(array $r) => [
        '<strong>' . e($r['nombre']) . '</strong><small class="sub">' . e($r['email']) . '</small>',
        e(rol_etiqueta($r['rol'])),
        badge_estado($r['estado']),
        e(fecha($r['created_at'])),
    ],
]);
