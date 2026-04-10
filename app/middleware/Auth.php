<?php

class Auth {
    public static function login($email, $password) {
        require_once __DIR__ . '/../models/User.php';
        $user = new User();
        $userData = $user->findByEmail($email);

        if ($userData && $user->verifyPassword($password, $userData['password'])) {
            // Check if the user account is active
            if (empty($userData['is_active'])) {
                return 'user_inactive';
            }

            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['user_email'] = $userData['email'];
            $_SESSION['user_role'] = $userData['role'];
            $_SESSION['user_name'] = $userData['name'];
            $_SESSION['store_id'] = $userData['store_id'];

            if ($userData['role'] === 'store_owner' && empty($userData['store_id'])) {
                require_once __DIR__ . '/../models/Store.php';
                $store = new Store();
                $stores = $store->findByOwnerId($userData['id']);

                if (!empty($stores)) {
                    $_SESSION['store_id'] = $stores[0]['id'];
                    $user->assignStore($userData['id'], $stores[0]['id']);
                }
            }

            // For store owners, check if their store is active
            if ($userData['role'] === 'store_owner') {
                $resolvedStoreId = $_SESSION['store_id'];
                if ($resolvedStoreId) {
                    require_once __DIR__ . '/../models/Store.php';
                    $store = new Store();
                    $storeData = $store->findById($resolvedStoreId);
                    if ($storeData && empty($storeData['is_active'])) {
                        session_destroy();
                        return 'store_inactive';
                    }
                }
            }

            return true;
        }

        return false;
    }

    public static function logout() {
        session_destroy();
        return true;
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function isSuperAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'superadmin';
    }

    public static function isStoreOwner() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'store_owner';
    }

    public static function isStoreOwnerOfStore($store_id) {
        if (!self::isLoggedIn()) {
            return false;
        }

        require_once __DIR__ . '/../models/Store.php';
        $store = new Store();
        $storeData = $store->findById($store_id);
        return $storeData && intval($storeData['owner_id']) === intval($_SESSION['user_id']);
    }

    public static function getCurrentUser() {
        if (self::isLoggedIn()) {
            require_once __DIR__ . '/../models/User.php';
            $user = new User();
            return $user->findById($_SESSION['user_id']);
        }
        return null;
    }

    public static function getStoreId() {
        return $_SESSION['store_id'] ?? null;
    }

    public static function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    public static function getRole() {
        return $_SESSION['user_role'] ?? null;
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
    }

    public static function requireSuperAdmin() {
        self::requireLogin();
        if (!self::isSuperAdmin()) {
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }
    }

    public static function requireStoreOwner() {
        self::requireLogin();
        if (!self::isStoreOwner()) {
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }
    }

    public static function requireValidStoreLicense() {
        self::requireStoreOwner();

        $storeId = self::getStoreId();
        if (!$storeId) {
            header('Location: ' . BASE_URL . 'auth/login?error=' . urlencode('No se encontró una tienda vinculada a tu cuenta'));
            exit;
        }

        require_once __DIR__ . '/../models/License.php';
        $license = new License();
        $activeLicense = $license->findActiveByStoreId($storeId);

        if (!$activeLicense) {
            header('Location: ' . BASE_URL . 'auth/login?error=' . urlencode('Tu licencia no está activa o ha expirado'));
            exit;
        }
    }
}
