<?php $title = $title ?? 'BiblioTech'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?> · BiblioTech</title>
    <link rel="stylesheet" href="<?= e(asset('css/app.css')) ?>">
</head>
<body class="body--guest">
<main class="guest">
    <?php foreach (flashes() as $f): ?>
        <div class="alert alert--<?= e($f['type']) ?>" role="status"><?= e($f['msg']) ?></div>
    <?php endforeach; ?>
    <?= $content ?>
</main>
<footer class="foot foot--guest">
    <div class="wrap foot__in">
        <span>© <?= date('Y') ?> BiblioTech — Gestión de Bibliotecas</span>
        <span>Desarrollado sobre entorno LAMP</span>
    </div>
</footer>
</body>
</html>