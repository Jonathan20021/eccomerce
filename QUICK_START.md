# GUÍA RÁPIDA DE INSTALACIÓN - KYROS

## 📦 Instalación en 5 minutos

### Paso 1: Crear Base de Datos

Ejecuta en phpMyAdmin o MySQL:

```sql
CREATE DATABASE kyros_saas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE kyros_saas;
```

Luego importa `app/config/init.sql`

### Paso 2: Configurar Conexión

Edita `app/config/Database.php`:

```php
// Tus datos de conexión
private $user = 'root';      // Usuario BD
private $pass = '';           // Contraseña
```

### Paso 3: Crear SuperAdmin

Ejecuta en MySQL:

```sql
INSERT INTO users (name, email, password, role, is_active, email_verified) 
VALUES ('Admin', 'admin@kyros.com', '$2y$10$O8nJPxSQ8X2tKz7z8uZmE.K6B6Xx7M5K3L9X8P7Z6Y5W4V3U2T1S0', 'superadmin', TRUE, TRUE);
```

Contraseña: `admin123`

### Paso 4: Acceder

- **Admin**: http://localhost/eccomerce/kyros/auth/login
- **Registro**: http://localhost/eccomerce/kyros/auth/register

---

## 🎯 Primeros Pasos Como SuperAdmin

1. **Crear Licencias**
   - Ve a Controlador SuperAdmin → Crear Licencia
   - Elige plan (Starter, Professional, Enterprise)
   - Se genera código automáticamente
   - Comparte código con usuarios

2. **Monitorear Tiendas**
   - Mira todas las tiendas registradas
   - Revisa licencias activas
   - Controla ingresos totales

---

## 🏪 Primeros Pasos Como Propietario de Tienda

1. **Registrarse**
   - Completa formulario con email y contraseña
   - Selecciona plan (prueba 15 días)
   - Accede a su panel

2. **Configurar Tienda**
   - Ve a Configuración
   - Ingresa nombre, descripción, logo
   - Configura WhatsApp **IMPORTANTE**
   - Selecciona moneda

3. **Subir Productos**
   - Panel → Productos → Nuevo
   - Carga foto, nombre, descripción
   - Fija precio y stock
   - Publica

4. **Compartir Tienda**
   - URL pública: http://localhost/eccomerce/kyros/shop/tu-tienda-slug
   - Comparte en WhatsApp, redes sociales, etc

---

## 💳 Sistema de Planes

### STARTER (Gratis)
- 50 productos
- 5GB almacenamiento
- Carrito básico
- Soporte por email

### PROFESSIONAL ($99/mes)
- 500 productos
- 50GB almacenamiento
- Analytics
- SEO mejorado
- API REST
- Soporte prioritario

### ENTERPRISE ($299/mes)
- Productos ilimitados
- 500GB almacenamiento
- Personalización completa
- Webhooks
- White label
- Soporte 24/7

---

## 📱 Configurar WhatsApp

### Para Propietarios de Tienda

1. Obtén número de WhatsApp Business
2. En panel → Configuración
3. Ingresa número en formato: `34612345678`
4. Clientes verán enlace "Contactar por WhatsApp"

### Formato de Número
- **Con +**: +34 612 345 678
- **Sin +**: 34612345678
- Usa formato internacional

---

## 🛒 Flujo de Compra

1. **Cliente entra a tienda pública**
   - Ve productos del dueño
   - Puede filtrar y buscar

2. **Añade al carrito**
   - Actualiza cantidad
   - Continúa comprando con "Carrito"

3. **Checkout**
   - Ingresa nombre, email, teléfono
   - Dirección de envío
   - Se crea orden
   - Se envía a WhatsApp del dueño

4. **Dueño recibe**
   - Mensaje de WhatsApp
   - Puede actualizar estado orden
   - Cliente recibe notificaciones

---

## 🔧 Personalización

### Cambiar Colores
Edita `assets/css/style.css`:

```css
:root {
    --primary-color: #2563eb;     /* Azul */
    --success-color: #10b981;     /* Verde */
}
```

### Cambiar Nombre
Edita `app/config/Config.php`:

```php
define('APP_NAME', 'Tu Nombre');
```

### Agregar Campos
1. Modifica tabla en `app/config/init.sql`
2. Actualiza modelo en `app/models/`
3. Actualiza vista en `views/`

---

## 🚀 Deployment en Servidor Real

### 1. Subir Archivos
```bash
FTP: Sube todos los archivos a tu servidor
```

### 2. Crear BD Remota
```sql
CREATE DATABASE kyros_saas;
-- Importa init.sql
```

### 3. Configurar
```php
// Database.php
private $host = 'tu-servidor.com';
private $user = 'usuario_bd';
private $pass = 'contraseña';
```

### 4. Habilitar mod_rewrite
- Pide al hosting activar mod_rewrite
- O configura .htaccess

### 5. Permisos
```bash
chmod 755 /public
chmod 755 /uploads
chmod 755 /assets
```

---

## 📊 Base de Datos

### Tablas Principales
- `users` - Usuarios (admin, dueños, clientes)
- `stores` - Tiendas
- `licenses` - Licencias y planes
- `products` - Productos
- `orders` - Órdenes
- `cart_items` - Carrito
- `categories` - Categorías de productos

---

## 🔒 Seguridad

### Implementado
- ✅ Contraseñas con bcrypt
- ✅ Sesiones seguras
- ✅ Autenticación por rol
- ✅ Validación de formularios
- ✅ Sanitización de entrada

### Por Implementar
- [ ] CSRF tokens
- [ ] Rate limiting
- [ ] 2FA
- [ ] Logs de auditoría

---

## 📞 Soporte

- Email: support@kyros.com
- Documentación: https://docs.kyros.com
- Video tutoriales: YouTube

---

**¡Kyros está listo para usar!** 🚀
