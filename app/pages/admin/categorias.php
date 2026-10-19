<?php
require_once __DIR__ . '/_util.php';

listar_admin([
    'titulo'      => 'Categorías',
    'ruta'        => 'admin/categorias',
    'placeholder' => 'Buscar por nombre o descripción',
    'from'        => 'categorias c',
    'select'      => 'c.id, c.nombre, c.descripcion,
                      (SELECT COUNT(*) FROM libros l WHERE l.id_categoria = c.id) AS libros',
    'buscar'      => ['c.nombre', 'c.descripcion'],
    'orden'       => 'c.nombre',
    'columnas'    => [['Nombre'], ['Descripción'], ['Libros', true]],
    'fila'        => fn(array $r) => [
        '<strong>' . e($r['nombre']) . '</strong>',
        e($r['descripcion'] ?: '—'),
        (int) $r['libros'],
    ],
]);
