<?php
$page_title = 'Mi perfil - ' . htmlspecialchars($storeData['name'] ?? 'Tienda');
$view_content = 'public/customer-profile-content.php';
include VIEWS_PATH . 'layouts/store.php';
