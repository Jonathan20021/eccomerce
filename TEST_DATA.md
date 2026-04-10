# 🧪 Test Data - Kyros

Script SQL para poblar la BD con datos de prueba.

## Instrucciones

1. Asegúrate de que init.sql ya fue ejecutado
2. Abre phpMyAdmin → kyros_saas
3. Ve a pestaña "SQL"
4. Copia y pega el contenido de este archivo
5. Ejecuta (Ctrl+Enter o botón "Ejecutar")

---

## Datos de Prueba

```sql
-- ============================================
-- USUARIOS DE PRUEBA
-- ============================================

-- SuperAdmin (ya existe de la instalación)
-- Email: admin@kyros.com
-- Pass: admin123

-- Tienda Owner 1
INSERT INTO users (name, email, password, phone, role, is_active, email_verified) 
VALUES (
    'Juan Pérez',
    'juan@example.com',
    '$2y$10$O8nJPxSQ8X2tKz7z8uZmE.K6B6Xx7M5K3L9X8P7Z6Y5W4V3U2T1S0',
    '+34 612 345 678',
    'store_owner',
    TRUE,
    TRUE
);

-- Tienda Owner 2
INSERT INTO users (name, email, password, phone, role, is_active, email_verified) 
VALUES (
    'María García',
    'maria@example.com',
    '$2y$10$O8nJPxSQ8X2tKz7z8uZmE.K6B6Xx7M5K3L9X8P7Z6Y5W4V3U2T1S0',
    '+34 698 765 432',
    'store_owner',
    TRUE,
    TRUE
);

-- Cliente
INSERT INTO users (name, email, password, phone, role, is_active, email_verified) 
VALUES (
    'Cliente Test',
    'cliente@example.com',
    '$2y$10$O8nJPxSQ8X2tKz7z8uZmE.K6B6Xx7M5K3L9X8P7Z6Y5W4V3U2T1S0',
    '+34 612 123 456',
    'customer',
    TRUE,
    TRUE
);

-- ============================================
-- LICENCIAS DE PRUEBA
-- ============================================

-- Licencia Starter (Trial) para Tienda 1
INSERT INTO licenses (code, plan, is_trial, trial_days, trial_ends_at, status) 
VALUES (
    'STARTER-TRIAL-001',
    'starter',
    TRUE,
    15,
    DATE_ADD(NOW(), INTERVAL 15 DAY),
    'active'
);

-- Licencia Professional (Trial) para Tienda 2
INSERT INTO licenses (code, plan, is_trial, trial_days, trial_ends_at, status) 
VALUES (
    'PRO-TRIAL-001',
    'professional',
    TRUE,
    15,
    DATE_ADD(NOW(), INTERVAL 15 DAY),
    'active'
);

-- Licencia Enterprise (Paid)
INSERT INTO licenses (code, plan, is_trial, expires_at, status) 
VALUES (
    'ENT-PAID-001',
    'enterprise',
    FALSE,
    DATE_ADD(NOW(), INTERVAL 1 YEAR),
    'active'
);

-- ============================================
-- TIENDAS
-- ============================================

-- Tienda 1: Electrónica
INSERT INTO stores (owner_id, name, slug, description, whatsapp_number, email, phone, city, country, plan_id, is_active) 
VALUES (
    1,
    'TechStore Colombia',
    'techstore-colombia',
    'Tienda especializada en electrónica y gadgets',
    '573001234567',
    'info@techstore.com',
    '+57 300 123 4567',
    'Bogotá',
    'Colombia',
    1,
    TRUE
);

-- Tienda 2: Moda
INSERT INTO stores (owner_id, name, slug, description, whatsapp_number, email, phone, city, country, plan_id, is_active) 
VALUES (
    2,
    'FashionHub México',
    'fashionhub-mexico',
    'Ropa, calzado y accesorios de moda',
    '525512345678',
    'info@fashionhub.mx',
    '+52 55 1234 5678',
    'México DF',
    'México',
    2,
    TRUE
);

-- ============================================
-- CATEGORÍAS
-- ============================================

INSERT INTO categories (store_id, name, slug, description) 
VALUES 
    (1, 'Celulares', 'celulares', 'Teléfonos inteligentes'),
    (1, 'Laptops', 'laptops', 'Computadoras portátiles'),
    (1, 'Accesorios', 'accesorios', 'Fundas, cables, etc'),
    (2, 'Hombre', 'hombre', 'Ropa para hombres'),
    (2, 'Mujer', 'mujer', 'Ropa para mujeres'),
    (2, 'Accesorios', 'accesorios-moda', 'Bolsas, cinturones, etc');

-- ============================================
-- PRODUCTOS
-- ============================================

-- Tienda 1: Electrónica
INSERT INTO products (store_id, name, slug, description, price, discount_price, cost, sku, category_id, stock, rating) 
VALUES 
    (1, 'Samsung Galaxy A52', 'samsung-galaxy-a52', 'Smartphone Samsung con pantalla AMOLED', 299.99, 249.99, 150, 'SKU001', 1, 50, 4.5),
    (1, 'iPhone 14 Pro', 'iphone-14-pro', 'Último modelo de Apple', 999.99, NULL, 600, 'SKU002', 1, 20, 4.8),
    (1, 'Laptop Dell XPS 13', 'laptop-dell-xps', 'Computadora portátil ultraligera', 1299.99, 1199.99, 800, 'SKU003', 2, 15, 4.7),
    (1, 'Funda para celular', 'funda-celular', 'Funda protectora de silicona', 15.99, 12.99, 5, 'SKU004', 3, 200, 4.2),
    (1, 'Cable USB-C', 'cable-usb-c', 'Cable de carga rápida', 19.99, 14.99, 3, 'SKU005', 3, 500, 4.6);

-- Tienda 2: Moda
INSERT INTO products (store_id, name, slug, description, price, discount_price, cost, sku, category_id, stock, rating) 
VALUES 
    (2, 'Camiseta Básica Azul', 'camiseta-basica-azul', 'Camiseta 100% algodón de alta calidad', 24.99, 19.99, 8, 'TSHIRT001', 4, 100, 4.3),
    (2, 'Jean Azul Oscuro', 'jean-azul-oscuro', 'Pantalón jean clásico para hombre', 59.99, 49.99, 20, 'JEAN001', 4, 75, 4.4),
    (2, 'Vestido Negro Elegante', 'vestido-negro-elegante', 'Vestido formal para eventos', 89.99, NULL, 40, 'DRESS001', 5, 30, 4.6),
    (2, 'Bolsa de Cuero Marrón', 'bolsa-cuero-marron', 'Bolsa grande con múltiples compartimentos', 79.99, 64.99, 30, 'BAG001', 6, 50, 4.5),
    (2, 'Cinturón Negro', 'cinturon-negro', 'Cinturón de cuero genuino', 34.99, 24.99, 10, 'BELT001', 6, 120, 4.2);

-- ============================================
-- ÓRDENES DE PRUEBA
-- ============================================

-- Orden 1
INSERT INTO orders (order_number, user_id, store_id, status, total, subtotal, tax, customer_name, customer_email, customer_phone, shipping_address, payment_method, payment_status) 
VALUES (
    '#ORD-2024-001',
    3,
    1,
    'delivered',
    304.98,
    264.98,
    40,
    'Cliente Test',
    'cliente@example.com',
    '+34 612 123 456',
    'Calle Principal 123, Bogotá',
    'whatsapp',
    'paid'
);

-- Orden 2
INSERT INTO orders (order_number, user_id, store_id, status, total, subtotal, tax, customer_name, customer_email, customer_phone, shipping_address, payment_method, payment_status) 
VALUES (
    '#ORD-2024-002',
    3,
    2,
    'processing',
    119.97,
    104.98,
    15,
    'Cliente Test',
    'cliente@example.com',
    '+34 612 123 456',
    'Avenida Central 456, México',
    'whatsapp',
    'pending'
);

-- ============================================
-- ITEMS DE ÓRDENES
-- ============================================

-- Items de Orden 1
INSERT INTO order_items (order_id, product_id, quantity, price, subtotal) 
VALUES 
    (1, 2, 1, 249.99, 249.99),
    (1, 5, 1, 14.99, 14.99);

-- Items de Orden 2
INSERT INTO order_items (order_id, product_id, quantity, price, subtotal) 
VALUES 
    (2, 6, 1, 19.99, 19.99),
    (2, 7, 3, 28.33, 84.99);

-- ============================================
-- ITEMS DEL CARRITO
-- ============================================

INSERT INTO cart_items (user_id, product_id, quantity, added_at) 
VALUES 
    (3, 3, 1, NOW()),
    (3, 8, 2, NOW());

-- ============================================
-- FIN DE DATOS DE PRUEBA
-- ============================================

```

---

## Credenciales de Prueba

### SuperAdmin
- **Email**: admin@kyros.com
- **Contraseña**: admin123

### Tienda Owner 1
- **Nombre**: Juan Pérez
- **Email**: juan@example.com
- **Contraseña**: admin123
- **Tienda**: TechStore Colombia

### Tienda Owner 2
- **Nombre**: María García
- **Email**: maria@example.com
- **Contraseña**: admin123
- **Tienda**: FashionHub México

### Cliente
- **Email**: cliente@example.com
- **Contraseña**: admin123

---

## Pruebas Recomendadas

1. **Login SuperAdmin** → Verificar acceso a panel de licencias y tiendas
2. **Login como Tienda** → Crear producto, ver órdenes
3. **Visitar tienda pública** → techstore-colombia y fashionhub-mexico
4. **Carrito** → Agregar productos, ver total
5. **Checkout** → Completar compra por WhatsApp

---

**Datos creados para pruebas de Kyros**
