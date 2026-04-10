<?php

require_once __DIR__ . '/../config/Config.php';
require_once __DIR__ . '/../models/Store.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Review.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/CustomerAddress.php';
require_once __DIR__ . '/../models/License.php';
require_once __DIR__ . '/../models/PlanChangeRequest.php';
require_once __DIR__ . '/../models/Setting.php';
require_once __DIR__ . '/../helpers/Helper.php';
require_once __DIR__ . '/../middleware/Auth.php';

class AdminController {
    
    public static function dashboard() {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();
        $store_id = Auth::getStoreId();

        $store = new Store();
        $storeData = $store->findById($store_id);

        $product = new Product();
        $totalProducts = $product->countByStore($store_id);

        $order = new Order();
        $totalOrders = $order->countByStore($store_id);
        $totalRevenue = $order->getTotalRevenue($store_id);

        $recentOrders = $order->getByStore($store_id, 10, 0);
        $enabledModules = self::getEnabledModulesForStore($store_id, $storeData);
        $currentPlanId = intval($storeData['plan_id'] ?? 1);
        $activeLicense = (new License())->findActiveByStoreId($store_id);
        if ($activeLicense && !empty($activeLicense['plan_id'])) {
            $currentPlanId = intval($activeLicense['plan_id']);
        }
        $planNames = [1 => 'Starter', 2 => 'Professional', 3 => 'Enterprise'];
        $currentPlanName = $planNames[$currentPlanId] ?? ('Plan ' . $currentPlanId);

        $enabledModuleLabels = [];
        if (!empty($enabledModules['inventory'])) {
            $enabledModuleLabels[] = 'Inventario';
        }
        if (!empty($enabledModules['finance'])) {
            $enabledModuleLabels[] = 'Finanzas';
        }

        $storageLimitGb = self::getStoreStorageLimitGb($store_id, $storeData);

        $storageUsedBytes = self::getStoreDiskUsageBytes($store_id);
        $storageUsedGb = $storageUsedBytes / pow(1024, 3);
        $storageAvailableGb = max(0, $storageLimitGb - $storageUsedGb);
        $storageUsagePercent = $storageLimitGb > 0 ? min(100, ($storageUsedGb / $storageLimitGb) * 100) : 0;
        $storageUsageLevel = 'ok';
        if ($storageUsagePercent >= 95) {
            $storageUsageLevel = 'critical';
        } elseif ($storageUsagePercent >= 80) {
            $storageUsageLevel = 'warning';
        }

        include VIEWS_PATH . 'admin/dashboard.php';
    }

    public static function inventory() {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();

        $store_id = Auth::getStoreId();
        self::requireModuleAccess($store_id, 'inventory');

        $store = new Store();
        $storeData = $store->findById($store_id);

        $product = new Product();
        $products = $product->getByStore($store_id, 1000, 0);

        $search = trim((string)($_GET['q'] ?? ''));
        $onlyLowStock = isset($_GET['low']) && $_GET['low'] === '1';
        $lowStockThreshold = 5;

        $inventoryRows = [];
        $totalStockUnits = 0;
        $inventoryValue = 0.0;
        $lowStockCount = 0;

        foreach ($products as $item) {
            $name = strval($item['name'] ?? '');
            $sku = strval($item['sku'] ?? '');
            $stock = intval($item['stock'] ?? 0);
            $cost = floatval($item['cost'] ?? 0);
            $matchesSearch = $search === '' || stripos($name, $search) !== false || stripos($sku, $search) !== false;
            $isLow = $stock <= $lowStockThreshold;

            if (!$matchesSearch) {
                continue;
            }
            if ($onlyLowStock && !$isLow) {
                continue;
            }

            $totalStockUnits += $stock;
            $inventoryValue += ($stock * $cost);
            if ($isLow) {
                $lowStockCount++;
            }

            $item['is_low_stock'] = $isLow;
            $item['estimated_value'] = $stock * $cost;
            $inventoryRows[] = $item;
        }

        include VIEWS_PATH . 'admin/inventory.php';
    }

    public static function updateInventoryStock($product_id) {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect(BASE_URL . 'admin/inventory');
        }

        $store_id = Auth::getStoreId();
        self::requireModuleAccess($store_id, 'inventory');

        $stock = intval($_POST['stock'] ?? 0);
        if ($stock < 0) {
            Helper::redirect(BASE_URL . 'admin/inventory?error=' . urlencode('El stock no puede ser negativo'));
        }

        $product = new Product();
        $productData = $product->findById($product_id);
        if (!$productData || intval($productData['store_id']) !== intval($store_id)) {
            Helper::redirect(BASE_URL . 'admin/inventory?error=' . urlencode('Producto no encontrado'));
        }

        if ($product->updateStock($product_id, $store_id, $stock)) {
            Helper::redirect(BASE_URL . 'admin/inventory?success=' . urlencode('Stock actualizado exitosamente'));
        }

        Helper::redirect(BASE_URL . 'admin/inventory?error=' . urlencode('No se pudo actualizar el stock'));
    }

    public static function finance() {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();

        $store_id = Auth::getStoreId();
        self::requireModuleAccess($store_id, 'finance');

        $store = new Store();
        $storeData = $store->findById($store_id);

        $order = new Order();
        $orders = $order->getByStore($store_id, 1000, 0);

        $totalRevenue = 0.0;
        $pendingRevenue = 0.0;
        $cancelledRevenue = 0.0;
        $totalOrders = count($orders);
        $statusCounts = [];
        $monthlyRevenue = 0.0;
        $today = date('Y-m-d');
        $monthKey = date('Y-m');

        foreach ($orders as $item) {
            $status = strval($item['status'] ?? 'pending');
            $total = floatval($item['total'] ?? 0);
            $createdAt = strval($item['created_at'] ?? '');

            if (!isset($statusCounts[$status])) {
                $statusCounts[$status] = 0;
            }
            $statusCounts[$status]++;

            if ($status === 'cancelled') {
                $cancelledRevenue += $total;
            } else {
                $totalRevenue += $total;
                if ($status === 'pending') {
                    $pendingRevenue += $total;
                }
            }

            if (strpos($createdAt, $monthKey) === 0 && $status !== 'cancelled') {
                $monthlyRevenue += $total;
            }
        }

        $averageTicket = $totalOrders > 0 ? ($totalRevenue / max(1, ($totalOrders - ($statusCounts['cancelled'] ?? 0)))) : 0;

        $dailyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = date('Y-m-d', strtotime('-' . $i . ' days'));
            $dailyRevenue[$day] = 0.0;
        }

        foreach ($orders as $item) {
            $createdAt = strval($item['created_at'] ?? '');
            $status = strval($item['status'] ?? 'pending');
            $day = substr($createdAt, 0, 10);
            if (isset($dailyRevenue[$day]) && $status !== 'cancelled') {
                $dailyRevenue[$day] += floatval($item['total'] ?? 0);
            }
        }

        $todayRevenue = floatval($dailyRevenue[$today] ?? 0.0);
        $recentFinanceOrders = array_slice($orders, 0, 10);

        include VIEWS_PATH . 'admin/finance.php';
    }

    public static function products() {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();
        $store_id = Auth::getStoreId();

        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $product = new Product();
        $products = $product->getByStore($store_id, $limit, $offset);
        $totalProducts = $product->countByStore($store_id);
        $totalPages = ceil($totalProducts / $limit);

        include VIEWS_PATH . 'admin/products.php';
    }

    public static function categories() {
        Auth::requireStoreOwner();
        $store_id = Auth::getStoreId();

        $category = new Category();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = Helper::sanitizeInput($_POST['name'] ?? '');
            $description = $_POST['description'] ?? '';
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            $edit_id = intval($_POST['edit_id'] ?? 0);

            if ($name === '') {
                Helper::redirect(BASE_URL . 'admin/categories?error=' . urlencode('El nombre de la categoría es obligatorio'));
            }

            $category->store_id = $store_id;
            $category->name = $name;
            $category->slug = Helper::generateSlug($name) . '-' . uniqid();
            $category->description = $description;
            $category->is_active = $is_active;

            if ($edit_id > 0) {
                $existing = $category->findById($edit_id);
                if (!$existing || intval($existing['store_id']) !== intval($store_id)) {
                    Helper::redirect(BASE_URL . 'admin/categories?error=' . urlencode('Categoría no encontrada'));
                }

                $category->id = $edit_id;
                $category->slug = Helper::generateSlug($name) . '-' . $edit_id;
                if ($category->update()) {
                    Helper::redirect(BASE_URL . 'admin/categories?success=' . urlencode('Categoría actualizada exitosamente'));
                }
                Helper::redirect(BASE_URL . 'admin/categories?error=' . urlencode('No se pudo actualizar la categoría'));
            }

            if ($category->create()) {
                Helper::redirect(BASE_URL . 'admin/categories?success=' . urlencode('Categoría creada exitosamente'));
            }

            Helper::redirect(BASE_URL . 'admin/categories?error=' . urlencode('No se pudo crear la categoría'));
        }

        if (isset($_GET['delete'])) {
            $deleteId = intval($_GET['delete']);
            if ($deleteId > 0 && $category->deleteById($deleteId, $store_id)) {
                Helper::redirect(BASE_URL . 'admin/categories?success=' . urlencode('Categoría eliminada exitosamente'));
            }
            Helper::redirect(BASE_URL . 'admin/categories?error=' . urlencode('No se pudo eliminar la categoría'));
        }

        $categories = $category->getByStore($store_id, false);
        include VIEWS_PATH . 'admin/categories.php';
    }

    public static function createProduct() {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();
        $store_id = Auth::getStoreId();

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $categoryModel = new Category();
            $categories = $categoryModel->getByStore($store_id, true);
            include VIEWS_PATH . 'admin/create-product.php';
            return;
        }

        $name = Helper::sanitizeInput($_POST['name'] ?? '');
        $description = $_POST['description'] ?? '';
        $price = floatval($_POST['price'] ?? 0);
        $cost = floatval($_POST['cost'] ?? 0);
        $discount_price = floatval($_POST['discount_price'] ?? 0);
        $stock = intval($_POST['stock'] ?? 0);
        $sku = Helper::sanitizeInput($_POST['sku'] ?? '');
        $category_id = intval($_POST['category_id'] ?? 0);

        if ($category_id > 0) {
            $categoryModel = new Category();
            $categoryData = $categoryModel->findById($category_id);
            if (!$categoryData || intval($categoryData['store_id']) !== intval($store_id) || empty($categoryData['is_active'])) {
                Helper::redirect(BASE_URL . 'admin/products/new?error=' . urlencode('La categoría seleccionada no es válida'));
            }
        }

        $errors = [];
        
        if (empty($name)) $errors['name'] = 'Nombre del producto requerido';
        if ($price <= 0) $errors['price'] = 'Precio debe ser mayor a 0';
        if ($stock < 0) $errors['stock'] = 'Stock no puede ser negativo';

        if (count($errors) > 0) {
            Helper::redirect(BASE_URL . 'admin/products/new?error=' . urlencode(implode(' | ', array_values($errors))));
        }

        if ($discount_price <= 0 || $discount_price >= $price) {
            $discount_price = null;
        }

        $store = new Store();
        $storeData = $store->findById($store_id);
        $maxProducts = null;

        $license = new License();
        $activeLicense = $license->findActiveByStoreId($store_id);
        if ($activeLicense && !empty($activeLicense['features'])) {
            $licenseFeatures = json_decode($activeLicense['features'], true);
            if (is_array($licenseFeatures) && array_key_exists('products', $licenseFeatures)) {
                $maxProducts = intval($licenseFeatures['products']);
            }
        }

        if ($maxProducts === null && $storeData) {
            $storePlan = Helper::getLicensePlan(intval($storeData['plan_id']));
            $maxProducts = intval($storePlan['products'] ?? 50);
        }

        if ($maxProducts !== -1) {
            $productCounter = new Product();
            $currentProducts = intval($productCounter->countByStore($store_id));
            if ($currentProducts >= $maxProducts) {
                Helper::redirect(BASE_URL . 'admin/products/new?error=' . urlencode('Has alcanzado el límite de productos de tu plan actual'));
            }
        }

        $product = new Product();
        $product->store_id = $store_id;
        $product->name = $name;
        $product->slug = Helper::generateSlug($name) . '-' . uniqid();
        $product->description = $description;
        $product->price = $price;
        $product->cost = $cost;
        $product->discount_price = $discount_price;
        $product->stock = $stock;
        $product->sku = $sku;
        $product->category_id = $category_id > 0 ? $category_id : null;
        $product->is_active = TRUE;

        // Manejo de imagen
        if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
            $uploadBytes = intval($_FILES['image']['size'] ?? 0);
            if (!self::canStoreUpload($store_id, $uploadBytes, $storeData)) {
                Helper::redirect(BASE_URL . 'admin/products/new?error=' . urlencode('Has alcanzado el límite de almacenamiento de tu licencia. Libera espacio o aumenta tu plan.'));
            }

            $uploadResult = Helper::uploadFile($_FILES['image'], __DIR__ . '/../../public/uploads/products');
            if ($uploadResult['success']) {
                $product->image = $uploadResult['file'];
            } else {
                Helper::redirect(BASE_URL . 'admin/products/new?error=' . urlencode($uploadResult['message'] ?? 'No se pudo subir la imagen del producto'));
            }
        }

        if ($product->create()) {
            Helper::redirect(BASE_URL . 'admin/products?success=1');
        }

        Helper::redirect(BASE_URL . 'admin/products/new?error=' . urlencode('Error al crear el producto'));
    }

    public static function editProduct($product_id) {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();
        $store_id = Auth::getStoreId();

        $product = new Product();
        $productData = $product->findById($product_id);

        if (!$productData || $productData['store_id'] != $store_id) {
            Helper::redirect(BASE_URL . 'admin/products');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productData['name'] = Helper::sanitizeInput($_POST['name'] ?? $productData['name']);
            $productData['description'] = $_POST['description'] ?? $productData['description'];
            $productData['price'] = floatval($_POST['price'] ?? $productData['price']);
            $productData['cost'] = floatval($_POST['cost'] ?? $productData['cost']);
            $productData['discount_price'] = floatval($_POST['discount_price'] ?? $productData['discount_price']);
            $productData['stock'] = intval($_POST['stock'] ?? $productData['stock']);

            $product->id = $product_id;
            $product->name = $productData['name'];
            $product->description = $productData['description'];
            $product->price = $productData['price'];
            $product->cost = $productData['cost'];
            $product->discount_price = $productData['discount_price'];

            if ($product->discount_price <= 0 || $product->discount_price >= $product->price) {
                $product->discount_price = null;
            }
            $product->stock = $productData['stock'];
            $newCategoryId = intval($_POST['category_id'] ?? 0);

            if ($newCategoryId > 0) {
                $categoryModel = new Category();
                $categoryData = $categoryModel->findById($newCategoryId);
                if (!$categoryData || intval($categoryData['store_id']) !== intval($store_id) || empty($categoryData['is_active'])) {
                    Helper::redirect(BASE_URL . 'admin/products/edit/' . $product_id . '?error=' . urlencode('La categoría seleccionada no es válida'));
                }
            }

            $product->category_id = $newCategoryId > 0 ? $newCategoryId : null;
            $product->is_active = isset($_POST['is_active']) ? 1 : 0;
            $product->image = $productData['image'] ?? null;

            if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
                $uploadBytes = intval($_FILES['image']['size'] ?? 0);
                $store = new Store();
                $storeData = $store->findById($store_id);
                if (!self::canStoreUpload($store_id, $uploadBytes, $storeData)) {
                    Helper::redirect(BASE_URL . 'admin/products/edit/' . $product_id . '?error=' . urlencode('Has alcanzado el límite de almacenamiento de tu licencia. Libera espacio o aumenta tu plan.'));
                }

                $uploadResult = Helper::uploadFile($_FILES['image'], __DIR__ . '/../../public/uploads/products');
                if (!$uploadResult['success']) {
                    Helper::redirect(BASE_URL . 'admin/products/edit/' . $product_id . '?error=' . urlencode('No se pudo subir la imagen del producto'));
                }

                $product->image = $uploadResult['file'];
            }

            if ($product->update()) {
                Helper::redirect(BASE_URL . 'admin/products?success=1');
            }

            Helper::redirect(BASE_URL . 'admin/products/edit/' . $product_id . '?error=' . urlencode('No se pudo actualizar el producto'));
        }

        $categoryModel = new Category();
        $categories = $categoryModel->getByStore($store_id, true);

        include VIEWS_PATH . 'admin/edit-product.php';
    }

    public static function deleteProduct($product_id) {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();
        $store_id = Auth::getStoreId();

        $product = new Product();
        $productData = $product->findById($product_id);

        if (!$productData || intval($productData['store_id']) !== intval($store_id)) {
            Helper::redirect(BASE_URL . 'admin/products?error=' . urlencode('Producto no encontrado'));
        }

        $product->id = $product_id;
        if ($product->delete()) {
            Helper::redirect(BASE_URL . 'admin/products?success=1');
        }

        Helper::redirect(BASE_URL . 'admin/products?error=' . urlencode('No se pudo eliminar el producto'));
    }

    public static function storeSettings() {
        Auth::requireStoreOwner();
        $store_id = Auth::getStoreId();

        $store = new Store();
        $storeData = $store->findById($store_id);
        $licenseModel = new License();
        $activeLicense = $licenseModel->findActiveByStoreId($store_id);
        $currentPlanId = intval($activeLicense['plan_id'] ?? ($storeData['plan_id'] ?? 1));
        $planNames = [1 => 'Starter', 2 => 'Professional', 3 => 'Enterprise'];
        $currentPlanName = $planNames[$currentPlanId] ?? ('Plan ' . $currentPlanId);

        $planRequestModel = new PlanChangeRequest();
        $pendingPlanRequest = $planRequestModel->getLatestPendingByStore($store_id);
        $planChangeHistory = $planRequestModel->getByStore($store_id, 10, 0);
        $setting = new Setting();

        $storeTheme = $setting->getStoreTheme($store_id);
        $menuSettings = $storeTheme['menu'] ?? [];
        $footerSettings = $storeTheme['footer'] ?? [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $store->id = $store_id;
            $store->name = Helper::sanitizeInput($_POST['name'] ?? '');
            $store->description = $_POST['description'] ?? '';
            $store->phone = Helper::sanitizeInput($_POST['phone'] ?? '');
            $store->whatsapp_number = Helper::sanitizeInput($_POST['whatsapp_number'] ?? '');
            $store->email = Helper::sanitizeInput($_POST['email'] ?? '');
            $store->address = Helper::sanitizeInput($_POST['address'] ?? '');
            $store->city = Helper::sanitizeInput($_POST['city'] ?? '');
            $store->state = Helper::sanitizeInput($_POST['state'] ?? '');
            $store->country = Helper::sanitizeInput($_POST['country'] ?? '');
            $store->postal_code = Helper::sanitizeInput($_POST['postal_code'] ?? '');
            $store->currency = Helper::sanitizeInput($_POST['currency'] ?? 'USD');

            $menuLinks = [];
            for ($i = 1; $i <= 4; $i++) {
                $label = Helper::sanitizeInput($_POST['menu_link_' . $i . '_label'] ?? '');
                $url = Helper::sanitizeUrl($_POST['menu_link_' . $i . '_url'] ?? '', true);
                if ($label !== '' && $url !== '') {
                    $menuLinks[] = ['label' => $label, 'url' => $url];
                }
            }

            $footerPayload = [
                'text' => Helper::sanitizeInput($_POST['footer_text'] ?? ''),
                'contact_email' => Helper::sanitizeInput($_POST['footer_contact_email'] ?? ''),
                'contact_phone' => Helper::sanitizeInput($_POST['footer_contact_phone'] ?? ''),
                'terms_url' => Helper::sanitizeUrl($_POST['footer_terms_url'] ?? '', true),
                'privacy_url' => Helper::sanitizeUrl($_POST['footer_privacy_url'] ?? '', true),
                'facebook' => Helper::sanitizeUrl($_POST['footer_facebook'] ?? '', false),
                'instagram' => Helper::sanitizeUrl($_POST['footer_instagram'] ?? '', false),
                'tiktok' => Helper::sanitizeUrl($_POST['footer_tiktok'] ?? '', false)
            ];

            if ($store->update()) {
                $setting->setValue('store_' . $store_id . '_menu_json', json_encode($menuLinks), 'json');
                $setting->setValue('store_' . $store_id . '_footer_json', json_encode($footerPayload), 'json');
                Helper::redirect(BASE_URL . 'admin/settings?success=1');
            }

            Helper::redirect(BASE_URL . 'admin/settings?error=' . urlencode('No se pudo guardar la configuración'));
        }

        include VIEWS_PATH . 'admin/settings.php';
    }

    public static function requestPlanChange() {
        Auth::requireStoreOwner();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect(BASE_URL . 'admin/settings');
        }

        $store_id = Auth::getStoreId();
        $requestedPlanId = intval($_POST['requested_plan_id'] ?? 0);
        $reason = Helper::sanitizeInput($_POST['reason'] ?? '');

        if (!in_array($requestedPlanId, [1, 2, 3], true)) {
            Helper::redirect(BASE_URL . 'admin/settings?error=' . urlencode('Selecciona un plan válido para solicitar el cambio'));
        }

        $store = new Store();
        $storeData = $store->findById($store_id);
        if (!$storeData) {
            Helper::redirect(BASE_URL . 'admin/settings?error=' . urlencode('No se encontró la tienda'));
        }

        $licenseModel = new License();
        $activeLicense = $licenseModel->findActiveByStoreId($store_id);
        $currentPlanId = intval($activeLicense['plan_id'] ?? ($storeData['plan_id'] ?? 1));

        if ($requestedPlanId === $currentPlanId) {
            Helper::redirect(BASE_URL . 'admin/settings?error=' . urlencode('Tu tienda ya está en ese plan'));
        }

        $planRequestModel = new PlanChangeRequest();
        $pendingRequest = $planRequestModel->getLatestPendingByStore($store_id);
        if ($pendingRequest) {
            Helper::redirect(BASE_URL . 'admin/settings?error=' . urlencode('Ya tienes una solicitud pendiente de revisión'));
        }

        $payload = [
            'store_id' => $store_id,
            'requested_by_user_id' => intval($_SESSION['user_id'] ?? 0),
            'current_plan_id' => $currentPlanId,
            'requested_plan_id' => $requestedPlanId,
            'reason' => $reason
        ];

        if ($planRequestModel->createRequest($payload)) {
            Helper::redirect(BASE_URL . 'admin/settings?success=' . urlencode('Solicitud de cambio de plan enviada. Será revisada por superadmin.'));
        }

        Helper::redirect(BASE_URL . 'admin/settings?error=' . urlencode('No se pudo enviar la solicitud de cambio de plan'));
    }

    public static function orders() {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();
        $store_id = Auth::getStoreId();

        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $order = new Order();
        $orders = $order->getByStore($store_id, $limit, $offset);
        $totalOrders = $order->countByStore($store_id);
        $totalPages = ceil($totalOrders / $limit);

        include VIEWS_PATH . 'admin/orders.php';
    }

    public static function reviews() {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();
        $store_id = Auth::getStoreId();

        $store = new Store();
        $storeData = $store->findById($store_id);

        $page = intval($_GET['page'] ?? 1);
        if ($page < 1) {
            $page = 1;
        }
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $reviewModel = new Review();
        $reviews = $reviewModel->getByStore($store_id, $limit, $offset);
        $totalReviews = $reviewModel->countByStore($store_id);
        $reviewStats = $reviewModel->getStatsByStore($store_id);
        $topCommentedProducts = $reviewModel->getTopCommentedProducts($store_id, 5);
        $totalPages = max(1, intval(ceil($totalReviews / $limit)));

        include VIEWS_PATH . 'admin/reviews.php';
    }

    public static function replyReview($review_id) {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect(BASE_URL . 'admin/reviews');
        }

        $store_id = Auth::getStoreId();
        $replyComment = trim($_POST['reply_comment'] ?? '');

        if ($replyComment === '') {
            Helper::redirect(BASE_URL . 'admin/reviews?error=' . urlencode('La respuesta no puede estar vacía'));
        }

        if (strlen($replyComment) > 1200) {
            Helper::redirect(BASE_URL . 'admin/reviews?error=' . urlencode('La respuesta no puede exceder 1200 caracteres'));
        }

        $reviewModel = new Review();
        $reviewData = $reviewModel->findById(intval($review_id));
        if (!$reviewData || intval($reviewData['store_id']) !== intval($store_id)) {
            Helper::redirect(BASE_URL . 'admin/reviews?error=' . urlencode('Comentario no encontrado'));
        }

        if ($reviewModel->updateReply(intval($review_id), intval($store_id), $replyComment, true)) {
            Helper::redirect(BASE_URL . 'admin/reviews?success=' . urlencode('Respuesta guardada correctamente'));
        }

        Helper::redirect(BASE_URL . 'admin/reviews?error=' . urlencode('No se pudo guardar la respuesta'));
    }

    public static function customers() {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();
        $store_id = Auth::getStoreId();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = Helper::sanitizeInput($_POST['name'] ?? '');
            $email = Helper::sanitizeInput($_POST['email'] ?? '');
            $phone = Helper::sanitizeInput($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $autoPassword = isset($_POST['auto_password']) && $_POST['auto_password'] == '1';
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            if ($autoPassword || trim($password) === '') {
                $password = self::generateTemporaryPassword();
            }

            $errors = [];
            if ($name === '') {
                $errors[] = 'El nombre es obligatorio';
            }
            if (!Helper::validateEmail($email)) {
                $errors[] = 'El email no es válido';
            }
            if (!$autoPassword && strlen($password) < 6) {
                $errors[] = 'La contraseña debe tener al menos 6 caracteres';
            }

            $user = new User();
            $existing = $user->findByEmail($email);
            if ($existing) {
                $errors[] = 'Ya existe una cuenta con ese email';
            }

            if (!empty($errors)) {
                Helper::redirect(BASE_URL . 'admin/customers?error=' . urlencode(implode(' | ', $errors)));
            }

            $newCustomer = new User();
            $newCustomer->name = $name;
            $newCustomer->email = $email;
            $newCustomer->password = $password;
            $newCustomer->phone = $phone;
            $newCustomer->role = ROLE_CUSTOMER;
            $newCustomer->store_id = intval($store_id);
            $newCustomer->is_active = $isActive;
            $newCustomer->email_verified = 1;

            if ($newCustomer->create()) {
                Helper::redirect(
                    BASE_URL . 'admin/customers?success=' . urlencode('Cliente creado correctamente') .
                    '&generated_password=' . urlencode($password)
                );
            }

            Helper::redirect(BASE_URL . 'admin/customers?error=' . urlencode('No se pudo crear el cliente'));
        }

        $page = intval($_GET['page'] ?? 1);
        if ($page < 1) {
            $page = 1;
        }
        $limit = 15;
        $offset = ($page - 1) * $limit;
        $search = trim((string)($_GET['q'] ?? ''));

        $user = new User();
        $customers = $user->getCustomersByStore($store_id, $limit, $offset, $search);
        $totalCustomers = $user->countCustomersByStore($store_id, $search);
        $totalPages = max(1, intval(ceil($totalCustomers / $limit)));

        $allCustomers = $user->getCustomersByStore($store_id, 2000, 0, '');
        $activeCustomers = 0;
        $customersWithOrders = 0;
        foreach ($allCustomers as $row) {
            if (!empty($row['is_active'])) {
                $activeCustomers++;
            }
            if (intval($row['orders_count'] ?? 0) > 0) {
                $customersWithOrders++;
            }
        }

        include VIEWS_PATH . 'admin/customers.php';
    }

    public static function customerDetail($customer_id) {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();
        $store_id = Auth::getStoreId();

        $user = new User();
        $customerData = $user->findCustomerByIdAndStore(intval($customer_id), intval($store_id));
        if (!$customerData) {
            Helper::redirect(BASE_URL . 'admin/customers?error=' . urlencode('Cliente no encontrado'));
        }

        $order = new Order();
        $orders = $order->getByCustomer($store_id, intval($customer_id), 100, 0);
        $totalOrders = $order->countByCustomer($store_id, intval($customer_id));

        $totalSpent = 0.0;
        $pendingOrders = 0;
        $lastOrderAt = null;
        foreach ($orders as $item) {
            if (($item['status'] ?? '') !== 'cancelled') {
                $totalSpent += floatval($item['total'] ?? 0);
            }
            if (($item['status'] ?? '') === 'pending') {
                $pendingOrders++;
            }
            if ($lastOrderAt === null && !empty($item['created_at'])) {
                $lastOrderAt = $item['created_at'];
            }
        }

        $addressModel = new CustomerAddress();
        $addresses = $addressModel->getByCustomer(intval($customer_id), intval($store_id));

        include VIEWS_PATH . 'admin/customer-detail.php';
    }

    public static function documentation() {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();

        $store_id = Auth::getStoreId();
        $store = new Store();
        $storeData = $store->findById($store_id);

        include VIEWS_PATH . 'admin/documentation.php';
    }

    public static function viewOrder($order_id) {
        Auth::requireStoreOwner();
        Auth::requireValidStoreLicense();
        $store_id = Auth::getStoreId();

        $order = new Order();
        $orderData = $order->findById($order_id);

        if (!$orderData || $orderData['store_id'] != $store_id) {
            Helper::redirect(BASE_URL . 'admin/orders');
        }

        $orderItems = $order->getOrderItems($order_id);

        include VIEWS_PATH . 'admin/view-order.php';
    }

    private static function generateTemporaryPassword($length = 10) {
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
        $maxIndex = strlen($alphabet) - 1;
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $alphabet[random_int(0, $maxIndex)];
        }

        return $password;
    }

    private static function getStoreDiskUsageBytes($storeId) {
        $product = new Product();
        $products = $product->getByStore($storeId, 10000, 0);

        if (empty($products)) {
            return 0;
        }

        $totalBytes = 0;
        $seen = [];

        foreach ($products as $item) {
            $imagePath = strval($item['image'] ?? '');
            if ($imagePath === '') {
                continue;
            }

            $absolutePath = self::resolveAbsoluteStoragePath($imagePath);
            if (!$absolutePath || isset($seen[$absolutePath]) || !is_file($absolutePath)) {
                continue;
            }

            $seen[$absolutePath] = true;
            $fileSize = @filesize($absolutePath);
            if ($fileSize !== false) {
                $totalBytes += intval($fileSize);
            }
        }

        return $totalBytes;
    }

    private static function getStoreStorageLimitGb($storeId, $storeData = null) {
        $activeLicense = (new License())->findActiveByStoreId($storeId);
        $storageLimitGb = 0.0;

        if ($activeLicense && !empty($activeLicense['features'])) {
            $licenseFeatures = json_decode($activeLicense['features'], true);
            if (is_array($licenseFeatures) && array_key_exists('storage', $licenseFeatures)) {
                $storageLimitGb = floatval($licenseFeatures['storage']);
            }
        }

        if ($storageLimitGb <= 0) {
            if (!$storeData) {
                $storeData = (new Store())->findById($storeId);
            }
            if ($storeData) {
                $storePlan = Helper::getLicensePlan(intval($storeData['plan_id']));
                $storageLimitGb = floatval($storePlan['storage'] ?? 5);
            }
        }

        return max(0.1, $storageLimitGb);
    }

    private static function canStoreUpload($storeId, $incomingBytes, $storeData = null) {
        $limitGb = self::getStoreStorageLimitGb($storeId, $storeData);
        $limitBytes = $limitGb * pow(1024, 3);
        $currentBytes = self::getStoreDiskUsageBytes($storeId);

        return ($currentBytes + max(0, intval($incomingBytes))) <= $limitBytes;
    }

    private static function requireModuleAccess($storeId, $moduleKey) {
        $modules = self::getEnabledModulesForStore($storeId);
        if (empty($modules[$moduleKey])) {
            Helper::redirect(BASE_URL . 'admin/dashboard?error=' . urlencode('Tu licencia no incluye el módulo solicitado'));
        }
    }

    private static function getEnabledModulesForStore($storeId, $storeData = null) {
        $modules = ['inventory' => true, 'finance' => false];

        if (!$storeData) {
            $storeData = (new Store())->findById($storeId);
        }

        $activeLicense = (new License())->findActiveByStoreId($storeId);
        $planFeatures = Helper::getLicensePlan(intval($storeData['plan_id'] ?? 1));
        $features = $planFeatures;

        if ($activeLicense && !empty($activeLicense['features'])) {
            $decoded = json_decode($activeLicense['features'], true);
            if (is_array($decoded)) {
                $features = array_merge($planFeatures, $decoded);
            }
        }

        if (array_key_exists('module_inventory', $features)) {
            $modules['inventory'] = !empty($features['module_inventory']);
        }
        if (array_key_exists('module_finance', $features)) {
            $modules['finance'] = !empty($features['module_finance']);
        }

        $featureList = $features['features'] ?? [];
        if (is_array($featureList)) {
            if (in_array('inventory_module', $featureList, true)) {
                $modules['inventory'] = true;
            }
            if (in_array('finance_module', $featureList, true)) {
                $modules['finance'] = true;
            }
        }

        return $modules;
    }

    private static function resolveAbsoluteStoragePath($path) {
        $raw = trim((string)$path);
        if ($raw === '') {
            return null;
        }

        if (is_file($raw)) {
            return $raw;
        }

        $normalized = str_replace('\\', '/', $raw);
        $candidates = [];

        if (strpos($normalized, BASE_URL) === 0) {
            $relative = ltrim(substr($normalized, strlen(BASE_URL)), '/');
            $candidates[] = APP_PATH . '/' . $relative;
        }

        if (strpos($normalized, '/public/') !== false) {
            $pos = strpos($normalized, '/public/');
            $candidates[] = APP_PATH . substr($normalized, $pos);
        }

        $trimmed = ltrim($normalized, '/');
        $candidates[] = APP_PATH . '/' . $trimmed;

        if (strpos($trimmed, 'uploads/') === 0) {
            $candidates[] = APP_PATH . '/public/' . $trimmed;
        }

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return $candidate;
            }
        }

        return null;
    }
}
