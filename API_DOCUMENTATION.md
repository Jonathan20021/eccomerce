# 📚 API Documentation - Kyros

Documentación completa de endpoints AJAX y APIs para integración.

---

## 🛒 Cart API

### POST /api/cart/add

Agregar producto al carrito.

**Parámetros**:
```
product_id    (int)      - ID del producto
store_id      (int)      - ID de la tienda
quantity      (int)      - Cantidad (default: 1)
```

**Ejemplo**:
```javascript
const formData = new FormData();
formData.append('product_id', 123);
formData.append('store_id', 5);
formData.append('quantity', 2);

fetch('/api/cart/add', {
    method: 'POST',
    body: formData
})
.then(res => res.json())
.then(data => {
    if (data.success) {
        console.log('Producto añadido:', data.cartCount);
    }
});
```

**Respuesta exitosa**:
```json
{
    "success": true,
    "message": "Producto añadido al carrito",
    "cartCount": 3,
    "cartTotal": 150.50
}
```

**Respuesta error**:
```json
{
    "success": false,
    "message": "Error: El producto ya existe en el carrito"
}
```

---

### POST /api/cart/update

Actualizar cantidad de producto en carrito.

**Parámetros**:
```
cart_item_id  (int)      - ID del item en carrito
quantity      (int)      - Nueva cantidad
```

**Ejemplo**:
```javascript
fetch('/api/cart/update', {
    method: 'POST',
    body: new FormData(document.querySelector('form'))
})
.then(res => res.json())
.then(data => {
    if (data.success) {
        document.getElementById('total').textContent = data.cartTotal;
    }
});
```

**Respuesta**:
```json
{
    "success": true,
    "message": "Cantidad actualizada",
    "cartTotal": 125.75,
    "itemTotal": 50.00
}
```

---

### POST /api/cart/remove

Eliminar producto del carrito.

**Parámetros**:
```
cart_item_id  (int)      - ID del item en carrito
```

**Ejemplo**:
```javascript
fetch('/api/cart/remove', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'cart_item_id=45'
})
.then(res => res.json())
.then(data => {
    if (data.success) {
        // Recargar carrito
        location.reload();
    }
});
```

**Respuesta**:
```json
{
    "success": true,
    "message": "Producto removido del carrito"
}
```

---

### GET /api/cart/count

Obtener cantidad total de items en carrito.

**Respuesta**:
```json
{
    "count": 5
}
```

---

### GET /api/cart/total

Obtener total del carrito.

**Respuesta**:
```json
{
    "total": 299.99,
    "subtotal": 250.00,
    "tax": 49.99
}
```

---

## 👥 User API (SuperAdmin)

### GET /api/users

Listar usuarios (requiere SuperAdmin).

**Parámetros**:
```
role (string) - Filtrar por rol (opcional)
page (int)    - Número de página
limit (int)   - Resultados por página
```

**Ejemplo**:
```javascript
fetch('/api/users?role=store_owner&page=1&limit=10')
    .then(res => res.json())
    .then(users => console.log(users));
```

**Respuesta**:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Juan Pérez",
            "email": "juan@example.com",
            "role": "store_owner",
            "is_active": true
        }
    ],
    "total": 25,
    "page": 1,
    "pages": 3
}
```

---

### POST /api/users

Crear nuevo usuario (requiere SuperAdmin).

**Parámetros**:
```
name          (string)   - Nombre del usuario
email         (string)   - Email único
password      (string)   - Contraseña
role          (string)   - Rol del usuario
phone         (string)   - Teléfono (opcional)
```

**Ejemplo**:
```javascript
fetch('/api/users', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({
        name: 'Nuevo Usuario',
        email: 'nuevo@example.com',
        password: 'segura123',
        role: 'store_owner'
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

**Respuesta**:
```json
{
    "success": true,
    "message": "Usuario creado exitosamente",
    "userId": 15
}
```

---

### PUT /api/users/:id

Actualizar usuario.

**Parámetros**:
```
name          (string)   - Nombre (opcional)
email         (string)   - Email (opcional)
is_active     (bool)     - Activo/Inactivo (opcional)
```

**Ejemplo**:
```javascript
fetch('/api/users/15', {
    method: 'PUT',
    body: JSON.stringify({name: 'Nombre Actualizado'}),
    headers: {'Content-Type': 'application/json'}
})
.then(res => res.json());
```

---

### DELETE /api/users/:id

Eliminar usuario.

---

## 📦 Product API

### GET /api/products

Listar productos de la tienda.

**Parámetros**:
```
store_id      (int)      - ID de tienda
category_id   (int)      - Filtrar por categoría (opcional)
sort          (string)   - Ordenar: price_asc, price_desc, newest
search        (string)   - Buscar por nombre
page          (int)      - Página
limit         (int)      - Resultados por página
```

**Ejemplo**:
```javascript
fetch('/api/products?store_id=1&sort=price_asc&limit=20')
    .then(res => res.json())
    .then(data => console.log(data));
```

**Respuesta**:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Producto A",
            "price": 99.99,
            "discount_price": 79.99,
            "image": "product.jpg",
            "rating": 4.5,
            "stock": 50
        }
    ],
    "total": 100
}
```

---

### POST /api/products

Crear producto (requiere ser store_owner).

**Parámetros**:
```
name          (string)   - Nombre del producto
description   (string)   - Descripción
price         (float)    - Precio
cost          (float)    - Costo
stock         (int)      - Stock disponible
image         (file)     - Imagen PNG/JPG (max 5MB)
category_id   (int)      - Categoría (opcional)
```

**Ejemplo (FormData)**:
```javascript
const formData = new FormData();
formData.append('name', 'Mi Producto');
formData.append('price', 99.99);
formData.append('image', fileInput.files[0]);

fetch('/api/products', {
    method: 'POST',
    body: formData  // No incluir Content-Type
})
.then(res => res.json());
```

---

### PUT /api/products/:id

Actualizar producto.

**Parámetros**:
```
name          (string)   - Nombre (opcional)
price         (float)    - Precio (opcional)
stock         (int)      - Stock (opcional)
is_active     (bool)     - Activo/Inactivo (opcional)
```

---

### DELETE /api/products/:id

Eliminar producto.

---

## 📋 Order API

### GET /api/orders

Listar órdenes.

**Parámetros**:
```
store_id      (int)      - ID de tienda (obligatorio)
status        (string)   - Filtrar por estado
page          (int)      - Página
limit         (int)      - Resultados por página
```

**Respuesta**:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "order_number": "#ORD-2024-001",
            "total": 150.00,
            "status": "pending",
            "customer_name": "Cliente",
            "created_at": "2024-01-15 10:30:00"
        }
    ]
}
```

---

### POST /api/orders

Crear nueva orden (checkout).

**Parámetros**:
```
store_id              (int)    - ID de tienda
customer_name         (string) - Nombre del cliente
customer_email        (string) - Email del cliente
customer_phone        (string) - Teléfono del cliente
shipping_address      (string) - Dirección de envío
payment_method        (string) - Método de pago
```

**Respuesta**:
```json
{
    "success": true,
    "orderId": 45,
    "orderNumber": "#ORD-2024-045",
    "total": 299.99
}
```

---

### PUT /api/orders/:id

Actualizar orden.

**Parámetros**:
```
status         (string)  - Nuevo estado
payment_status (string)  - Estado del pago
```

**Ejemplo**:
```javascript
fetch('/api/orders/45', {
    method: 'PUT',
    body: JSON.stringify({
        status: 'shipped',
        payment_status: 'paid'
    }),
    headers: {'Content-Type': 'application/json'}
})
```

---

## 🏪 Store API

### GET /api/stores

Listar tiendas públicamente.

**Parámetros**:
```
page          (int)      - Página
limit         (int)      - Resultados por página
```

---

### GET /api/stores/:slug

Obtener información de tienda pública.

**Respuesta**:
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Mi Tienda",
        "slug": "mi-tienda",
        "description": "Descripción de la tienda",
        "logo": "logo.jpg",
        "whatsapp_number": "34612345678",
        "products": 25,
        "rating": 4.5
    }
}
```

---

### GET /api/stores/:id/analytics

Obtener análisis de tienda (requiere ser propietario).

**Respuesta**:
```json
{
    "success": true,
    "data": {
        "total_products": 25,
        "total_orders": 100,
        "total_revenue": 5000.00,
        "monthly_revenue": 1250.00,
        "average_order_value": 50.00,
        "conversion_rate": 2.5
    }
}
```

---

## 💳 License API (SuperAdmin)

### GET /api/licenses

Listar licencias.

**Respuesta**:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "code": "STARTER-001",
            "plan": "starter",
            "is_trial": true,
            "status": "active",
            "expires_at": "2024-02-15",
            "store_id": null
        }
    ]
}
```

---

### POST /api/licenses

Crear nueva licencia.

**Parámetros**:
```
plan          (string)   - Tipo de plan: starter|professional|enterprise
is_trial      (bool)     - Es licencia de prueba
trial_days    (int)      - Días de prueba (si es_trial=true)
```

**Respuesta**:
```json
{
    "success": true,
    "code": "STARTER-12345",
    "message": "Licencia creada exitosamente"
}
```

---

## 🔍 Search API

### GET /api/search

Buscar productos en todas las tiendas.

**Parámetros**:
```
q             (string)   - Término de búsqueda
category      (string)   - Filtrar por categoría
min_price     (float)    - Precio mínimo
max_price     (float)    - Precio máximo
sort          (string)   - Ordenar resultados
```

**Ejemplo**:
```javascript
fetch('/api/search?q=laptop&min_price=500&max_price=2000')
    .then(res => res.json())
    .then(data => console.log(data));
```

**Respuesta**:
```json
{
    "success": true,
    "results": [
        {
            "id": 1,
            "name": "Laptop HP",
            "price": 999.99,
            "store_name": "TechStore",
            "store_slug": "techstore"
        }
    ],
    "total": 23
}
```

---

## 📊 Statistics API (SuperAdmin)

### GET /api/statistics

Obtener estadísticas del sistema.

**Respuesta**:
```json
{
    "success": true,
    "data": {
        "total_users": 150,
        "total_stores": 25,
        "total_products": 5000,
        "total_orders": 1250,
        "total_revenue": 125000.00,
        "active_licenses": 20,
        "trial_licenses": 5,
        "expired_licenses": 2
    }
}
```

---

## ⚠️ Respuestas de Error

Todos los endpoints pueden retornar estos errores:

```json
{
    "success": false,
    "message": "Mensaje de error descriptivo"
}
```

### Códigos de error comunes:

```
400 - Bad Request: Parámetros inválidos
401 - Unauthorized: No autenticado/autorizado
403 - Forbidden: No tienes permiso
404 - Not Found: Recurso no existe
500 - Server Error: Error interno del servidor
```

---

## 🔐 Autenticación

Todos los endpoints requieren:

1. **Sesión PHP activa**
   - Cookie `PHPSESSID` presente
   - Usuario debe estar logueado

2. **Permisos correctos**
   - Algunos endpoints solo para SuperAdmin
   - Otros requieren ser propietario de la tienda

3. **CSRF Protection (futuro)**
   - Se agregará token anti-CSRF en futuras versiones

---

## 📱 Ejemplos JavaScript Utilities

En `assets/js/script.js`:

```javascript
// Helper para fetch con manejo de errores
const Kyros = {
    API: {
        post: (url, data) => {
            return fetch(url, {
                method: 'POST',
                body: new FormData(data)
            }).then(r => r.json());
        },
        
        get: (url) => {
            return fetch(url).then(r => r.json());
        }
    }
};

// Uso
Kyros.API.post('/api/cart/add', cartForm)
    .then(data => console.log(data));
```

---

**Documentación API Kyros**
Última actualización: 2024
