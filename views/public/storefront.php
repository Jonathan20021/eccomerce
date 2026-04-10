<!-- Public Storefront -->
<?php
$page_title = htmlspecialchars($storeData['name']) . " - Tienda Online";
$view_content = 'public/storefront-content.php';
include VIEWS_PATH . 'layouts/store.php';
?>
