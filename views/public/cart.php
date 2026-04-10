<!-- Public Cart -->
<?php
$storeName = isset($storeData['name']) ? $storeData['name'] : APP_NAME;
$page_title = "Carrito - " . htmlspecialchars($storeName);
$view_content = 'public/cart-content.php';
include VIEWS_PATH . 'layouts/store.php';
?>
