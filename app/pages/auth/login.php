<?php
if (Auth::check()) {
    redirect(Auth::homeRoute());
}

$error = null;
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email    = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = 'Ingresa tu correo y tu contraseña.';
    } else {
        $error = Auth::attempt($email, $password);
        if ($error === null) {
            flash('success', '¡Bienvenido, ' . Auth::user()['nombre'] . '!');
            redirect(Auth::homeRoute());
        }
    }
}

render('auth/login', ['title' => 'Iniciar sesión', 'error' => $error, 'email' => $email], 'guest');