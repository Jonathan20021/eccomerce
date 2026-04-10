# KYROS - SaaS de E-commerce Profesional

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D7.4-blue.svg)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/mysql-5.7-blue.svg)](https://www.mysql.com/)

Kyros es una plataforma SaaS completa para crear y administrar tiendas online. Permite a diferentes comerciantes crear sus propias tiendas, subir productos, recibir órdenes y comunicarse con clientes a través de WhatsApp.

## 🚀 Características Principales

- **Multi-tienda**: Diferentes propietarios pueden crear sus tiendas
- **Panel de Administración**: Gestión integral de productos, órdenes y configuración
- **Carrito de Compras**: Sistema completo de carrito persistente
- **Integración WhatsApp**: Recibe notificaciones de órdenes y comunícate con clientes
- **Portal Público**: Escaparate profesional para cada tienda
- **Sistema de Licencias**: Gestión de planes (Starter, Professional, Enterprise)
- **Prueba Gratis**: 15 días de prueba sin tarjeta de crédito
- **Panel SuperAdmin**: Administración de licencias y tiendas
- **Diseño Responsivo**: Totalmente adaptado a dispositivos móviles
- **Tailwind CSS**: Interfaz moderna y profesional

## 📋 Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Apache con mod_rewrite habilitado
- Composer (opcional, para gestión de dependencias)
- Node.js (opcional, para compilar Tailwind)

## 🔧 Instalación

### 1. Descargar/Clonar el Proyecto

```bash
git clone https://github.com/tuusuario/kyros.git
cd kyros
```

### 2. Configurar Base de Datos

1. Abre phpMyAdmin o tu gestor de MySQL preferido
2. Crea una nueva base de datos:
   ```sql
   CREATE DATABASE kyros_saas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. Importa el archivo SQL:
   ```bash
   mysql -u root -p kyros_saas < app/config/init.sql
   ```

### 3. Configurar la Conexión a BD

Edita `app/config/Database.php`:

```php
private $host = 'localhost';       // Tu host
private $db_name = 'kyros_saas';   // Nombre BD
private $user = 'root';             // Usuario MySQL
private $pass = '';                 // Contraseña MySQL
```

### 4. Configurar Rutas (Apache .htaccess)

Crea un archivo `.htaccess` en la raíz si no existe:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /eccomerce/kyros/
    
    # No procesar archivos o directorios reales
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    
    # Reescribir todas las peticiones a index.php
    RewriteRule ^(.*)$ index.php?/$1 [L]
</IfModule>
```

### 5. Crear Usuario SuperAdmin

Ejecuta esta query en tu base de datos:

```sql
INSERT INTO users (name, email, password, role, is_active, email_verified) 
VALUES ('Admin', 'admin@kyros.com', '$2y$10$...', 'superadmin', 1, 1);
```

Genera el hash de contraseña en PHP:
```php
echo password_hash('tucontraseña', PASSWORD_BCRYPT);
```

### 6. Permisos de Carpetas

```bash
chmod 755 public
chmod 755 assets
chmod 755 uploads (si no existe, crear)
```

## 📁 Estructura del Proyecto

```
kyros/
├── app/
│   ├── config/          # Configuración
│   ├── controllers/     # Controladores
│   ├── models/          # Modelos de BD
│   ├── middleware/      # Middleware de seguridad
│   └── helpers/         # Funciones auxiliares
├── views/
│   ├── layouts/         # Layouts base
│   ├── auth/            # Vistas de autenticación
│   ├── admin/           # Panel de administración
│   ├── superadmin/      # Panel de superadmin
│   └── public/          # Vistas públicas
├── public/
│   ├── uploads/         # Archivos subidos
│   └── images/          # Imágenes del proyecto
├── assets/
│   ├── css/             # Estilos
│   └── js/              # JavaScript
├── index.php            # Punto de entrada
├── README.md            # Este archivo
└── composer.json        # Dependencias (si usa Composer)
```

## 🔐 Primeros Pasos

### 1. Acceder al Sistema

**Tienda (Cliente)**
- URL: `http://localhost/eccomerce/kyros/auth/register`
- Crear cuenta y tienda con plan de prueba

**SuperAdmin**
- URL: `http://localhost/eccomerce/kyros/auth/login`
- Usuario: admin@kyros.com
- Contraseña: (la que configuraste)

### 2. Crear Primera Licencia (Como SuperAdmin)

1. Ve a SuperAdmin > Crear Licencia
2. Selecciona el plan (Starter, Professional o Enterprise)
3. Define días de prueba (15 por defecto)
4. Se generará un código automáticamente
5. Comparte este código con nuevos usuarios

### 3. Flujo de Usuario

1. **Registro**: Usuario se registra y crea tienda
2. **Plan de Prueba**: Obtiene 15 días gratis del plan seleccionado
3. **Panel Tienda**: Sube productos, configura WhatsApp
4. **Portal Público**: Clientes ven la tienda y compran
5. **Órdenes**: Usuario recibe notificaciones en WhatsApp

## 🎨 Personalización

### Cambiar Colores

Edita `assets/css/style.css`:

```css
:root {
    --primary-color: #2563eb;      /* Azul principal */
    --secondary-color: #64748b;    /* Gris */
    --success-color: #10b981;      /* Verde */
}
```

### Cambiar Nombre de la Plataforma

Edita `app/config/Config.php`:

```php
define('APP_NAME', 'Kyros');  // Cambiar aquí
```

### Agregar Campos Personalizados

1. Agrega columnas a la tabla en `app/config/init.sql`
2. Actualiza los modelos correspondientes
3. Actualiza las vistas

## 📱 Integración WhatsApp

### Configurar Número de WhatsApp

1. En panel de tienda > Configuración
2. Ingresa número en formato internacional: `34612345678`
3. Los clientes recibirán enlace wa.me para contactar

### Personalizar Mensaje de WhatsApp

En `app/helpers/Helper.php`, función `getWhatsAppLink()`:

```php
public static function getWhatsAppLink($phone, $message = '') {
    // $message es el mensaje enviado al abrir WhatsApp
}
```

## 🧪 Testing

### Crear Tienda de Prueba

1. Accede a `/auth/register`
2. Completa el formulario
3. Accede con credenciales
4. Crea algunos productos de prueba

### Simular Compra

1. Abre tu tienda desde portal público
2. Añade productos al carrito
3. Procede al checkout
4. Completa datos del cliente
5. La orden se crea y se envía a WhatsApp

## 🐛 Solución de Problemas

### Error 500 en Panel

**Causa**: Permisos de carpeta
```bash
chmod 755 -R app/
chmod 755 -R views/
chmod 755 -R public/
```

### Órdenes no se guardan

**Verificar**:
1. Conexión a BD en `app/config/Database.php`
2. Tabla `orders` existe en BD
3. Permisos en carpeta `public/uploads`

### WhatsApp no abre enlace

**Verificar**:
1. Número de WhatsApp esté en formato internacional
2. Sin caracteres especiales excepto +

## 📚 API Endpoints

### Carrito (AJAX)

```javascript
// Agregar producto
POST /api/cart/add
{
    product_id: 1,
    store_id: 1,
    quantity: 1
}

// Actualizar cantidad
POST /api/cart/update
{
    cart_item_id: 1,
    quantity: 2
}

// Eliminar producto
POST /api/cart/remove
{
    cart_item_id: 1
}
```

## 🚀 Deployment

### En Servidor Compartido

1. Sube archivos vía FTP
2. Crea BD en hosting
3. Importa SQL en hosting
4. Configura credenciales en `Database.php`
5. Asegúrate que mod_rewrite esté habilitado

### Variables de Entorno (.env)

Copia `config/.env.example` a `config/.env`:

```
DB_HOST=localhost
DB_NAME=kyros_saas
DB_USER=usuario
DB_PASS=contraseña
APP_URL=https://tudominio.com/kyros/
```

## 📝 Guía de Planes

| Plan | Precio | Productos | Storage | Características |
|------|--------|-----------|---------|-----------------|
| Starter | Gratis | 50 | 5GB | Básico |
| Professional | $99/mes | 500 | 50GB | Avanzado + Analytics |
| Enterprise | $299/mes | ∞ | 500GB | Personalización total |

## 👥 Soporte

- Email: support@kyros.com
- Discord: [Unirse a comunidad]
- Documentación: https://docs.kyros.com

## 📄 Licencia

Este proyecto está bajo licencia MIT. Ver `LICENSE` para más detalles.

## 🙏 Contribuciones

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📈 Roadmap

- [ ] Pasarela de pago Stripe
- [ ] Cupones y descuentos
- [ ] Email marketing integrado
- [ ] Sistema de afiliados
- [ ] Mobile app
- [ ] Analytics avanzado
- [ ] Integraciones con redes sociales
- [ ] Exportación de datos

---

**Kyros** © 2024 - Hecho con ❤️ para emprendedores
