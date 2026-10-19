<h1><?= e($titulo) ?></h1>
<p class="muted">
    <?= (int) $p['total'] ?> <?= $p['total'] === 1 ? 'registro encontrado' : 'registros encontrados' ?> · Solo lectura
</p>

<form method="get" action="<?= e(url($ruta)) ?>" class="filters">
    <input type="hidden" name="r" value="<?= e($ruta) ?>">
    <input type="search" name="q" value="<?= e($q) ?>" placeholder="<?= e($placeholder) ?>" aria-label="Buscar">
    <?php if ($filtro): ?>
        <select name="<?= e($filtro['name']) ?>" aria-label="<?= e($filtro['label']) ?>">
            <option value=""><?= e($filtro['label']) ?></option>
            <?php foreach ($filtro['options'] as $valor => $texto): ?>
                <option value="<?= e($valor) ?>" <?= $filtro['actual'] === (string) $valor ? 'selected' : '' ?>><?= e($texto) ?></option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>
    <button class="btn btn--dark" type="submit">Filtrar</button>
</form>

<div class="table-wrap">
    <table class="tabla">
        <thead>
            <tr>
                <?php foreach ($columnas as $col): ?>
                    <th class="<?= !empty($col[1]) ? 'num' : '' ?>"><?= e($col[0]) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
        <?php if (!$filas): ?>
            <tr><td colspan="<?= count($columnas) ?>" class="empty-cell">No se encontraron registros con esos criterios.</td></tr>
        <?php endif; ?>
        <?php foreach ($filas as $fila): ?>
            <tr>
                <?php foreach ($fila as $i => $celda): ?>
                    <td class="<?= !empty($columnas[$i][1]) ? 'num' : '' ?>"><?= $celda ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= paginador($p, $ruta, $filtros) ?>
