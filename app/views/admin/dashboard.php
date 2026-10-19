<h1>Dashboard</h1>
<p class="muted">Estadísticas generales de la biblioteca.</p>

<div class="stats">
    <div class="stat"><span>Libros registrados</span><strong><?= $stats['libros'] ?></strong></div>
    <div class="stat"><span>Ejemplares disponibles</span><strong><?= $stats['stock_disp'] ?> <small>/ <?= $stats['stock_total'] ?></small></strong></div>
    <div class="stat"><span>Estudiantes</span><strong><?= $stats['estudiantes'] ?></strong></div>
    <div class="stat"><span>Usuarios totales</span><strong><?= $stats['usuarios'] ?></strong></div>
    <div class="stat"><span>Préstamos activos</span><strong><?= $stats['activos'] ?></strong></div>
    <div class="stat stat--warn"><span>Préstamos vencidos</span><strong><?= $stats['vencidos'] ?></strong></div>
    <div class="stat"><span>Préstamos (últimos 30 días)</span><strong><?= $stats['prestamos_30d'] ?></strong></div>
    <div class="stat"><span>Reservas pendientes</span><strong><?= $stats['reservas'] ?></strong></div>
    <div class="stat stat--warn"><span>Multas pendientes</span><strong><?= $stats['multas_n'] ?> <small>· S/ <?= number_format($stats['multas_monto'], 2) ?></small></strong></div>
</div>

<div class="grid-2">
    <section class="panel">
        <h2>Libros más prestados</h2>
        <?php if (!$topLibros): ?><p class="muted">Aún no hay préstamos.</p><?php endif; ?>
        <ol class="ranking">
            <?php foreach ($topLibros as $r): ?>
                <li><span><?= e($r['titulo']) ?></span><b><?= (int) $r['n'] ?></b></li>
            <?php endforeach; ?>
        </ol>
    </section>

    <section class="panel">
        <h2>Estudiantes con más préstamos</h2>
        <?php if (!$topEstudiantes): ?><p class="muted">Aún no hay préstamos.</p><?php endif; ?>
        <ol class="ranking">
            <?php foreach ($topEstudiantes as $r): ?>
                <li><span><?= e($r['nombre']) ?></span><b><?= (int) $r['n'] ?></b></li>
            <?php endforeach; ?>
        </ol>
    </section>
</div>

<section class="panel">
    <h2>Reservas por expirar (próximas 24 horas)</h2>
    <?php if (!$porExpirar): ?>
        <p class="muted">No hay reservas próximas a expirar.</p>
    <?php else: ?>
        <table class="tabla">
            <thead><tr><th>Libro</th><th>Usuario</th><th>Expira</th></tr></thead>
            <tbody>
            <?php foreach ($porExpirar as $r): ?>
                <tr><td><?= e($r['titulo']) ?></td><td><?= e($r['usuario']) ?></td><td><?= e(fecha($r['fecha_expiracion'], 'd/m/Y H:i')) ?></td></tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>