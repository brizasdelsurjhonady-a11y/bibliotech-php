<?php
$q         = trim((string) ($_GET['q'] ?? ''));
$categoria = (int) ($_GET['categoria'] ?? 0);
$page      = (int) ($_GET['page'] ?? 1);

$where  = [];
$params = [];
if ($q !== '') {
    $where[] = '(l.titulo LIKE :q1 OR l.autor LIKE :q2 OR l.isbn LIKE :q3)';
    $params[':q1'] = $params[':q2'] = $params[':q3'] = "%{$q}%";
}
if ($categoria > 0) {
    $where[]            = 'l.id_categoria = :cat';
    $params[':cat']     = $categoria;
}
$sqlWhere = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$total = (int) Database::value("SELECT COUNT(*) FROM libros l $sqlWhere", $params);
$p     = paginar($total, 12, $page);

$libros = Database::all(
    "SELECT l.*, c.nombre AS categoria
       FROM libros l LEFT JOIN categorias c ON c.id = l.id_categoria
       $sqlWhere
      ORDER BY l.titulo
      LIMIT {$p['limite']} OFFSET {$p['offset']}",
    $params
);
$categorias = Database::all('SELECT id, nombre FROM categorias ORDER BY nombre');

$filtros = array_filter(['q' => $q, 'categoria' => $categoria ?: null]);

render('catalogo', compact('libros', 'categorias', 'p', 'q', 'categoria', 'filtros') + ['title' => 'Catálogo']);