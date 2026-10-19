<div class="login">
    <div class="login__card">
        <h1 class="login__brand">BiblioTech</h1>
        <p class="login__sub">Sistema de gestión bibliotecaria</p>

        <?php if (!empty($error)): ?>
            <div class="alert alert--error" role="alert"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= e(url('login')) ?>" novalidate>
            <?= csrf_field() ?>
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="<?= e($email) ?>" required autofocus autocomplete="username">

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required autocomplete="current-password">

            <button class="btn btn--gold btn--block" type="submit">Ingresar</button>
        </form>
    </div>
</div>