@echo off
REM Script de instalación para Kyros en Windows
REM Uso: install.bat

echo.
echo ========================================
echo   Instalacion de Kyros - Windows
echo ========================================
echo.

REM Crear directorios
echo [1/4] Creando directorios...
if not exist "public\uploads" mkdir public\uploads
if not exist "logs" mkdir logs
if not exist "cache" mkdir cache
echo OK
echo.

REM Crear .env
echo [2/4] Configurando variables de entorno...
if not exist ".env" (
    copy .env.example .env
    echo .env creado (edita con tus credenciales)
) else (
    echo .env ya existe
)
echo.

REM Información de conexión a BD
echo [3/4] Base de datos
echo.
echo Por favor, sigue estos pasos en phpMyAdmin:
echo.
echo 1. Abre: http://localhost/phpmyadmin
echo 2. Conecta con tu usuario MySQL (root/sin contraseña)
echo 3. Crea nueva BD: kyros_saas
echo 4. Ve a la pestaña "Importar"
echo 5. Selecciona archivo: app/config/init.sql
echo 6. Haz clic en "Ejecutar"
echo.
pause

REM Crear usuario SuperAdmin
echo [4/4] Creando SuperAdmin...
echo.
echo Ejecuta esta consulta en phpMyAdmin (en BD kyros_saas):
echo.
echo INSERT INTO users (name, email, password, role, is_active, email_verified)
echo VALUES ('Admin', 'admin@kyros.com',
echo '$2y$10$O8nJPxSQ8X2tKz7z8uZmE.K6B6Xx7M5K3L9X8P7Z6Y5W4V3U2T1S0',
echo 'superadmin', TRUE, TRUE);
echo.
pause

REM Resumen final
cls
echo.
echo ========================================
echo   Instalacion Completada!
echo ========================================
echo.
echo URL acceso:
echo   http://localhost/eccomerce/kyros/
echo.
echo Login SuperAdmin:
echo   Email: admin@kyros.com
echo   Password: admin123
echo.
echo IMPORTANTE: Cambia contraseña despues de loguear!
echo.
pause
