<?php
$page_title = 'Mis direcciones - ' . htmlspecialchars($storeData['name'] ?? 'Tienda');
$view_content = 'public/customer-addresses-content.php';
include VIEWS_PATH . 'layouts/store.php';
