<?php
$vencidoSql = "(estado = 'vencido' OR (estado = 'activo' AND fecha_devolucion_esperada < CURDATE()))";

$stats = [
    'libros'        => (int) Database::value('SELECT COUNT(*) FROM libros'),
    'stock_total'   => (int) Database::value('SELECT COALESCE(SUM(stock_total),0) FROM libros'),
    'stock_disp'    => (int) Database::value('SELECT COALESCE(SUM(stock_disponible),0) FROM libros'),
    'estudiantes'   => (int) Database::value("SELECT COUNT(*) FROM usuarios WHERE rol = 'estudiante'"),
    'usuarios'      => (int) Database::value('SELECT COUNT(*) FROM usuarios'),
    'activos'       => (int) Database::value("SELECT COUNT(*) FROM prestamos WHERE estado = 'activo'"),
    'vencidos'      => (int) Database::value("SELECT COUNT(*) FROM prestamos WHERE $vencidoSql"),
    'prestamos_30d' => (int) Database::value('SELECT COUNT(*) FROM prestamos WHERE fecha_prestamo >= CURDATE() - INTERVAL 30 DAY'),
    'reservas'      => (int) Database::value("SELECT COUNT(*) FROM reservas WHERE estado = 'pendiente' AND fecha_expiracion >= NOW()"),
    'multas_n'      => (int) Database::value("SELECT COUNT(*) FROM multas WHERE estado = 'pendiente'"),
    'multas_monto'  => (float) Database::value("SELECT COALESCE(SUM(monto),0) FROM multas WHERE estado = 'pendiente'"),
];

$topLibros = Database::all(
    'SELECT l.titulo, COUNT(*) AS n
       FROM prestamos p JOIN libros l ON l.id = p.id_libro
      GROUP BY l.id, l.titulo ORDER BY n DESC, l.titulo LIMIT 5'
);

$topEstudiantes = Database::all(
    "SELECT u.nombre, COUNT(*) AS n
       FROM prestamos p JOIN usuarios u ON u.id = p.id_usuario
      WHERE u.rol = 'estudiante'
      GROUP BY u.id, u.nombre ORDER BY n DESC, u.nombre LIMIT 5"
);

$porExpirar = Database::all(
    "SELECT r.fecha_expiracion, u.nombre AS usuario, l.titulo
       FROM reservas r
       JOIN usuarios u ON u.id = r.id_usuario
       JOIN libros l   ON l.id = r.id_libro
      WHERE r.estado = 'pendiente'
        AND r.fecha_expiracion BETWEEN NOW() AND NOW() + INTERVAL 24 HOUR
      ORDER BY r.fecha_expiracion"
);

render('admin/dashboard', compact('stats', 'topLibros', 'topEstudiantes', 'porExpirar') + ['title' => 'Dashboard']);