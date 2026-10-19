<h1>Libros</h1>
<p class="muted">
    <?= (int) $p['total'] ?> <?= $p['total'] === 1 ? 'registro encontrado' : 'registros encontrados' ?> · Solo lectura
</p>

<form method="get" action="<?= e(url('biblio/libros')) ?>" class="filters">
    <input type="hidden" name="r" value="biblio/libros">
    <input type="search" name="q" value="<?= e($q) ?>" placeholder="Buscar por título, autor o ISBN" aria-label="Buscar">
    <select name="categoria" aria-label="Categoría">
        <option value="">Todas las categorías</option>
        <?php foreach ($categorias as $c): ?>
            <option value="<?= (int) $c['id'] ?>" <?= $categoria === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['nombre']) ?></option>
        <?php endforeach; ?>
    </select>
    <button class="btn btn--dark" type="submit">Filtrar</button>
</form>

<div class="table-wrap">
    <table class="tabla">
        <thead>
            <tr><th>Título</th><th>Autor</th><th>Categoría</th><th class="num">Stock</th></tr>
        </thead>
        <tbody>
        <?php if (!$libros): ?>
            <tr><td colspan="4" class="empty-cell">No se encontraron libros con esos criterios.</td></tr>
        <?php endif; ?>
        <?php foreach ($libros as $l):
            $clase = $l['stock_disponible'] == 0 ? 'badge--bad' : ($l['stock_disponible'] <= 1 ? 'badge--warn' : 'badge--ok'); ?>
            <tr>
                <td>
                    <strong><?= e($l['titulo']) ?></strong>
                    <small class="sub">ISBN: <?= e($l['isbn'] ?: '—') ?></small>
                </td>
                <td><?= e($l['autor']) ?></td>
                <td><?= e($l['categoria'] ?: 'Sin categoría') ?></td>
                <td class="num"><span class="badge <?= $clase ?>"><?= (int) $l['stock_disponible'] ?> / <?= (int) $l['stock_total'] ?></span></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= paginador($p, 'biblio/libros', $filtros) ?>