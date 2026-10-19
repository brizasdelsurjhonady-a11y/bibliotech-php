<?php
require_once __DIR__ . '/_util.php';

listar_admin([
    'titulo'      => 'Préstamos',
    'ruta'        => 'admin/prestamos',
    'placeholder' => 'Buscar por usuario o libro',
    'from'        => 'prestamos p
                      JOIN usuarios u ON u.id = p.id_usuario
                      JOIN libros l ON l.id = p.id_libro',
    'select'      => 'p.id, u.nombre AS usuario, l.titulo, p.fecha_prestamo,
                      p.fecha_devolucion_esperada, p.fecha_devolucion_real, p.estado',
    'buscar'      => ['u.nombre', 'l.titulo'],
    'orden'       => 'p.fecha_prestamo DESC, p.id DESC',
    'filtro'      => [
        'name'    => 'estado',
        'label'   => 'Todos los estados',
        'columna' => 'p.estado',
        'options' => [
            'activo'    => 'Activo',
            'devuelto'  => 'Devuelto',
            'vencido'   => 'Vencido',
            'cancelado' => 'Cancelado',
        ],
    ],
    'columnas'    => [['Usuario'], ['Libro'], ['Préstamo'], ['Devolución esperada'], ['Devuelto'], ['Estado']],
    'fila'        => fn(array $r) => [
        e($r['usuario']),
        '<strong>' . e($r['titulo']) . '</strong>',
        e(fecha($r['fecha_prestamo'])),
        e(fecha($r['fecha_devolucion_esperada'])),
        e(fecha($r['fecha_devolucion_real'])),
        badge_estado($r['estado']),
    ],
]);
