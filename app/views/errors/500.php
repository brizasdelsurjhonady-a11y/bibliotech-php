<div class="login"><div class="login__card">
    <h1 class="login__brand">Error</h1>
    <p class="login__sub">No se pudo completar la operación. Verifica que MySQL esté encendido y que <code>config/config.php</code> sea correcto.</p>
    <?php if (!empty($detalle)): ?>
        <pre class="debug"><?= e($detalle) ?></pre>
    <?php endif; ?>
</div></div>