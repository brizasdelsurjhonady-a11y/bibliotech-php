<?php

function rol_etiqueta(string $rol): string
{
    return ['administrador' => 'Administrador', 'bibliotecario' => 'Bibliotecaria', 'estudiante' => 'Estudiante'][$rol] ?? $rol;
}

/** Enlaces de la barra superior según el rol: [texto, ruta] */
function menu_top(string $rol): array
{
    switch ($rol) {
        case 'administrador':
            return [['Inicio', 'inicio'], ['Catálogo', 'catalogo'], ['Admin', 'admin/dashboard']];
        case 'bibliotecario':
            return [['Inicio', 'inicio'], ['Catálogo', 'catalogo'], ['Libros', 'biblio/libros'],
                    ['Préstamos', 'biblio/prestamos'], ['Reservas', 'biblio/reservas']];
        default:
            return [['Inicio', 'inicio'], ['Catálogo', 'catalogo'],
                    ['Mis reservas', 'estudiante/reservas'], ['Mis préstamos', 'estudiante/prestamos']];
    }
}

/** Menú lateral (solo administrador y bibliotecario) */
function menu_sidebar(string $rol): ?array
{
    switch ($rol) {
        case 'administrador':
            return ['titulo' => 'ADMINISTRACIÓN', 'items' => [
                ['Dashboard', 'admin/dashboard'], ['Libros', 'admin/libros'], ['Categorías', 'admin/categorias'],
                ['Usuarios', 'admin/usuarios'], ['Configuración', 'admin/configuracion'],
                ['Reservas', 'admin/reservas'], ['Préstamos', 'admin/prestamos'], ['Multas', 'admin/multas'],
            ]];
        case 'bibliotecario':
            return ['titulo' => 'PANEL BIBLIOTECA', 'items' => [
                ['Libros', 'biblio/libros'], ['Reservas', 'biblio/reservas'],
                ['Préstamos', 'biblio/prestamos'], ['Multas', 'biblio/multas'],
            ]];
        default:
            return null;
    }
}

/** Busca el texto de una ruta en los menús (para títulos de páginas pendientes) */
function etiqueta_de_ruta(string $ruta, string $rol): string
{
    $listas = [menu_top($rol), menu_sidebar($rol)['items'] ?? []];
    foreach ($listas as $lista) {
        foreach ($lista as [$texto, $r]) {
            if ($r === $ruta) {
                return $texto;
            }
        }
    }
    return 'Módulo';
}