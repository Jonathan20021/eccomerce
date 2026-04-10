<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/License.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Store.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../helpers/Helper.php';
require_once __DIR__ . '/../middleware/Auth.php';

class ApiController {

    private static function requireSuperAdminApi() {
        if (!Auth::isLoggedIn()) {
            Helper::json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        if (!Auth::isSuperAdmin()) {
            Helper::json(['success' => false, 'message' => 'No autorizado'], 403);
        }
    }

    public static function licenses() {
        self::requireSuperAdminApi();

        $limit = intval($_GET['limit'] ?? 50);
        $offset = intval($_GET['offset'] ?? 0);
        $limit = max(1, min($limit, 100));
        $offset = max(0, $offset);

        $license = new License();
        $data = $license->getAllLicenses($limit, $offset);

        Helper::json(['success' => true, 'data' => $data]);
    }

    public static function createLicense() {
        self::requireSuperAdminApi();

        $planInput = $_POST['plan'] ?? null;
        $planId = intval($_POST['plan_id'] ?? 0);

        if ($planId <= 0 && !empty($planInput)) {
            $planMap = ['starter' => 1, 'professional' => 2, 'enterprise' => 3];
            $planId = $planMap[strtolower(trim($planInput))] ?? 0;
        }

        if (!in_array($planId, [1, 2, 3], true)) {
            Helper::json(['success' => false, 'message' => 'Plan inválido'], 400);
        }

        $isTrial = isset($_POST['is_trial']) ? intval($_POST['is_trial']) : 1;
        $trialDays = intval($_POST['trial_days'] ?? 15);
        if ($trialDays < 0) {
            $trialDays = 0;
        }

        $license = new License();
        $license->plan_id = $planId;
        $license->trial_days = $trialDays;
        $license->is_trial = $isTrial ? 1 : 0;
        $license->features = Helper::getLicensePlan($planId);

        if ($license->create()) {
            Helper::json([
                'success' => true,
                'code' => $license->code,
                'message' => 'Licencia creada exitosamente'
            ]);
        }

        Helper::json(['success' => false, 'message' => 'Error al crear licencia'], 500);
    }

    public static function search() {
        $page = intval($_GET['page'] ?? 1);
        $limit = intval($_GET['limit'] ?? 20);
        $limit = max(1, min($limit, 100));
        $page = max(1, $page);
        $offset = ($page - 1) * $limit;

        $filters = [
            'q' => trim($_GET['q'] ?? ''),
            'min_price' => $_GET['min_price'] ?? null,
            'max_price' => $_GET['max_price'] ?? null,
            'sort' => trim($_GET['sort'] ?? '')
        ];

        $product = new Product();
        $results = $product->searchAcrossStores($filters, $limit, $offset);
        $total = $product->countSearchAcrossStores($filters);

        Helper::json([
            'success' => true,
            'results' => $results,
            'total' => $total,
            'page' => $page,
            'limit' => $limit
        ]);
    }

    public static function statistics() {
        self::requireSuperAdminApi();

        $db = (new Database())->connect();

        $totalUsers = intval($db->query("SELECT COUNT(*) FROM users")->fetchColumn());
        $totalStores = intval($db->query("SELECT COUNT(*) FROM stores")->fetchColumn());
        $totalProducts = intval($db->query("SELECT COUNT(*) FROM products")->fetchColumn());
        $totalOrders = intval($db->query("SELECT COUNT(*) FROM orders")->fetchColumn());

        $totalRevenueRaw = $db->query("SELECT COALESCE(SUM(total), 0) FROM orders WHERE status != 'cancelled'")->fetchColumn();
        $totalRevenue = floatval($totalRevenueRaw ?? 0);

        $activeLicenses = intval($db->query("SELECT COUNT(*) FROM licenses WHERE status = 'active' AND (trial_ends_at IS NULL OR trial_ends_at > NOW()) AND (expires_at IS NULL OR expires_at > NOW())")->fetchColumn());
        $trialLicenses = intval($db->query("SELECT COUNT(*) FROM licenses WHERE is_trial = 1")->fetchColumn());
        $expiredLicenses = intval($db->query("SELECT COUNT(*) FROM licenses WHERE (trial_ends_at IS NOT NULL AND trial_ends_at <= NOW()) OR (expires_at IS NOT NULL AND expires_at <= NOW()) OR status = 'expired'")->fetchColumn());

        Helper::json([
            'success' => true,
            'data' => [
                'total_users' => $totalUsers,
                'total_stores' => $totalStores,
                'total_products' => $totalProducts,
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue,
                'active_licenses' => $activeLicenses,
                'trial_licenses' => $trialLicenses,
                'expired_licenses' => $expiredLicenses
            ]
        ]);
    }

    public static function storeAnalytics($storeId) {
        $storeId = intval($storeId);
        if ($storeId <= 0) {
            Helper::json(['success' => false, 'message' => 'Store inválida'], 400);
        }

        if (!Auth::isSuperAdmin() && !Auth::isStoreOwnerOfStore($storeId)) {
            Helper::json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $product = new Product();
        $order = new Order();

        $totalProducts = intval($product->countByStore($storeId));
        $totalOrders = intval($order->countByStore($storeId));
        $totalRevenue = floatval($order->getTotalRevenue($storeId));
        $averageOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders, 2) : 0;

        $db = (new Database())->connect();
        $stmt = $db->prepare("SELECT COALESCE(SUM(total), 0) as monthly_revenue FROM orders WHERE store_id = :store_id AND status != 'cancelled' AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
        $stmt->bindParam(':store_id', $storeId);
        $stmt->execute();
        $monthlyRevenue = floatval(($stmt->fetch(PDO::FETCH_ASSOC)['monthly_revenue']) ?? 0);

        Helper::json([
            'success' => true,
            'data' => [
                'total_products' => $totalProducts,
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue,
                'monthly_revenue' => $monthlyRevenue,
                'average_order_value' => $averageOrderValue,
                'conversion_rate' => 0
            ]
        ]);
    }
}
