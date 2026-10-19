<?php
$user  = Auth::user();
$title = $title ?? 'BiblioTech';
$side  = $user ? menu_sidebar($user['rol']) : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?> · BiblioTech</title>
    <link rel="stylesheet" href="<?= e(asset('css/app.css')) ?>">
</head>
<body>
<header class="topbar">
    <div class="wrap topbar__in">
        <a class="brand" href="<?= e(url('inicio')) ?>">BiblioTech</a>
        <?php if ($user): ?>
            <nav class="topnav" aria-label="Principal">
                <?php foreach (menu_top($user['rol']) as [$texto, $ruta]): ?>
                    <a href="<?= e(url($ruta)) ?>" class="<?= is_active($ruta) ?>"><?= e($texto) ?></a>
                <?php endforeach; ?>
                <span class="topnav__user" title="<?= e(rol_etiqueta($user['rol'])) ?>"><?= e($user['nombre']) ?></span>
                <form method="post" action="<?= e(url('logout')) ?>" class="inline">
                    <?= csrf_field() ?>
                    <button class="pill" type="submit">Salir</button>
                </form>
            </nav>
        <?php endif; ?>
    </div>
</header>

<main class="wrap shell <?= $side ? 'shell--side' : '' ?>">
    <?php if ($side): ?>
        <aside class="side" aria-label="Menú del panel">
            <p class="side__title"><?= e($side['titulo']) ?></p>
            <?php foreach ($side['items'] as [$texto, $ruta]): ?>
                <a href="<?= e(url($ruta)) ?>" class="<?= is_active($ruta) ?>"><?= e($texto) ?></a>
            <?php endforeach; ?>
        </aside>
    <?php endif; ?>

    <section class="content">
        <?php foreach (flashes() as $f): ?>
            <div class="alert alert--<?= e($f['type']) ?>" role="status"><?= e($f['msg']) ?></div>
        <?php endforeach; ?>
        <?= $content ?>
    </section>
</main>

<footer class="foot">
    <div class="wrap foot__in">
        <span>© <?= date('Y') ?> BiblioTech — Gestión de Bibliotecas</span>
        <span>Desarrollado sobre entorno LAMP</span>
    </div>
</footer>
</body>
</html>