# BiblioTech (PHP puro)

Sistema de gestiÃ³n de biblioteca hecho en **PHP puro + MySQL/MariaDB**, sin frameworks.
Pensado para correr en local con **XAMPP**.

## Funcionalidades

- Inicio de sesiÃ³n con tres roles: **administrador**, **bibliotecario** y **estudiante**.
- CatÃ¡logo de libros con bÃºsqueda por tÃ­tulo, autor o ISBN y filtro por categorÃ­a.
- Panel del administrador (solo lectura por ahora): Libros, CategorÃ­as, Usuarios, Reservas, PrÃ©stamos y Multas, con bÃºsqueda, filtros y paginaciÃ³n.
- Panel del bibliotecario: listado de libros.
- ProtecciÃ³n CSRF en formularios, contraseÃ±as con bcrypt y consultas con PDO preparadas.

> Proyecto en desarrollo: las pantallas de crear/editar/eliminar y las de reservas y prÃ©stamos para bibliotecario y estudiante aÃºn muestran "MÃ³dulo en construcciÃ³n".

## Requisitos

- XAMPP con **PHP 8.1 o superior** y **MySQL/MariaDB** (Apache no es obligatorio; basta con el servidor integrado de PHP).
- Git (opcional, para clonar).

## InstalaciÃ³n

1. Clona el repositorio (o descarga el ZIP) dentro de `htdocs`:

   ```powershell
   cd D:\xamp2026\htdocs
   git clone https://github.com/brizasdelsurjhonady-a11y/bibliotech-php.git bibliotech_php
   cd bibliotech_php
   ```

2. Enciende **MySQL** en el Panel de control de XAMPP.

3. Importa la base de datos. Desde la terminal:

   ```powershell
   D:\xamp2026\mysql\bin\mysql.exe -u root < database\bibliotech.sql
   ```

   O desde phpMyAdmin: pestaÃ±a **Importar** y elige `database/bibliotech.sql`
   (el archivo crea la base `bibliotech` con cotejamiento `utf8mb4_unicode_ci`).
   Si la base ya existÃ­a, bÃ³rrala antes para evitar errores de "tabla ya existe".

4. Crea tu configuraciÃ³n local:

   ```powershell
   Copy-Item config\config.example.php config\config.php
   ```

   Ajusta usuario, contraseÃ±a o puerto de MySQL si los tuyos son distintos.

5. Deja contraseÃ±as de prueba conocidas:

   ```powershell
   php database\reset_passwords.php
   ```

6. Arranca el servidor y abre el navegador en <http://127.0.0.1:8000>:

   ```powershell
   php -S 127.0.0.1:8000 -t public
   ```

   (Si `php` no se reconoce, usa `D:\xamp2026\php\php.exe`.)
   TambiÃ©n puedes usar Apache: `http://localhost/bibliotech_php/public/`.

## Usuarios de prueba

DespuÃ©s de ejecutar `reset_passwords.php`, la contraseÃ±a es **`Biblio2026`**:

| Rol           | Correo                   |
|---------------|--------------------------|
| Administrador | `admin@bibliotech.test`  |
| Bibliotecario | `biblio@bibliotech.test` |
| Estudiante    | `carlos@bibliotech.test` |

El usuario `ana@bibliotech.test` (estudiante) conserva la contraseÃ±a `password`.
Estos datos son solo para desarrollo local; no uses estas credenciales en un servidor real.

## Estructura

```
app/
  pages/        lÃ³gica de cada pantalla (por rol)
  views/        plantillas HTML
  routes.php    mapa ruta -> roles permitidos -> archivo
  Auth.php, Database.php, helpers.php, menus.php
config/         configuraciÃ³n (config.example.php)
database/       bibliotech.sql y reset_passwords.php
public/         punto de entrada (index.php) y recursos (css)
```

Las rutas se llaman con `index.php?r=ruta`, por ejemplo `?r=admin/libros`.

