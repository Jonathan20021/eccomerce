<?php

// Configuración general de la aplicación
define('APP_NAME', 'Kyros Commerce');
define('APP_VERSION', '1.0.0');

// BASE_URL dinámico para funcionar en local y producción sin cambios manuales.
$envAppUrl = getenv('APP_URL');
if (!empty($envAppUrl)) {
    $baseUrl = rtrim($envAppUrl, '/') . '/';
} else {
    $isHttps = (
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
        (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443)
    );
    $scheme = $isHttps ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
    $scriptDir = trim($scriptDir, '/');
    $pathPrefix = $scriptDir !== '' ? '/' . $scriptDir . '/' : '/';

    $baseUrl = $scheme . '://' . $host . $pathPrefix;
}

define('BASE_URL', $baseUrl);
define('APP_URL', BASE_URL);
define('APP_ENV', getenv('APP_ENV') ?: 'development');
define('ENABLE_DEMO_ACCOUNTS', APP_ENV !== 'production');
define('SHOW_DEMO_PASSWORDS', APP_ENV !== 'production');

// Rutas
define('APP_PATH', dirname(dirname(dirname(__FILE__))));
define('VIEWS_PATH', APP_PATH . '/views/');
define('ASSETS_PATH', BASE_URL . 'assets/');

// Configuración de sesión
session_set_cookie_params([
    'lifetime' => 86400 * 7, // 7 días
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Moltilas de tienda
define('PLAN_STARTER', [
    'id' => 1,
    'name' => 'Starter',
    'price' => 0,
    'products' => 50,
    'storage' => 5, // GB
    'features' => ['basic_storefront', 'products', 'orders', 'inventory_module'],
    'module_inventory' => true,
    'module_finance' => false
]);

define('PLAN_PROFESSIONAL', [
    'id' => 2,
    'name' => 'Professional',
    'price' => 99,
    'products' => 500,
    'storage' => 50,
    'features' => ['advanced_storefront', 'analytics', 'seo', 'api', 'inventory_module', 'finance_module'],
    'module_inventory' => true,
    'module_finance' => true
]);

define('PLAN_ENTERPRISE', [
    'id' => 3,
    'name' => 'Enterprise',
    'price' => 299,
    'products' => -1, // Ilimitado
    'storage' => 500,
    'features' => ['full_customization', 'dedicated_support', 'api', 'webhooks', 'white_label', 'inventory_module', 'finance_module'],
    'module_inventory' => true,
    'module_finance' => true
]);

// Roles
define('ROLE_SUPERADMIN', 'superadmin');
define('ROLE_STORE_OWNER', 'store_owner');
define('ROLE_STORE_STAFF', 'store_staff');
define('ROLE_CUSTOMER', 'customer');
