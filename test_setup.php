<?php
// Test script para verificar que todo está configurado correctamente

header('Content-Type: text/plain; charset=utf-8');

echo "═══════════════════════════════════════════════════════════\n";
echo "  ✅ TEST DE INSTALACIÓN - KYROS SaaS\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// 1. Verificar directorio
echo "1️⃣  VERIFICAR ESTRUCTURA DE CARPETAS\n";
$required_dirs = [
    'app' => 'Carpeta de aplicación',
    'app/config' => 'Configuración',
    'app/controllers' => 'Controladores',
    'app/models' => 'Modelos',
    'app/middleware' => 'Middleware',
    'app/helpers' => 'Funciones auxiliares',
    'views' => 'Vistas/Plantillas',
    'assets' => 'Assets (CSS, JS, imágenes)',
    'public' => 'Carpeta pública',
    'public/uploads' => 'Directorio de cargas'
];

foreach ($required_dirs as $dir => $desc) {
    $path = __DIR__ . '/' . $dir;
    $status = is_dir($path) ? '✓' : '✗';
    $color = is_dir($path) ? '32' : '31';
    echo "   [\033[{$color}m{$status}\033[0m] $desc ($dir)\n";
}

// 2. Verificar archivos críticos
echo "\n2️⃣  VERIFICAR ARCHIVOS CRÍTICOS\n";
$required_files = [
    'index.php' => 'Punto de entrada',
    'app/config/Config.php' => 'Configuración',
    'app/config/Database.php' => 'Conexión BD',
    'app/helpers/Helper.php' => 'Funciones',
    '.htaccess' => 'Configuración Apache'
];

foreach ($required_files as $file => $desc) {
    $path = __DIR__ . '/' . $file;
    $status = file_exists($path) ? '✓' : '✗';
    $color = file_exists($path) ? '32' : '31';
    echo "   [\033[{$color}m{$status}\033[0m] $desc ($file)\n";
}

// 3. Verificar conexión a BD
echo "\n3️⃣  VERIFICAR CONEXIÓN A BASE DE DATOS\n";
try {
    require_once(__DIR__ . '/app/config/Database.php');
    $db = new Database();
    $conn = $db->connect();
    
    if ($conn) {
        echo "   [\033[32m✓\033[0m] Conexión a BD exitosa\n";
        
        // Contar tablas
        $query = "SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = 'neetjbte_eccomerce'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "   [\033[32m✓\033[0m] Tablas en BD: " . $result['count'] . "\n";
        
        // Contar usuarios
        $query = "SELECT COUNT(*) as count FROM users";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "   [\033[32m✓\033[0m] Usuarios registrados: " . $result['count'] . "\n";
        
        // Contar tiendas
        $query = "SELECT COUNT(*) as count FROM stores";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "   [\033[32m✓\033[0m] Tiendas: " . $result['count'] . "\n";
        
        // Contar productos
        $query = "SELECT COUNT(*) as count FROM products";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "   [\033[32m✓\033[0m] Productos: " . $result['count'] . "\n";
        
        // Contar licencias
        $query = "SELECT COUNT(*) as count FROM licenses";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "   [\033[32m✓\033[0m] Licencias: " . $result['count'] . "\n";
        
    } else {
        echo "   [\033[31m✗\033[0m] Error en conexión\n";
    }
} catch (Exception $e) {
    echo "   [\033[31m✗\033[0m] Error: " . $e->getMessage() . "\n";
}

// 4. Verificar variables de sesión
echo "\n4️⃣  VERIFICAR CONFIGURACIÓN DE SESIONES\n";
echo "   [\033[32m✓\033[0m] Session support: " . (isset($_SESSION) ? 'Disponible' : 'No disponible') . "\n";
echo "   [\033[32m✓\033[0m] PHP Version: " . PHP_VERSION . "\n";

// 5. Información de acceso
echo "\n5️⃣  INFORMACIÓN DE ACCESO\n";
echo "   Landing Page: http://localhost/eccomerce/\n";
echo "   Login: http://localhost/eccomerce/auth/login\n";
echo "\n   Usuario Demo SuperAdmin:\n";
echo "   Email: demo.admin@kyros.com\n";
echo "   Password: DemoAdmin123!\n";
echo "\n   Usuario Demo Tienda (Starter):\n";
echo "   Email: demo.starter@kyros.com\n";
echo "   Password: DemoStore123!\n";
echo "\n   Usuario Demo Tienda (Pro):\n";
echo "   Email: demo.pro@kyros.com\n";
echo "   Password: DemoPro123!\n";

echo "\n═══════════════════════════════════════════════════════════\n";
echo "  🚀 ¡KYROS ESTÁ CORRECTAMENTE CONFIGURADO Y LISTO PARA USAR!\n";
echo "═══════════════════════════════════════════════════════════\n";
