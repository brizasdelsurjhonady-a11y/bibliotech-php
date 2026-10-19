<?php

final class Auth
{
    public const HOME = [
        'administrador' => 'admin/dashboard',
        'bibliotecario' => 'biblio/libros',
        'estudiante'    => 'catalogo',
    ];

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function homeRoute(): string
    {
        $rol = $_SESSION['user']['rol'] ?? '';
        return self::HOME[$rol] ?? 'login';
    }

    /** Devuelve null si todo va bien, o un mensaje de error. */
    public static function attempt(string $email, string $password): ?string
    {
        $ahora = time();
        if (($_SESSION['fallos'] ?? 0) >= 5 && $ahora - ($_SESSION['fallo_ts'] ?? 0) < 60) {
            return 'Demasiados intentos fallidos. Espera un minuto e inténtalo otra vez.';
        }

        $u = Database::one('SELECT * FROM usuarios WHERE email = ? LIMIT 1', [$email]);

        if (!$u || !password_verify($password, $u['password_hash'])) {
            $_SESSION['fallos']   = (($_SESSION['fallos'] ?? 0) >= 5 ? 0 : ($_SESSION['fallos'] ?? 0)) + 1;
            $_SESSION['fallo_ts'] = $ahora;
            return 'Correo o contraseña incorrectos.';
        }
        if ($u['estado'] !== 'activo') {
            return 'Tu cuenta está bloqueada. Consulta con el administrador.';
        }

        session_regenerate_id(true);
        unset($_SESSION['fallos'], $_SESSION['fallo_ts']);
        $_SESSION['user'] = [
            'id'     => (int) $u['id'],
            'nombre' => $u['nombre'],
            'email'  => $u['email'],
            'rol'    => $u['rol'],
        ];
        return null;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }

    /** Exige sesión y, opcionalmente, uno de los roles indicados ('*' = cualquiera). */
    public static function exigir(array $roles): void
    {
        if (!self::check()) {
            flash('warning', 'Inicia sesión para continuar.');
            redirect('login');
        }
        if (!in_array('*', $roles, true) && !in_array($_SESSION['user']['rol'], $roles, true)) {
            http_response_code(403);
            render('errors/403', ['title' => 'Acceso denegado']);
            exit;
        }
    }
}