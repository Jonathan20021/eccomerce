# 🚀 Deployment Checklist - Kyros

Verificación previa antes de llevar Kyros a producción.

---

## 📋 Checklist Pre-Deployment

### 1. Seguridad

- [ ] **Contraseña SuperAdmin cambiada**
  - [ ] SuperAdmin no usa contraseña por defecto
  - [ ] Nueva contraseña tiene 15+ caracteres

- [ ] **Credenciales de BD seguras**
  - [ ] Usuario MySQL no es 'root'
  - [ ] Contraseña MySQL es fuerte
  - [ ] Usuario solo tiene permisos en BD kyros_saas

- [ ] **Archivos sensibles protegidos**
  - [ ] `app/config/Database.php` no es público
  - [ ] `app/` carpeta no es accesible desde web
  - [ ] `.env` no está en repositorio público

- [ ] **HTTPS configurado**
  - [ ] SSL certificate instalado
  - [ ] Todas las URLs usan `https://`
  - [ ] Mixed content warnings resueltos

- [ ] **Headers de seguridad**
  - [ ] X-Frame-Options configurado
  - [ ] X-Content-Type-Options configurado
  - [ ] Strict-Transport-Security habilitado

### 2. Performance

- [ ] **Caché habilitado**
  - [ ] Browser caching configurado (.htaccess)
  - [ ] CDN configurado para imágenes (opcional)

- [ ] **Base de datos optimizada**
  - [ ] Índices creados en columnas frecuentes
  - [ ] Queries analizadas con EXPLAIN
  - [ ] Backups automáticos configurados

- [ ] **Imágenes optimizadas**
  - [ ] Imágenes comprimidas
  - [ ] Formatos modernos (WebP) en uso

- [ ] **CSS/JS minificado**
  - [ ] Archivos CSS concatenados
  - [ ] JavaScript bundled
  - [ ] Gzip compresión activa

### 3. Configuración

- [ ] **BASE_URL correcto**
  - [ ] En `Config.php` apunta a dominio real
  - [ ] No incluye `localhost`
  - [ ] Usa HTTPS en producción

- [ ] **Base de datos**
  - [ ] `Database.php` con credenciales reales
  - [ ] Conexión a servidor remoto verifica
  - [ ] Charset es UTF-8

- [ ] **Email configurado**
  - [ ] SMTP credentials en `Config.php`
  - [ ] Emails de prueba se envían
  - [ ] Reply-to address es correcto

### 4. Funcionalidad

- [ ] **Registro de tiendas funciona**
  - [ ] Usuarios pueden registrarse
  - [ ] Se crean tiendas automáticamente
  - [ ] Licencias de prueba se asignan
  - [ ] Emails de bienvenida se envían

- [ ] **Dashboard de tienda OK**
  - [ ] Propietarios acceden al admin
  - [ ] Subida de productos funciona
  - [ ] Imágenes se guardan correctamente
  - [ ] Edición de productos OK

- [ ] **Tienda pública funciona**
  - [ ] Clientes ven productos
  - [ ] Búsqueda y filtros funcionan
  - [ ] Carrito agrega/elimina items
  - [ ] Checkout completo

- [ ] **Órdenes funciona**
  - [ ] Se crean órdenes
  - [ ] Propietario recibe notificaciones
  - [ ] Estados de orden actualizan
  - [ ] Historial de órdenes visible

- [ ] **Contacto por wa.me operativo**
  - [ ] Enlaces wa.me generan correctamente
  - [ ] Números almacenan bien
  - [ ] Clientes pueden contactar

### 5. SuperAdmin Panel

- [ ] **Licencias manejables**
  - [ ] SuperAdmin crea licencias
  - [ ] Códigos generan correctamente
  - [ ] Licencias se asignan a tiendas

- [ ] **Tiendas visibles**
  - [ ] SuperAdmin ve todas las tiendas
  - [ ] Puede ver detalles de tienda
  - [ ] Puede activar/desactivar

- [ ] **Estadísticas correctas**
  - [ ] Totales calculan bien
  - [ ] Gráficos muestran datos

### 6. API

- [ ] **Endpoints funcionan**
  - [ ] `/api/cart/add` OK
  - [ ] `/api/cart/update` OK
  - [ ] `/api/cart/remove` OK
  - [ ] `/api/products` OK

- [ ] **Respuestas JSON válidas**
  - [ ] No hay HTML en respuestas
  - [ ] Códigos de error correctos
  - [ ] Mensajes descriptivos

### 7. Integraciones

- [ ] **Enlaces wa.me**
  - [ ] Enlaces generan correctamente
  - [ ] URLs están codificadas
  - [ ] Mensajes se precargan correctamente

- [ ] **Email (futuro)**
  - [ ] SMTP configurado
  - [ ] Prueba de envío exitosa
  - [ ] Templates HTML

### 8. Hosting/Servidor

- [ ] **PHP 7.4+**
  - [ ] Versión correcta en servidor
  - [ ] Extensiones requeridas: PDO, PDO-MySQL

- [ ] **Apache/Nginx**
  - [ ] mod_rewrite activo (Apache)
  - [ ] .htaccess funciona
  - [ ] Rutas se resuelven

- [ ] **MySQL 5.7+**
  - [ ] Base de datos creada
  - [ ] Todas las tablas presentes
  - [ ] Datos de prueba limpios

- [ ] **Permisos de archivos**
  - [ ] `public/uploads/` escribible (755)
  - [ ] `logs/` escribible (755)
  - [ ] `cache/` escribible (755)
  - [ ] Otros directorios legibles (644)

- [ ] **SSL/HTTPS**
  - [ ] Certificado válido
  - [ ] Renovación automática (Let's Encrypt)
  - [ ] Redirección HTTP → HTTPS

### 9. Monitoreo

- [ ] **Logs configurados**
  - [ ] Errores de PHP se registran
  - [ ] Accesos de usuario se loguean
  - [ ] Errores de BD se detectan

- [ ] **Backups automáticos**
  - [ ] BD se respalda diariamente
  - [ ] Archivos backupeados
  - [ ] Restauración probada

- [ ] **Monitoreo activo**
  - [ ] Uptime monitoring
  - [ ] Performance monitoring
  - [ ] Alertas configuradas

### 10. Legal/Compliance

- [ ] **Privacidad**
  - [ ] Política de privacidad visible
  - [ ] Términos de servicio en landing
  - [ ] GDPR compliance (si aplica)

- [ ] **Datos**
  - [ ] Usuarios pueden borrar cuenta
  - [ ] Datos se eliminan al borrar
  - [ ] Exportación de datos disponible (futuro)

---

## 📝 Pre-Deployment Checklist

Ejecuta antes de ir live:

### 1. Limpiar datos de prueba
```sql
DELETE FROM cart_items WHERE user_id IN (1,2,3);
DELETE FROM order_items WHERE order_id IN (1,2);
DELETE FROM orders WHERE id IN (1,2);
DELETE FROM reviews WHERE product_id > 100;
DELETE FROM products WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 DAY);
-- Mantener licencias de prueba
```

### 2. Revisar configuración
```php
// app/config/Config.php
define('DEBUG', false);                          // ✅ DESACTIVADO
define('BASE_URL', 'https://tudominio.com/');   // ✅ CORRECTO
```

### 3. Limpieza de carpetas
```bash
rm -rf cache/*
rm -rf logs/*
rm -f app/config/.env.example
chmod 755 public/uploads
```

### 4. Test de acceso
- [ ] http://tudominio.com/ → Landing
- [ ] http://tudominio.com/auth/login → Login
- [ ] http://tudominio.com/auth/register → Registro
- [ ] http://tudominio.com/admin/ → Require login
- [ ] http://tudominio.com/superadmin/ → Require login

### 5. Test de funcionalidad
- [ ] Registro de tienda con plan
- [ ] Crear producto
- [ ] Agregar al carrito
- [ ] Procesar orden
- [ ] SuperAdmin ver licencias

### 6. Performance test
```bash
# Usando Apache Bench
ab -n 100 -c 10 https://tudominio.com/

# Usando curl
curl -I https://tudominio.com/
```

---

## 🔧 Configuración Hosting

### GoDaddy
```
1. Hosting Plan → Administrador
2. PHP → Versión 8.0+
3. MySQL → Crear BD
4. SSL → Certificado Let's Encrypt
5. Archivos → Subir vía FTP
```

### Hostinger
```
1. Panel → Sitios web
2. PHP → 8.0+
3. BD → phpMyAdmin
4. Email → Configurar SMTP
5. SSL → Auto
```

### DigitalOcean (VPS)
```bash
# SSH al servidor
ssh root@your_ip

# Actualizar sistema
apt update && apt upgrade -y

# Instalar paquetes
apt install -y php php-mysql apache2 mysql-server

# Configurar Apache
a2enmod rewrite
systemctl restart apache2

# Subir archivos
scp -r kyros/ root@your_ip:/var/www/html/

# Crear BD
mysql -u root -p -e "CREATE DATABASE kyros_saas;"
mysql -u root -p kyros_saas < /var/www/html/kyros/app/config/init.sql

# Permisos
chmod 755 /var/www/html/kyros/public/uploads

# SSL
sudo certbot --apache -d tudominio.com
```

---

## 🎯 Estrategia de Go-Live

### 1. Pre-launch (1 día antes)
- Todos los tests pasan
- Backups completos hechos
- Notificación a webmaster

### 2. Launch time
- Cambiar DNS a nuevo servidor
- Esperar propagación (15-30 min)
- Monitoreo activo

### 3. Post-launch (primeras 24 horas)
- Monitoreo constante
- Soporte rápido
- Backups frecuentes

### 4. Primera semana
- Gather user feedback
- Monitor performance
- Fix bugs encontrados

---

## 🆘 Rollback Plan

Si algo falla:

```bash
# 1. Saltar a versión anterior
git checkout HEAD~1

# 2. Restaurar BD
mysql -u root -p kyros_saas < backup_2024_01_15.sql

# 3. Reiniciar Apache
systemctl restart apache2

# 4. Notificar usuarios
# (Email a admin con detalles)
```

---

## 📞 Contacto y Escalaciones

Cuando deployes, ten estos contactos listos:

- **Hosting Support**: [Tu hosting]
- **Domain Registrar**: [Tu registrador]
- **SSL Certificate**: [Proveedor SSL]
- **Email Backup**: admin@tudominio.com

---

**Deployment Checklist - Kyros SaaS**
Última actualización: 2024
