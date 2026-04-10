<?php
$page_title = 'Detalle de orden - ' . htmlspecialchars($storeData['name'] ?? 'Tienda');
$view_content = 'public/customer-order-detail-content.php';
include VIEWS_PATH . 'layouts/store.php';
