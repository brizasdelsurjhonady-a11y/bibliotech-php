<?php

function config(string $key)
{
    static $cfg = null;
    if ($cfg === null) {
        $cfg = require dirname(__DIR__) . '/config/config.php';
    }
    return $cfg[$key] ?? null;
}

function e($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function base_url(): string
{
    $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    return rtrim($dir, '/');
}

function asset(string $ruta): string
{
    return base_url() . '/' . ltrim($ruta, '/');
}

function url(string $ruta, array $params = []): string
{
    return base_url() . '/index.php?' . http_build_query(array_merge(['r' => $ruta], $params));
}

function redirect(string $ruta, array $params = [])
{
    header('Location: ' . url($ruta, $params));
    exit;
}

function current_route(): string
{
    return $GLOBALS['route'] ?? '';
}

function is_active(string $ruta): string
{
    return current_route() === $ruta ? 'is-active' : '';
}

/* ---------- Mensajes flash ---------- */
function flash(string $tipo, string $mensaje): void
{
    $_SESSION['flash'][] = ['type' => $tipo, 'msg' => $mensaje];
}

function flashes(): array
{
    $f = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $f;
}

/* ---------- CSRF ---------- */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">';
}

function csrf_check(): void
{
    $token = $_POST['_token'] ?? '';
    if (!hash_equals($_SESSION['csrf'] ?? '', (string) $token)) {
        http_response_code(419);
        exit('La sesión expiró. Vuelve atrás, recarga la página e inténtalo de nuevo.');
    }
}

/* ---------- Vistas ---------- */
function render(string $vista, array $datos = [], string $layout = 'app'): void
{
    extract($datos, EXTR_SKIP);
    ob_start();
    require APP_PATH . '/views/' . $vista . '.php';
    $content = ob_get_clean();
    require APP_PATH . '/views/layouts/' . $layout . '.php';
}

/* ---------- Paginación ---------- */
function paginar(int $total, int $porPagina, int $pagina): array
{
    $paginas = max(1, (int) ceil($total / $porPagina));
    $pagina  = min(max(1, $pagina), $paginas);
    return [
        'total'   => $total,
        'limite'  => $porPagina,
        'pagina'  => $pagina,
        'paginas' => $paginas,
        'offset'  => ($pagina - 1) * $porPagina,
    ];
}

function paginador(array $p, string $ruta, array $params = []): string
{
    if ($p['paginas'] <= 1) {
        return '';
    }
    $link = function (int $n, string $texto, string $clase = '') use ($ruta, $params) {
        $href = url($ruta, array_merge($params, ['page' => $n]));
        return '<a class="pg ' . $clase . '" href="' . e($href) . '">' . $texto . '</a>';
    };
    $html = '<nav class="paginador" aria-label="Paginación">';
    if ($p['pagina'] > 1) {
        $html .= $link($p['pagina'] - 1, '‹ Anterior');
    }
    $desde = max(1, $p['pagina'] - 2);
    $hasta = min($p['paginas'], $p['pagina'] + 2);
    for ($i = $desde; $i <= $hasta; $i++) {
        $html .= $link($i, (string) $i, $i === $p['pagina'] ? 'is-current' : '');
    }
    if ($p['pagina'] < $p['paginas']) {
        $html .= $link($p['pagina'] + 1, 'Siguiente ›');
    }
    return $html . '</nav>';
}

/* ---------- Varios ---------- */
function fecha(?string $valor, string $formato = 'd/m/Y'): string
{
    return $valor ? date($formato, strtotime($valor)) : '—';
}

function portada_segura(?string $url): ?string
{
    return ($url && preg_match('#^https?://#i', $url)) ? $url : null;
}

function inicial(string $texto): string
{
    return preg_match('/^./u', $texto, $m) ? $m[0] : '';
}