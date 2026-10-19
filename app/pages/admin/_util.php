<?php
// Utilidades compartidas por los listados del administrador.

function badge_estado(string $estado): string
{
    static $mapa = [
        'activo' => 'ok', 'devuelto' => 'ok', 'confirmada' => 'ok', 'pagada' => 'ok',
        'pendiente' => 'warn', 'condonada' => 'warn',
        'vencido' => 'bad', 'expirada' => 'bad', 'cancelada' => 'bad', 'cancelado' => 'bad', 'bloqueado' => 'bad',
    ];
    $clase = $mapa[$estado] ?? 'warn';
    return '<span class="badge badge--' . $clase . '">' . e(ucfirst($estado)) . '</span>';
}

/**
 * Pinta un listado de solo lectura con búsqueda, filtro opcional y paginación.
 * Claves de $c: titulo, ruta, placeholder, from, select, buscar[], orden,
 *               filtro (name, label, columna, options) opcional, columnas[], fila (callable).
 */
function listar_admin(array $c): void
{
    $q      = trim((string) ($_GET['q'] ?? ''));
    $page   = (int) ($_GET['page'] ?? 1);
    $where  = [];
    $params = [];

    if ($q !== '') {
        $partes = [];
        foreach ($c['buscar'] as $i => $col) {
            $partes[]       = "$col LIKE :q$i";
            $params[":q$i"] = "%{$q}%";
        }
        $where[] = '(' . implode(' OR ', $partes) . ')';
    }

    $filtroVista = null;
    $actual      = '';
    if (!empty($c['filtro'])) {
        $f = $c['filtro'];
        $v = (string) ($_GET[$f['name']] ?? '');
        if ($v !== '' && array_key_exists($v, $f['options'])) {
            $actual            = $v;
            $where[]           = $f['columna'] . ' = :filtro';
            $params[':filtro'] = $v;
        }
        $filtroVista = $f + ['actual' => $actual];
    }
    $sqlWhere = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    $total = (int) Database::value("SELECT COUNT(*) FROM {$c['from']} $sqlWhere", $params);
    $p     = paginar($total, 10, $page);

    $filas = Database::all(
        "SELECT {$c['select']} FROM {$c['from']} $sqlWhere
          ORDER BY {$c['orden']}
          LIMIT {$p['limite']} OFFSET {$p['offset']}",
        $params
    );

    $celdas  = array_map($c['fila'], $filas);
    $filtros = array_filter(['q' => $q, ($c['filtro']['name'] ?? 'f') => $actual]);

    render('admin/listado', [
        'title'       => $c['titulo'],
        'titulo'      => $c['titulo'],
        'ruta'        => $c['ruta'],
        'placeholder' => $c['placeholder'],
        'filtro'      => $filtroVista,
        'q'           => $q,
        'columnas'    => $c['columnas'],
        'filas'       => $celdas,
        'p'           => $p,
        'filtros'     => $filtros,
    ]);
}
