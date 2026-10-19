<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('inicio');
}
csrf_check();
Auth::logout();
session_start();
flash('success', 'Cerraste sesión correctamente.');
redirect('login');