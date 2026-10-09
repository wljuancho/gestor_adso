# Gestor ADSO

Repositorio del proyecto integrador **Gestor ADSO**, una aplicación web en desarrollo para apoyar la gestión en el contexto del programa de Análisis y Desarrollo de Software (ADSO). Este repositorio contiene actualmente la base de una aplicación Laravel y sus migraciones iniciales.

Repositorio remoto: <https://github.com/wljuancho/gestor_adso>

## Herramientas y versiones del equipo

Las siguientes versiones se obtuvieron ejecutando los comandos en el equipo usado para este proyecto. Son resultados reales de ese equipo; pueden ser diferentes en otros computadores.

### PHP

Comando: `php -v`

```text
PHP 8.2.12 (cli) (built: Oct 24 2023 21:15:15) (ZTS Visual C++ 2019 x64)
Copyright (c) The PHP Group
Zend Engine v4.2.12, Copyright (c) Zend Technologies
```

### Composer

Comando: `composer -V`

```text
Composer version 2.10.3 2026-08-27 13:34:23
PHP version 8.2.12 (C:\xampp\php\php.exe)
Run the "diagnose" command to get more detailed diagnostics output.
```

### Laravel

Comando: `php artisan --version`

```text
Laravel Framework 12.69.3
```

### Git

Comando: `git --version`

```text
git version 2.54.0.windows.1
```


## Requisitos

- PHP 8.2 o superior, Composer y Git.
- Windows PowerShell para los comandos de configuración indicados abajo. En otros sistemas operativos, usa los comandos equivalentes.

## Instalación y configuración

Abre PowerShell y clona el repositorio:

```powershell
git clone https://github.com/wljuancho/gestor_adso.git
Set-Location gestor_adso
```

Si ya tienes el repositorio clonado, entra a su carpeta y continúa desde el siguiente paso. Instala las dependencias de PHP y crea `.env` solo si aún no existe:

```powershell
composer install
if (-not (Test-Path .env)) { Copy-Item .env.example .env }
```

Abre `.env` y verifica la configuración local. Para la base de datos predeterminada SQLite y cambiala a mysql, utiliza:

```dotenv
APP_NAME="Gestor ADSO"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
```

No es necesario definir `DB_DATABASE` para mysql: la configuración del proyecto usa `database/database.sqlite` por defecto. No publiques el archivo `.env` ni agregues credenciales reales al repositorio.

Genera la clave de la aplicación y crea el archivo SQLite si todavía no existe:

```powershell
php artisan key:generate
if (-not (Test-Path database\database.sqlite)) {
    New-Item -ItemType File -Path database\database.sqlite | Out-Null
}
```

## Base de datos y migraciones

Con `DB_CONNECTION=sqlite` y el archivo `database/database.sqlite` creado, ejecuta las migraciones:

```powershell
php artisan migrate
```

Las migraciones iniciales incluidas crean las tablas de usuarios, caché y trabajos en cola. Para revisar el estado de las migraciones:

```powershell
php artisan migrate:status
```

## Recursos del servidor



Inicia el servidor de desarrollo de Laravel:

```powershell
php artisan serve
```



## Evidencias del proceso

Las salidas reales de las herramientas están registradas en la sección **Herramientas y versiones del equipo**. Para completar la evidencia visual del proceso, agrega capturas reales en `docs/evidencias/` que muestren:

1. La configuración de `.env` y la base mysql creada. Oculta cualquier clave o dato sensible.
2. La ejecución exitosa de `php artisan migrate` (y, si se desea, `php artisan migrate:status`).
3. `php artisan serve` en ejecución y la aplicación abierta en el navegador.


## comandos finales
Set-Location "$env:USERPROFILE\Documents"
composer create-project laravel/laravel gestor-adso
Set-Location .\gestor-adso
php artisan --version
Copy-Item .env.example .env
php artisan key:generate
notepad .env
php artisan config:clear
& "C:\xampp\mysql\bin\mysql.exe" -h 127.0.0.1 -P 3306 -u root -e "CREATE DATABASE gestor_adso CHARACTER SET utf8mb4 COLLATE
utf8mb4_unicode_ci;"
php artisan migrate
git status
git add .
git commit -m "Semana 1: Entorno listo + Laravel base"
php artisan serve

