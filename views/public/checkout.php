<!-- Public Checkout -->
<?php
$page_title = "Checkout - " . htmlspecialchars($storeData['name']);
$view_content = 'public/checkout-content.php';
include VIEWS_PATH . 'layouts/store.php';
?>
