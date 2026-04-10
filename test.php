<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🧪 TEST DE KYROS</h1>";

// 1. Verificar Config
echo "<h2>1. Verificar Configuración</h2>";
try {
    require_once __DIR__ . '/app/config/Config.php';
    echo "✅ Config.php cargado<br>";
    echo "App Name: " . APP_NAME . "<br>";
    echo "Base URL: " . BASE_URL . "<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// 2. Verificar Database
echo "<h2>2. Verificar Database</h2>";
try {
    require_once __DIR__ . '/app/config/Database.php';
    $db = new Database();
    $conn = $db->connect();
    echo "✅ Database.php cargado<br>";
    if ($conn) {
        echo "✅ Conexión a BD exitosa<br>";
    }
} catch (Exception $e) {
    echo "❌ Error BD: " . $e->getMessage() . "<br>";
}

// 3. Verificar Auth
echo "<h2>3. Verificar Auth</h2>";
try {
    require_once __DIR__ . '/app/middleware/Auth.php';
    echo "✅ Auth.php cargado<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// 4. Verificar Helper
echo "<h2>4. Verificar Helper</h2>";
try {
    require_once __DIR__ . '/app/helpers/Helper.php';
    echo "✅ Helper.php cargado<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// 5. Verificar PublicController
echo "<h2>5. Verificar PublicController</h2>";
try {
    require_once __DIR__ . '/app/controllers/PublicController.php';
    echo "✅ PublicController.php cargado<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "✅ TODOS LOS ARCHIVOS CARGADOS CORRECTAMENTE";
?>
