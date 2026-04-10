<!-- Public Product Detail -->
<?php
$page_title = htmlspecialchars($productData['name']) . " - " . htmlspecialchars($storeData['name']);
$view_content = 'public/product-content.php';
include VIEWS_PATH . 'layouts/store.php';
?>
