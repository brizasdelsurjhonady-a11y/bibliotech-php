<?php
require_once __DIR__ . '/_util.php';

listar_admin([
    'titulo'      => 'Multas',
    'ruta'        => 'admin/multas',
    'placeholder' => 'Buscar por usuario o libro',
    'from'        => 'multas m
                      JOIN prestamos p ON p.id = m.id_prestamo
                      JOIN usuarios u ON u.id = p.id_usuario
                      JOIN libros l ON l.id = p.id_libro',
    'select'      => 'm.id, u.nombre AS usuario, l.titulo, m.monto, m.estado, m.fecha_generacion, m.fecha_pago',
    'buscar'      => ['u.nombre', 'l.titulo'],
    'orden'       => 'm.fecha_generacion DESC, m.id DESC',
    'filtro'      => [
        'name'    => 'estado',
        'label'   => 'Todos los estados',
        'columna' => 'm.estado',
        'options' => [
            'pendiente' => 'Pendiente',
            'pagada'    => 'Pagada',
            'condonada' => 'Condonada',
        ],
    ],
    'columnas'    => [['Usuario'], ['Libro'], ['Monto', true], ['Generada'], ['Pagada el'], ['Estado']],
    'fila'        => fn(array $r) => [
        e($r['usuario']),
        '<strong>' . e($r['titulo']) . '</strong>',
        'S/ ' . number_format((float) $r['monto'], 2),
        e(fecha($r['fecha_generacion'])),
        e(fecha($r['fecha_pago'])),
        badge_estado($r['estado']),
    ],
]);
