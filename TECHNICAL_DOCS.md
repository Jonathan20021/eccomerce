# 📖 DOCUMENTACIÓN TÉCNICA - KYROS

## Tabla de Contenidos
1. [Arquitectura](#arquitectura)
2. [Estructura de Carpetas](#estructura-de-carpetas)
3. [Modelos de Datos](#modelos-de-datos)
4. [Enrutamiento](#enrutamiento)
5. [Autenticación y Autorización](#autenticación-y-autorización)
6. [APIs REST](#apis-rest)
7. [Seguridad](#seguridad)

---

## Arquitectura

Kyros usa un patrón **MVC (Model-View-Controller)** simple pero efectivo:

```
HTTP Request → index.php → Router → Controller → Model → View
```

### Flujo

1. **Punto de entrada**: `index.php`
   - Parsea URL
   - Rutas según carpeta
   - Carga archivo correspondiente

2. **Controlador**: Maneja lógica de negocio
   - Valida entrada
   - Llama modelos
   - Prepara datos para vista

3. **Modelo**: Accede a la base de datos
   - Consultas SQL
   - Lógica de BD
   - Retorna arreglos

4. **Vista**: Presenta datos HTML
   - Usa variables PHP
   - Incluye estilos CSS
   - JavaScript para interacción

---

## Estructura de Carpetas

```
kyros/
├── app/
│   ├── config/
│   │   ├── Config.php          # Configuración global
│   │   ├── Database.php        # Conexión MySQLI
│   │   └── init.sql            # Script de BD
│   ├── controllers/
│   │   ├── AuthController.php  # Login, Registro
│   │   ├── AdminController.php # Panel tienda
│   │   ├── PublicController.php# Tienda pública
│   │   └── SuperAdminController.php
│   ├── models/
│   │   ├── User.php            # Tabla usuarios
│   │   ├── Store.php           # Tabla tiendas
│   │   ├── Product.php         # Tabla productos
│   │   ├── License.php         # Tabla licencias
│   │   ├── Cart.php            # Tabla carrito
│   │   └── Order.php           # Tabla órdenes
│   ├── middleware/
│   │   └── Auth.php            # Control de acceso
│   └── helpers/
│       └── Helper.php          # Funciones auxiliares
├── views/
│   ├── layouts/
│   │   ├── main.php            # Layout público
│   │   └── admin.php           # Layout admin
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   ├── admin/
│   │   ├── dashboard.php
│   │   ├── products.php
│   │   └── settings.php
│   ├── superadmin/
│   │   ├── dashboard.php
│   │   └── licenses.php
│   └── public/
│       ├── home.php             # Landing page
│       ├── storefront.php       # Tienda
│       └── checkout.php         # Carrito
├── assets/
│   ├── css/
│   │   └── style.css           # Estilos personalizados
│   ├── js/
│   │   └── script.js           # JS global
│   └── images/
├── public/
│   └── uploads/                # Archivos subidos
├── index.php                   # Router principal
├── .htaccess                   # Configuración Apache
└── README.md                   # Documentación
```

---

## Modelos de Datos

### User
```php
- id (PK)
- name
- email (UNIQUE)
- password (bcrypt)
- phone
- role [superadmin|store_owner|store_staff|customer]
- store_id (FK)
- is_active
- email_verified
```

### Store
```php
- id (PK)
- owner_id (FK Users)
- name
- slug (UNIQUE)
- description
- logo
- banner
- whatsapp_number
- email
- phone
- address
- city, state, country
- postal_code
- currency [USD|EUR|MXN...]
- plan_id (FK)
- license_id (FK)
- is_active
- verified
```

### Product
```php
- id (PK)
- store_id (FK)
- name
- slug (UNIQUE)
- description
- price
- discount_price
- discount_percent
- cost
- sku
- image
- category_id
- stock
- is_active
- rating
- reviews_count
```

### License
```php
- id (PK)
- code (UNIQUE)
- store_id (FK)
- plan_id
- is_trial
- status [active|expired|suspended|cancelled]
- trial_days
- trial_ends_at
- expires_at
- features (JSON)
```

### Order
```php
- id (PK)
- order_number (UNIQUE)
- user_id (FK)
- store_id (FK)
- status [pending|confirmed|processing|shipped|delivered|cancelled]
- total
- subtotal
- tax
- shipping_cost
- discount
- customer_name
- customer_email
- customer_phone
- shipping_address
- payment_method
- payment_status [pending|paid|failed]
```

---

## Enrutamiento

### URL Pattern
```
/[sección]/[acción]/[parámetro]
```

### Rutas Principales

```php
// Público
GET /                              → Home/Landing
GET /auth/login                    → Login form
POST /auth/login                   → Procesar login
GET /auth/register                 → Registro form
POST /auth/register                → Procesar registro
GET /auth/logout                   → Cerrar sesión
GET /shop/{slug}                   → Ver tienda
GET /shop/{slug}/product/{id}      → Detalle producto
GET /shop/{slug}/cart              → Ver carrito

// Admin (Requiere autenticación store_owner)
GET /admin/dashboard               → Dashboard
GET /admin/products                → Lista productos
POST /admin/products/new           → Crear producto
POST /admin/products/{id}/edit     → Editar producto
DELETE /admin/products/{id}        → Eliminar producto
GET /admin/orders                  → Ver órdenes
GET /admin/orders/{id}             → Detalle orden
POST /admin/settings               → Guardar configuración

// SuperAdmin (Requiere autenticación superadmin)
GET /superadmin/dashboard          → Dashboard
GET /superadmin/licenses           → Ver licencias
POST /superadmin/licenses/create   → Crear licencia
GET /superadmin/stores             → Ver tiendas
GET /superadmin/stores/{id}        → Detalle tienda

// API (AJAX)
POST /api/cart/add                 → Agregar al carrito
POST /api/cart/update              → Actualizar cantidad
POST /api/cart/remove              → Eliminar del carrito
```

---

## Autenticación y Autorización

### Flujo de Login

```php
// 1. User ingresa credenciales
POST /auth/login
{
    email: "usuario@email.com",
    password: "contraseña"
}

// 2. AuthController::login() verifica
- Busca usuario en BD
- Verifica contraseña con password_verify()
- Si OK: guarda sesión $_SESSION

// 3. Session contiene
{
    user_id: 1,
    user_email: "usuario@email.com",
    user_role: "store_owner",
    store_id: 5
}

// 4. Redirecciona según rol
- superadmin → /superadmin/dashboard
- store_owner → /admin/dashboard
- customer → /dashboard
```

### Middleware Auth.php

```php
Auth::requireLogin()              // Verifica que esté logueado
Auth::requireSuperAdmin()         // Solo superadmin
Auth::requireStoreOwner()         // Solo dueño de tienda
Auth::isSuperAdmin()              // Retorna true/false
Auth::isStoreOwner()              // Retorna true/false
Auth::isStoreOwnerOfStore($id)    // Verifica permisos en tienda
Auth::getCurrentUser()            // Retorna usuario actual
Auth::getStoreId()                // Retorna tienda del usuario
```

### Uso

```php
// En controller
class AdminController {
    public static function dashboard() {
        Auth::requireStoreOwner();  // Verifica permisos
        // Código seguro aquí
    }
}
```

---

## APIs REST

### Carrito (AJAX)

**Agregar Producto**
```javascript
POST /api/cart/add
Content-Type: application/x-www-form-urlencoded

product_id=123&store_id=5&quantity=1

Response:
{
    success: true,
    message: "Producto añadido",
    cartCount: 3
}
```

**Actualizar Cantidad**
```javascript
POST /api/cart/update
Content-Type: application/x-www-form-urlencoded

cart_item_id=45&quantity=2

Response:
{
    success: true,
    cartTotal: 150.50
}
```

**Eliminar**
```javascript
POST /api/cart/remove
Content-Type: application/x-www-form-urlencoded

cart_item_id=45

Response:
{
    success: true,
    message: "Producto removido"
}
```

---

## Seguridad

### Implementado

1. **Contraseñas**
   - Hasheadas con bcrypt
   - password_hash(pass, PASSWORD_BCRYPT)
   - password_verify(pass, hash)

2. **Sesiones**
   - Configuradas para HTTPS en producción
   - HttpOnly cookies
   - SameSite=Lax

3. **SQL Injection Prevention**
   - Prepared statements con PDO
   - Parámetros vinculados

4. **XSS Prevention**
   - htmlspecialchars() en salida
   - User input sanitizado

5. **Validación**
   - Email validation
   - Phone validation
   - Form validation

### Por Implementar

1. **CSRF Tokens**
   - Para formularios POST
   - Verificar en $_SESSION

2. **Rate Limiting**
   - Máximo intentos login
   - Throttling de API

3. **Logging**
   - Auditoría de acciones
   - Registro de cambios

4. **Encriptación**
   - Datos sensibles encriptados
   - SSL/HTTPS en producción

---

## Helper Functions

### Helper.php

```php
Helper::generateSlug($text)          // Criar URL-friendly slug
Helper::formatPrice($price, $currency) // Formatea precio
Helper::formatDate($date, $format)    // Formatea fecha
Helper::getWhatsAppLink($phone, $msg) // Genera enlace wa.me
Helper::validateEmail($email)         // Valida email
Helper::validatePhone($phone)         // Valida número
Helper::generateToken($length)        // Token seguro 
Helper::sanitizeInput($input)         // Limpia HTML
Helper::uploadFile($file, $dir)       // Sube archivo
Helper::calculateDiscount($orig, $new) // Calcula descuento
Helper::json($data, $code)            // Respuesta JSON
Helper::redirect($url)                // Redirecciona
Helper::truncate($text, $len)         // Trunca texto
Helper::isTrialExpired($date)         // Verifica vigencia
```

---

## Variables de Configuración

### Config.php

```php
define('APP_NAME', 'Kyros');                    // Nombre app
define('APP_VERSION', '1.0.0');                  // Versión
define('BASE_URL', 'http://localhost/...');     // URL base
define('APP_PATH', dirname(...));               // Path absoluto

// Planes
define('PLAN_STARTER', [...]);                  // Plan gratis
define('PLAN_PROFESSIONAL', [...]);             // Plan pago
define('PLAN_ENTERPRISE', [...]);               // Plan premium

// Roles
define('ROLE_SUPERADMIN', 'superadmin');        // Admin total
define('ROLE_STORE_OWNER', 'store_owner');      // Dueño tienda
define('ROLE_STORE_STAFF', 'store_staff');      // Empleado tienda
define('ROLE_CUSTOMER', 'customer');            // Cliente
```

---

## Pasos para Agregar Funcionalidad

### 1. Crear tabla en BD
```sql
ALTER TABLE products ADD COLUMN new_column VARCHAR(255);
```

### 2. Actualizar Model
```php
class Product {
    public $new_column;
    
    public function update() {
        // Incluir nuevo campo
    }
}
```

### 3. Actualizar Vista
```php
<input name="new_column" value="<?= $product['new_column'] ?>">
```

### 4. Actualizar Controller
```php
$product->new_column = $_POST['new_column'];
```

---

**Documentación técnica completa de Kyros**
Última actualización: 2024
