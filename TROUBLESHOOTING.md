# 🆘 Troubleshooting - Kyros

Soluciones a problemas comunes durante la instalación y uso de Kyros.

---

## 🔧 Problemas de Instalación

### Problema 1: "Error al conectar a la base de datos"

**Síntoma**: Error PDO Connection cuando cargas la página

**Soluciones**:

1. **Verifica credenciales MySQL**
   - Abre `app/config/Database.php`
   - Confirma usuario y contraseña correctos
   
   ```php
   private $user = 'root';              // Tu usuario MySQL
   private $pass = '';                  // Tu contraseña (vacío si no tiene)
   ```

2. **Verifica que MySQL esté corriendo**
   - XAMPP: Haz clic en "Start" en Apache y MySQL
   - Comprueba http://localhost/phpmyadmin

3. **Base de datos no existe**
   - Abre phpMyAdmin
   - Crea nueva BD: `kyros_saas`
   - Importa `app/config/init.sql`

4. **Puerto MySQL incorrecto**
   - Si MySQL no está en puerto 3306, ajusta en Database.php:
   ```php
   private $host = 'localhost:3307';   // Cambiar puerto
   ```

---

### Problema 2: "Blank page" / Página blanca

**Síntoma**: Solo ves página en blanco sin contenido

**Soluciones**:

1. **Activa error reporting**
   - En `app/config/Database.php`, añade al inicio:
   ```php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```

2. **Revisa logs de PHP**
   - Windows: `C:\xampp\apache\logs\error.log`
   - Linux: `/var/log/apache2/error.log`

3. **Verifica permisos de carpeta**
   ```bash
   chmod 755 -R public/
   chmod 755 -R logs/
   chmod 755 -R cache/
   ```

4. **Revisa .htaccess**
   - Asegúrate que mod_rewrite esté activo
   - Verifica que `.htaccess` existe en carpeta raíz

---

### Problema 3: "404 Not Found" en todas las rutas

**Síntoma**: Solo funciona `/` pero rutas como `/admin/dashboard` dan 404

**Soluciones**:

1. **Apache mod_rewrite no está activo**
   - En XAMPP: Abre `apache/conf/httpd.conf`
   - Busca `LoadModule rewrite_module` y descomenta (quita `#`)
   - Reinicia Apache
   
   Verifica: http://localhost/phpmyadmin/index.php?route=/server/status
   Busca "mod_rewrite" en la lista

2. **Verificación en .htaccess**
   - Abre carpeta raíz de Kyros
   - Verifica que existe archivo `.htaccess`
   - Contenido debe tener:
   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteBase /eccomerce/kyros/
       RewriteRule ^index\.php$ - [L]
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteRule . /eccomerce/kyros/index.php [L]
   </IfModule>
   ```

3. **Ruta incorrecta en Config.php**
   - Abre `app/config/Config.php`
   - Verifica `BASE_URL`:
   ```php
   # Debe ser el mismo que la carpeta donde está Kyros
   define('BASE_URL', 'http://localhost/eccomerce/kyros/');
   ```

---

### Problema 4: "No tiene licencia activa"

**Síntoma**: Al registrar tienda, dice "No tiene licencia disponible"

**Soluciones**:

1. **Crear licencia primero**
   - Login como SuperAdmin
   - Ve a Panel SuperAdmin → Crear Licencia
   - Crea al menos una licencia Starter

2. **Licencia vencida**
   - En phpMyAdmin, verifica tabla `licenses`
   - Comprueba que `status = 'active'`
   - Verifica `trial_ends_at` o `expires_at`

3. **No hay relación en BD**
   - En phpMyAdmin, verifica que tabla `licenses_stores` existe
   - O alterna, que `licenses.store_id` puede ser NULL

---

## 🔐 Problemas de Autenticación

### Problema 5: "No puedo logearme"

**Síntoma**: El login dice "Email o contraseña incorrectos"

**Soluciones**:

1. **Usuario no existe**
   - Abre phpMyAdmin → `users`
   - Busca tu email
   - Si no existe, créalo o usa `admin@kyros.com`

2. **Contraseña incorrecta**
   - Recuerda: Las contraseñas están hasheadas con bcrypt
   - No puedes saber la contraseña, solo crear una nueva
   
   En phpMyAdmin, ejecuta:
   ```sql
   UPDATE users 
   SET password = '$2y$10$O8nJPxSQ8X2tKz7z8uZmE.K6B6Xx7M5K3L9X8P7Z6Y5W4V3U2T1S0'
   WHERE email = 'tu@email.com';
   -- Nueva contraseña: admin123
   ```

3. **Email no verificado**
   - En BD, verifica `email_verified = TRUE`
   ```sql
   UPDATE users SET email_verified = TRUE WHERE email = 'tu@email.com';
   ```

4. **Cuenta no activa**
   - Verifica `is_active = TRUE`
   ```sql
   UPDATE users SET is_active = TRUE WHERE email = 'tu@email.com';
   ```

---

### Problema 6: "Acceso denegado" / "No tienes permiso"

**Síntoma**: Ves página pero dice "No autorizado"

**Soluciones**:

1. **Rol incorrecto**
   - Asegúrate de tener el rol correcto:
   - Para `/admin/` necesitas `role = 'store_owner'`
   - Para `/superadmin/` necesitas `role = 'superadmin'`

2. **No tienes tienda asignada**
   - Si eres store_owner, necesitas `store_id` en usuario
   ```sql
   UPDATE users SET store_id = 1 WHERE id = 2;
   ```

3. **Sesión expirada**
   - Intenta cerrar sesión y volver a loguear

---

## 🛒 Problemas del Carrito

### Problema 7: "El carrito no guarda productos"

**Síntoma**: Agrego producto pero cuando recargo, desaparece

**Soluciones**:

1. **Sesiones no están activas**
   - Verifica que `session_start()` esté en `index.php`
   - En primeras líneas del archivo

2. **Galletas (cookies) deshabilitadas**
   - Verifica que tu navegador tiene cookies activas
   - En Firefox: Preferences → Privacy

3. **AJAX no funciona**
   - Abre Consola (F12)
   - Si hay errores rojos, verifica que `/api/cart/add` exista
   - Comprueba que `script.js` está cargado

---

### Problema 8: "Error al agregar al carrito"

**Síntoma**: Ver error "Failed to fetch" en consola

**Soluciones**:

1. **Endpoint no existe**
   - Verifica que `PublicController::addToCart()` existe
   - Verifica ruta en `index.php`

2. **Error en respuesta JSON**
   - Abre Consola (F12)
   - Networks tab
   - Busca request a `/api/cart/add`
   - Ve respuesta (Response tab)
   - Si hay error SQL, revisa que tabla `cart_items` existe

3. **Usuario no está logueado**
   - El carrito requiere session_id
   - Asegúrate que tienes cookie de sesión

---

## 📷 Problemas de Subida de Archivos

### Problema 9: "No puedo subir imagen del producto"

**Síntoma**: Intento agregar imagen pero recibo error

**Soluciones**:

1. **Carpeta uploads no existe**
   - Crea: `public/uploads/`
   - Dale permisos: `chmod 755 public/uploads/`

2. **Permisos insuficientes**
   - Directorio debe ser escribible
   - Windows: Click derecho → Propiedades → Seguridad
   - Linux: `chmod 755 public/uploads/`

3. **Archivo muy grande**
   - Máximo 5MB (definido en Helper.php)
   - Comprime tu imagen

4. **Formato no permitido**
   - Solo: JPG, PNG, GIF, WebP
   - No: PDF, DOC, ZIP, etc.

5. **Revisar limite en php.ini**
   ```ini
   upload_max_filesize = 5M
   post_max_size = 5M
   ```

---

## 📊 Problemas de Base de Datos

### Problema 10: "Tabla no existe"

**Síntoma**: Error "Table 'kyros_saas.products' doesn't exist"

**Soluciones**:

1. **Importar init.sql nuevamente**
   - phpMyAdmin → kyros_saas → SQL
   - Pega contenido de `app/config/init.sql`
   - Haz clic Ejecutar

2. **Verificar tablas existen**
   - En phpMyAdmin, mira estructura
   - Deben haber 10 tablas:
     - users
     - stores
     - products
     - licenses
     - orders
     - order_items
     - cart_items
     - categories
     - reviews
     - settings

---

### Problema 11: "Error de clave foránea"

**Síntoma**: "Foreign Key constraint fail"

**Soluciones**:

1. **Verifica que tablas padre existen**
   - Si error en `store_id`, verifica tabla `stores`
   - Si error en `user_id`, verifica tabla `users`

2. **Relaciones correctas**
   - En `products`, `store_id` debe existir en `stores`
   - En `orders`, `user_id` debe existir en `users`

3. **Desactiva verificación temporal**
   ```sql
   SET FOREIGN_KEY_CHECKS=0;
   -- Tus cambios aquí
   SET FOREIGN_KEY_CHECKS=1;
   ```

---

## 🌐 Problemas en Producción

### Problema 12: "Funciona en local pero no en servidor"

**Síntoma**: Todo OK en XAMPP pero en hosting falla

**Soluciones**:

1. **Rutas absolutas vs relativas**
   - En `Database.php`, verifica rutas
   - Usa `__DIR__` para rutas absolutas

2. **Diferencia de PHP**
   - Asegúrate que servidor tiene PHP 7.4+
   - Hosting panel → PHP version

3. **mod_rewrite no activo**
   - Contacta hosters soporte
   - Pide que activen mod_rewrite
   - O usa `.htaccess` alternativo sin rewrite

4. **Permisos de archivos**
   - `public/uploads/` necesita permisos 755
   - `logs/` y `cache/` también

5. **Variables de entorno**
   - Hosting puede tener variables diferentes
   - Verifica `DB_HOST`, `DB_USER`, `DB_PASS`

---

## 🐛 Debug Mode

### Activar Debug

En `app/config/Config.php`:

```php
define('DEBUG', true);  // Muestra errores
define('DEBUG', false); // Oculta errores (producción)
```

Con DEBUG=true verás:
- Errores PHP completos
- Queries SQL en algunas vistas
- Stack traces

---

## 📞 Obtener Soporte

Si ninguna solución funciona:

1. **Revisa logs** en `logs/` carpeta
2. **Consola del navegador** (F12 → Console)
3. **phpMyAdmin** estructura de BD
4. **Verifica server status** en Panel XAMPP

---

**Última actualización**: 2024
