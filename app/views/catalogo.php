<h1>Catálogo de libros</h1>
<p class="muted"><?= (int) $p['total'] ?> <?= $p['total'] === 1 ? 'libro' : 'libros' ?> en el catálogo</p>

<form method="get" action="<?= e(url('catalogo')) ?>" class="filters">
    <input type="hidden" name="r" value="catalogo">
    <input type="search" name="q" value="<?= e($q) ?>" placeholder="Buscar por título, autor o ISBN" aria-label="Buscar">
    <select name="categoria" aria-label="Categoría">
        <option value="">Todas las categorías</option>
        <?php foreach ($categorias as $c): ?>
            <option value="<?= (int) $c['id'] ?>" <?= $categoria === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['nombre']) ?></option>
        <?php endforeach; ?>
    </select>
    <button class="btn btn--dark" type="submit">Filtrar</button>
</form>

<?php if (!$libros): ?>
    <div class="empty"><p>No se encontraron libros con esos criterios.</p></div>
<?php endif; ?>

<div class="cards">
    <?php foreach ($libros as $l):
        $img  = portada_segura($l['portada_url']);
        $disp = (int) $l['stock_disponible'];
        $clase = $disp === 0 ? 'badge--bad' : ($disp <= 1 ? 'badge--warn' : 'badge--ok'); ?>
        <article class="card">
            <div class="card__cover" data-inicial="<?= e(inicial($l['titulo'])) ?>">
                <?php if ($img): ?>
                    <img src="<?= e($img) ?>" alt="Portada de <?= e($l['titulo']) ?>" loading="lazy" onerror="this.remove()">
                <?php endif; ?>
            </div>
            <div class="card__body">
                <h2><?= e($l['titulo']) ?></h2>
                <p class="card__autor"><?= e($l['autor']) ?></p>
                <p class="card__meta"><?= e($l['categoria'] ?: 'Sin categoría') ?><?= $l['anio'] ? ' · ' . (int) $l['anio'] : '' ?></p>
                <span class="badge <?= $clase ?>"><?= $disp > 0 ? "Disponible: {$disp} de " . (int) $l['stock_total'] : 'Sin ejemplares' ?></span>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<?= paginador($p, 'catalogo', $filtros) ?>