<?php
$page_title = 'Crear cuenta - ' . htmlspecialchars($storeData['name'] ?? 'Tienda');
$view_content = 'public/customer-register-content.php';
include VIEWS_PATH . 'layouts/store.php';
