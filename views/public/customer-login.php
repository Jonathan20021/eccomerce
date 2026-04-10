<?php
$page_title = 'Iniciar sesión - ' . htmlspecialchars($storeData['name'] ?? 'Tienda');
$view_content = 'public/customer-login-content.php';
include VIEWS_PATH . 'layouts/store.php';
