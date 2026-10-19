<?php
require_once __DIR__ . '/_util.php';

listar_admin([
    'titulo'      => 'Reservas',
    'ruta'        => 'admin/reservas',
    'placeholder' => 'Buscar por usuario o libro',
    'from'        => 'reservas r
                      JOIN usuarios u ON u.id = r.id_usuario
                      JOIN libros l ON l.id = r.id_libro',
    'select'      => 'r.id, u.nombre AS usuario, l.titulo, r.fecha_reserva, r.fecha_expiracion, r.estado',
    'buscar'      => ['u.nombre', 'l.titulo'],
    'orden'       => 'r.fecha_reserva DESC, r.id DESC',
    'filtro'      => [
        'name'    => 'estado',
        'label'   => 'Todos los estados',
        'columna' => 'r.estado',
        'options' => [
            'pendiente'  => 'Pendiente',
            'confirmada' => 'Confirmada',
            'expirada'   => 'Expirada',
            'cancelada'  => 'Cancelada',
        ],
    ],
    'columnas'    => [['Usuario'], ['Libro'], ['Reservada'], ['Expira'], ['Estado']],
    'fila'        => fn(array $r) => [
        e($r['usuario']),
        '<strong>' . e($r['titulo']) . '</strong>',
        e(fecha($r['fecha_reserva'], 'd/m/Y H:i')),
        e(fecha($r['fecha_expiracion'], 'd/m/Y H:i')),
        badge_estado($r['estado']),
    ],
]);
