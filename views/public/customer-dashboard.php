<?php
$page_title = 'Mi cuenta - ' . htmlspecialchars($storeData['name'] ?? 'Tienda');
$view_content = 'public/customer-dashboard-content.php';
include VIEWS_PATH . 'layouts/store.php';
