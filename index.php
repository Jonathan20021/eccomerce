<?php

require_once __DIR__ . '/app/config/Config.php';
require_once __DIR__ . '/app/config/Database.php';
require_once __DIR__ . '/app/middleware/Auth.php';
require_once __DIR__ . '/app/helpers/Helper.php';

// Enrutamiento simple
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$script_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
$script_dir = rtrim($script_dir, '/');
$base_path = $script_dir === '' ? '/' : $script_dir . '/';

if ($base_path !== '/' && strpos($request_uri, $base_path) === 0) {
    $request = substr($request_uri, strlen($base_path));
} else {
    $request = ltrim($request_uri, '/');
}

$request = trim($request, '/');

// Rutas por defecto
$parts = explode('/', $request);

if (empty($request)) {
    // Landing Page
    require_once __DIR__ . '/app/controllers/PublicController.php';
    PublicController::home();
} 
else if ($parts[0] == 'auth') {
    require_once __DIR__ . '/app/controllers/AuthController.php';
    
    if (isset($parts[1]) && $parts[1] == 'login') {
        AuthController::login();
    } 
    else if (isset($parts[1]) && $parts[1] == 'forgot-password') {
        AuthController::forgotPassword();
    }
    else if (isset($parts[1]) && $parts[1] == 'cuenta-inactiva') {
        AuthController::inactiveAccount();
    }
    else if (isset($parts[1]) && $parts[1] == 'register') {
        AuthController::register();
    }
    else if (isset($parts[1]) && $parts[1] == 'logout') {
        AuthController::logout();
    }
    else {
        header('Location: ' . BASE_URL);
    }
}
else if ($parts[0] == 'admin') {
    Auth::requireStoreOwner();
    // Permitir configuración de tienda sin bloquear por licencia para casos de recuperación.
    if (!isset($parts[1]) || !in_array($parts[1], ['settings', 'plan-change'], true)) {
        Auth::requireValidStoreLicense();
    }
    require_once __DIR__ . '/app/controllers/AdminController.php';
    
    if (isset($parts[1]) && $parts[1] == 'dashboard') {
        AdminController::dashboard();
    }
    else if (isset($parts[1]) && $parts[1] == 'products') {
        if (isset($parts[2]) && $parts[2] == 'new') {
            AdminController::createProduct();
        }
        else if (isset($parts[2]) && $parts[2] == 'delete' && isset($parts[3])) {
            AdminController::deleteProduct(intval($parts[3]));
        }
        else if (isset($parts[2]) && $parts[2] == 'edit' && isset($parts[3])) {
            AdminController::editProduct(intval($parts[3]));
        }
        else {
            AdminController::products();
        }
    }
    else if (isset($parts[1]) && $parts[1] == 'categories') {
        AdminController::categories();
    }
    else if (isset($parts[1]) && $parts[1] == 'inventory') {
        if (isset($parts[2]) && $parts[2] == 'stock' && isset($parts[3])) {
            AdminController::updateInventoryStock(intval($parts[3]));
        } else {
            AdminController::inventory();
        }
    }
    else if (isset($parts[1]) && $parts[1] == 'finance') {
        AdminController::finance();
    }
    else if (isset($parts[1]) && $parts[1] == 'orders') {
        if (isset($parts[2])) {
            AdminController::viewOrder(intval($parts[2]));
        } else {
            AdminController::orders();
        }
    }
    else if (isset($parts[1]) && $parts[1] == 'reviews') {
        if (isset($parts[2]) && $parts[2] == 'reply' && isset($parts[3])) {
            AdminController::replyReview(intval($parts[3]));
        } else {
            AdminController::reviews();
        }
    }
    else if (isset($parts[1]) && $parts[1] == 'customers') {
        if (isset($parts[2])) {
            AdminController::customerDetail(intval($parts[2]));
        } else {
            AdminController::customers();
        }
    }
    else if (isset($parts[1]) && $parts[1] == 'documentation') {
        AdminController::documentation();
    }
    else if (isset($parts[1]) && $parts[1] == 'settings') {
        AdminController::storeSettings();
    }
    else if (isset($parts[1]) && $parts[1] == 'plan-change') {
        if (isset($parts[2]) && $parts[2] == 'request') {
            AdminController::requestPlanChange();
        } else {
            header('Location: ' . BASE_URL . 'admin/settings');
        }
    }
    else {
        header('Location: ' . BASE_URL . 'admin/dashboard');
    }
}
else if ($parts[0] == 'superadmin') {
    Auth::requireSuperAdmin();
    require_once __DIR__ . '/app/controllers/SuperAdminController.php';
    
    if (isset($parts[1]) && $parts[1] == 'dashboard') {
        SuperAdminController::dashboard();
    }
    else if (isset($parts[1]) && $parts[1] == 'licenses') {
        if (isset($parts[2]) && $parts[2] == 'create') {
            SuperAdminController::createLicense();
        } else if (isset($parts[2]) && $parts[2] == 'storage' && isset($parts[3])) {
            SuperAdminController::updateLicenseStorage(intval($parts[3]));
        } else if (isset($parts[2]) && $parts[2] == 'modules' && isset($parts[3])) {
            SuperAdminController::updateLicenseModules(intval($parts[3]));
        } else if (isset($parts[2]) && $parts[2] == 'delete' && isset($parts[3])) {
            SuperAdminController::deleteLicense(intval($parts[3]));
        } else {
            SuperAdminController::manageLicenses();
        }
    }
    else if (isset($parts[1]) && $parts[1] == 'stores') {
        if (isset($parts[2]) && $parts[2] == 'toggle' && isset($parts[3])) {
            SuperAdminController::toggleStoreStatus(intval($parts[3]));
        } else if (isset($parts[2]) && $parts[2] == 'delete' && isset($parts[3])) {
            SuperAdminController::deleteStore(intval($parts[3]));
        } else if (isset($parts[2])) {
            SuperAdminController::viewStore(intval($parts[2]));
        } else {
            SuperAdminController::manageStores();
        }
    }
    else if (isset($parts[1]) && $parts[1] == 'users') {
        if (isset($parts[2]) && $parts[2] == 'create-superadmin') {
            SuperAdminController::createSuperAdmin();
        } else if (isset($parts[2]) && $parts[2] == 'update' && isset($parts[3])) {
            SuperAdminController::updateUser(intval($parts[3]));
        } else if (isset($parts[2]) && $parts[2] == 'toggle' && isset($parts[3])) {
            SuperAdminController::toggleUserStatus(intval($parts[3]));
        } else if (isset($parts[2]) && $parts[2] == 'delete' && isset($parts[3])) {
            SuperAdminController::deleteUser(intval($parts[3]));
        } else {
            SuperAdminController::manageUsers();
        }
    }
    else if (isset($parts[1]) && $parts[1] == 'plan-requests') {
        if (isset($parts[2]) && $parts[2] == 'approve' && isset($parts[3])) {
            SuperAdminController::approvePlanRequest(intval($parts[3]));
        } else if (isset($parts[2]) && $parts[2] == 'reject' && isset($parts[3])) {
            SuperAdminController::rejectPlanRequest(intval($parts[3]));
        } else {
            SuperAdminController::managePlanRequests();
        }
    }
    else if (isset($parts[1]) && $parts[1] == 'settings') {
        SuperAdminController::settings();
    }
    else if (isset($parts[1]) && $parts[1] == 'emails') {
        if (isset($parts[2]) && $parts[2] == 'preview') {
            SuperAdminController::previewEmail();
        } else {
            SuperAdminController::manageEmails();
        }
    }
    else {
        header('Location: ' . BASE_URL . 'superadmin/dashboard');
    }
}
else if ($parts[0] == 'shop') {
    require_once __DIR__ . '/app/controllers/PublicController.php';
    require_once __DIR__ . '/app/controllers/CustomerController.php';
    
    if (isset($parts[1])) {
        $store_slug = $parts[1];
        
        if (isset($parts[2]) && $parts[2] == 'product' && isset($parts[3])) {
            PublicController::productDetail($store_slug, $parts[3]);
        }
        else if (isset($parts[2]) && $parts[2] == 'cart') {
            PublicController::cart($store_slug);
        }
        else if (isset($parts[2]) && $parts[2] == 'customer' && isset($parts[3]) && $parts[3] == 'register') {
            CustomerController::register($store_slug);
        }
        else if (isset($parts[2]) && $parts[2] == 'customer' && isset($parts[3]) && $parts[3] == 'login') {
            CustomerController::login($store_slug);
        }
        else {
            PublicController::storeFront($store_slug);
        }
    }
}
else if ($parts[0] == 'customer') {
    require_once __DIR__ . '/app/controllers/CustomerController.php';

    if (!isset($parts[1]) || $parts[1] == 'panel') {
        CustomerController::dashboard();
    }
    else if ($parts[1] == 'profile') {
        CustomerController::profile();
    }
    else if ($parts[1] == 'addresses') {
        CustomerController::addresses();
    }
    else if ($parts[1] == 'orders' && isset($parts[2])) {
        CustomerController::orderDetail(intval($parts[2]));
    }
    else if ($parts[1] == 'logout') {
        CustomerController::logout();
    }
    else {
        header('Location: ' . BASE_URL . 'customer/panel');
    }
}
else if ($parts[0] == 'checkout') {
    require_once __DIR__ . '/app/controllers/PublicController.php';
    PublicController::checkout();
}
else if (in_array($parts[0], ['terms', 'privacy', 'cookies', 'security', 'api-docs', 'about', 'blog', 'contact', 'jobs'], true)) {
    require_once __DIR__ . '/app/controllers/PublicController.php';
    PublicController::page($parts[0]);
}
else if ($parts[0] == 'api') {
    // API Routes
    header('Content-Type: application/json');
    require_once __DIR__ . '/app/controllers/ApiController.php';

    if (!Helper::enforceRateLimit('api', 120, 60)) {
        Helper::json(['success' => false, 'message' => 'Demasiadas solicitudes, intenta de nuevo en un minuto'], 429);
    }

    if (isset($parts[1]) && $parts[1] == 'licenses') {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            ApiController::licenses();
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ApiController::createLicense();
        }
    }

    if (isset($parts[1]) && $parts[1] == 'search' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        ApiController::search();
    }

    if (isset($parts[1]) && $parts[1] == 'statistics' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        ApiController::statistics();
    }

    if (isset($parts[1]) && $parts[1] == 'stores' && isset($parts[2]) && isset($parts[3]) && $parts[3] == 'analytics' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        ApiController::storeAnalytics(intval($parts[2]));
    }
    
    if (isset($parts[1]) && $parts[1] == 'cart') {
        require_once __DIR__ . '/app/controllers/PublicController.php';
        
        if (isset($parts[2]) && $parts[2] == 'count') {
            PublicController::cartCount();
        }
        else if (isset($parts[2]) && $parts[2] == 'add') {
            PublicController::addToCart();
        }
        else if (isset($parts[2]) && $parts[2] == 'update') {
            PublicController::updateCartItem();
        }
        else if (isset($parts[2]) && $parts[2] == 'remove') {
            PublicController::removeFromCart();
        }
    }
    
    Helper::json(['error' => 'API no encontrada'], 404);
}
else {
    // 404
    http_response_code(404);
    echo "Página no encontrada";
}
