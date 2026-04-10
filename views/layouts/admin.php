<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' — ' . APP_NAME : APP_NAME . ' Admin' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/style.css">
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/mobile-pro.css">
</head>
<body style="background:#f8fafc;">
<?php
$isSuperAdmin = Auth::isSuperAdmin();
$currentUri   = $_SERVER['REQUEST_URI'] ?? '';

// Fetch store data for sidebar URL if not already set
if (!$isSuperAdmin && !isset($storeData) && class_exists('Store') && !empty($_SESSION['store_id'])) {
    $__store = new Store();
    $storeData = $__store->findById($_SESSION['store_id']);
}

$enabledModules = ['inventory' => true, 'finance' => false];
if (!$isSuperAdmin && !empty($_SESSION['store_id'])) {
    require_once __DIR__ . '/../../app/models/License.php';
    require_once __DIR__ . '/../../app/helpers/Helper.php';

    $planFeatures = Helper::getLicensePlan(intval($storeData['plan_id'] ?? 1));
    $features = $planFeatures;

    $licenseModel = new License();
    $activeLicense = $licenseModel->findActiveByStoreId(intval($_SESSION['store_id']));
    if ($activeLicense && !empty($activeLicense['features'])) {
        $decoded = json_decode($activeLicense['features'], true);
        if (is_array($decoded)) {
            $features = array_merge($planFeatures, $decoded);
        }
    }

    if (array_key_exists('module_inventory', $features)) {
        $enabledModules['inventory'] = !empty($features['module_inventory']);
    }
    if (array_key_exists('module_finance', $features)) {
        $enabledModules['finance'] = !empty($features['module_finance']);
    }

    $featureList = $features['features'] ?? [];
    if (is_array($featureList)) {
        if (in_array('inventory_module', $featureList, true)) {
            $enabledModules['inventory'] = true;
        }
        if (in_array('finance_module', $featureList, true)) {
            $enabledModules['finance'] = true;
        }
    }
}
?>

<!-- ======== SIDEBAR ======== -->
<aside class="admin-sidebar" id="adminSidebar">

    <!-- Logo -->
    <div class="sidebar-logo">
        <a href="<?= $isSuperAdmin ? BASE_URL . 'superadmin/dashboard' : BASE_URL . 'admin/dashboard' ?>">
            <div class="logo-icon">K</div>
            <div>
                <div class="logo-text">Kyros Commerce</div>
                <div class="logo-subtitle"><?= $isSuperAdmin ? 'Super Administrador' : 'Panel de Control' ?></div>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <?php if ($isSuperAdmin): ?>
            <!-- Super Admin Nav -->
            <div class="nav-section-label">General</div>
            <a href="<?= BASE_URL ?>superadmin/dashboard"
               data-tooltip="Dashboard"
               class="nav-item <?= strpos($currentUri, 'superadmin/dashboard') !== false ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i><span class="nav-label"> Dashboard</span>
            </a>
            <a href="<?= BASE_URL ?>superadmin/stores"
               data-tooltip="Tiendas"
               class="nav-item <?= strpos($currentUri, '/stores') !== false ? 'active' : '' ?>">
                <i class="fas fa-store"></i><span class="nav-label"> Tiendas</span>
            </a>
            <a href="<?= BASE_URL ?>superadmin/licenses"
               data-tooltip="Licencias"
               class="nav-item <?= strpos($currentUri, '/licenses') !== false ? 'active' : '' ?>">
                <i class="fas fa-certificate"></i><span class="nav-label"> Licencias</span>
            </a>
            <a href="<?= BASE_URL ?>superadmin/users"
               data-tooltip="Usuarios"
               class="nav-item <?= strpos($currentUri, '/users') !== false ? 'active' : '' ?>">
                <i class="fas fa-users-cog"></i><span class="nav-label"> Usuarios</span>
            </a>
            <a href="<?= BASE_URL ?>superadmin/plan-requests"
               data-tooltip="Solicitudes"
               class="nav-item <?= strpos($currentUri, '/plan-requests') !== false ? 'active' : '' ?>">
                <i class="fas fa-exchange-alt"></i><span class="nav-label"> Solicitudes Plan</span>
            </a>

            <div class="nav-section-label" style="margin-top:8px;">Plataforma</div>
            <a href="<?= BASE_URL ?>superadmin/settings"
               data-tooltip="Configuración"
               class="nav-item <?= (strpos($currentUri, '/settings') !== false && strpos($currentUri, '/emails') === false) ? 'active' : '' ?>">
                <i class="fas fa-cog"></i><span class="nav-label"> Configuración</span>
            </a>
            <a href="<?= BASE_URL ?>superadmin/emails"
               data-tooltip="Correos"
               class="nav-item <?= strpos($currentUri, '/emails') !== false ? 'active' : '' ?>">
                <i class="fas fa-envelope"></i><span class="nav-label"> Correos</span>
            </a>

        <?php else: ?>
            <!-- Store Admin Nav -->
            <div class="nav-section-label">Mi Tienda</div>
            <a href="<?= BASE_URL ?>admin/dashboard"
               data-tooltip="Dashboard"
               class="nav-item <?= (strpos($currentUri, 'admin/dashboard') !== false) ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i><span class="nav-label"> Dashboard</span>
            </a>
            <a href="<?= BASE_URL ?>admin/products"
               data-tooltip="Productos"
               class="nav-item <?= (strpos($currentUri, 'admin/products') !== false || strpos($currentUri, 'admin/products/new') !== false) ? 'active' : '' ?>">
                <i class="fas fa-box-open"></i><span class="nav-label"> Productos</span>
            </a>
            <a href="<?= BASE_URL ?>admin/categories"
               data-tooltip="Categorias"
               class="nav-item <?= strpos($currentUri, 'admin/categories') !== false ? 'active' : '' ?>">
                <i class="fas fa-folder"></i><span class="nav-label"> Categorias</span>
            </a>
            <?php if (!empty($enabledModules['inventory'])): ?>
            <a href="<?= BASE_URL ?>admin/inventory"
               data-tooltip="Inventario"
               class="nav-item <?= strpos($currentUri, 'admin/inventory') !== false ? 'active' : '' ?>">
                <i class="fas fa-warehouse"></i><span class="nav-label"> Inventario</span>
            </a>
            <?php endif; ?>
            <?php if (!empty($enabledModules['finance'])): ?>
            <a href="<?= BASE_URL ?>admin/finance"
               data-tooltip="Finanzas"
               class="nav-item <?= strpos($currentUri, 'admin/finance') !== false ? 'active' : '' ?>">
                <i class="fas fa-chart-pie"></i><span class="nav-label"> Finanzas</span>
            </a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>admin/orders"
               data-tooltip="Órdenes"
               class="nav-item <?= strpos($currentUri, 'admin/orders') !== false ? 'active' : '' ?>">
                <i class="fas fa-shopping-bag"></i><span class="nav-label"> Órdenes</span>
            </a>
            <a href="<?= BASE_URL ?>admin/customers"
               data-tooltip="Clientes"
               class="nav-item <?= strpos($currentUri, 'admin/customers') !== false ? 'active' : '' ?>">
                <i class="fas fa-users"></i><span class="nav-label"> Clientes</span>
            </a>
            <a href="<?= BASE_URL ?>admin/documentation"
               data-tooltip="Documentación"
               class="nav-item <?= strpos($currentUri, 'admin/documentation') !== false ? 'active' : '' ?>">
                <i class="fas fa-book"></i><span class="nav-label"> Documentación</span>
            </a>

            <div class="nav-section-label" style="margin-top:8px;">Ajustes</div>
            <a href="<?= BASE_URL ?>admin/settings"
               data-tooltip="Configuración"
               class="nav-item <?= strpos($currentUri, 'admin/settings') !== false ? 'active' : '' ?>">
                <i class="fas fa-sliders-h"></i><span class="nav-label"> Configuración</span>
            </a>
        <?php endif; ?>
    </nav>

    <!-- Footer: store URL + logout -->
    <div class="sidebar-footer">
        <?php if (!$isSuperAdmin && isset($storeData)): ?>
        <div class="store-url-chip" style="margin-bottom:10px;">
            <div class="label">URL de tu tienda</div>
            <a href="<?= BASE_URL ?>shop/<?= $storeData['slug'] ?>" target="_blank">
                /shop/<?= htmlspecialchars($storeData['slug']) ?>
                <i class="fas fa-external-link-alt text-xs ml-1"></i>
            </a>
        </div>
        <?php endif; ?>

        <a href="<?= BASE_URL ?>auth/logout" data-tooltip="Cerrar sesión"
           style="display:flex;align-items:center;gap:8px;color:#ef4444;font-size:13px;font-weight:600;padding:8px 4px;text-decoration:none;transition:color .15s;"
           onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#ef4444'">
            <i class="fas fa-sign-out-alt" style="width:18px;min-width:18px;text-align:center;flex-shrink:0;font-size:14px;"></i>
            <span class="sidebar-logout-text">Cerrar sesión</span>
        </a>
    </div>
</aside>

<!-- ======== MAIN WRAPPER ======== -->
<div class="admin-wrapper" id="adminWrapper">

    <!-- Top Bar -->
    <header class="admin-topbar">
        <div class="topbar-left flex items-center gap-3">
            <!-- Mobile menu toggle (hamburger) -->
            <button id="mobileMenuBtn"
                    class="mobile-menu-btn lg:hidden"
                    aria-label="Abrir menú">
                <i class="fas fa-bars"></i>
                <span style="font-size:13px;font-weight:700;">Menú</span>
            </button>

            <!-- Desktop sidebar toggle -->
            <button id="desktopSidebarBtn" class="topbar-sidebar-btn hidden lg:inline-flex" aria-label="Alternar menú lateral">
                <i class="fas fa-chevron-left" id="desktopSidebarIcon"></i>
                <span id="desktopSidebarText">Ocultar menú</span>
            </button>

            <h1 style="font-size:14px;font-weight:700;color:#1e293b;letter-spacing:-0.2px;">
                <?= htmlspecialchars($page_title ?? 'Dashboard') ?>
            </h1>
        </div>

        <div class="topbar-right">
            <?php if (!$isSuperAdmin && isset($storeData)): ?>
                     <a href="<?= BASE_URL ?>shop/<?= $storeData['slug'] ?>" target="_blank"
                         class="topbar-store-link"
                         style="font-size:13px;color:#2a7a52;font-weight:600;display:flex;align-items:center;gap:5px;text-decoration:none;padding:5px 10px;border-radius:7px;border:1px solid #bbf7d0;background:#ecfdf5;transition:all .15s;">
                    <i class="fas fa-external-link-alt" style="font-size:11px;"></i>
                    <span>Ver tienda</span>
                </a>
            <?php endif; ?>

            <div class="topbar-divider"></div>

            <div style="display:flex;align-items:center;gap:10px;">
                <div class="user-avatar">
                    <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                </div>
                <div class="topbar-user-info">
                    <span style="font-size:13px;font-weight:600;color:#1e293b;">
                        <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>
                    </span>
                    <span style="font-size:11px;color:#94a3b8;">
                        <?= $isSuperAdmin ? 'Super Admin' : 'Propietario' ?>
                    </span>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="admin-page-wrap fade-in">
        <?php include VIEWS_PATH . $view_content; ?>
    </main>

</div><!-- /admin-wrapper -->

<!-- Mobile overlay -->
<div id="sidebarOverlay"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:190;backdrop-filter:blur(2px);-webkit-backdrop-filter:blur(2px);transition:opacity 0.25s ease;opacity:0;"></div>

<script src="<?= ASSETS_PATH ?>js/script.js"></script>
<script>
(function() {
    var sidebar  = document.getElementById('adminSidebar');
    var wrapper  = document.getElementById('adminWrapper');
    var overlay  = document.getElementById('sidebarOverlay');
    var deskBtn  = document.getElementById('desktopSidebarBtn');
    var deskIcon = document.getElementById('desktopSidebarIcon');
    var deskText = document.getElementById('desktopSidebarText');
    var mobileBtn= document.getElementById('mobileMenuBtn');
    var isMobile = function() { return window.innerWidth < 1024; };

    // ---- Collapse (desktop) ----
    var STORAGE_KEY = 'kyros_sidebar_collapsed';
    var isCollapsed = localStorage.getItem(STORAGE_KEY) === '1';

    function syncDesktopToggle(collapsed) {
        if (!deskBtn || !deskIcon || !deskText) return;
        if (collapsed) {
            deskText.textContent = 'Mostrar menú';
            deskIcon.className = 'fas fa-chevron-right';
        } else {
            deskText.textContent = 'Ocultar menú';
            deskIcon.className = 'fas fa-chevron-left';
        }
    }

    function applyCollapsed(collapsed, animate) {
        if (!animate) {
            sidebar.style.transition = 'none';
            wrapper.style.transition = 'none';
        }
        if (collapsed) {
            sidebar.classList.add('collapsed');
            wrapper.classList.add('sidebar-collapsed');
        } else {
            sidebar.classList.remove('collapsed');
            wrapper.classList.remove('sidebar-collapsed');
        }
        syncDesktopToggle(collapsed);
        if (!animate) {
            requestAnimationFrame(function() {
                sidebar.style.transition = '';
                wrapper.style.transition = '';
            });
        }
    }

    // Apply on load without animation
    if (!isMobile()) {
        applyCollapsed(isCollapsed, false);
    }

    if (deskBtn) {
        deskBtn.addEventListener('click', function() {
            if (isMobile()) return;
            isCollapsed = !isCollapsed;
            localStorage.setItem(STORAGE_KEY, isCollapsed ? '1' : '0');
            applyCollapsed(isCollapsed, true);
        });
    }

    // ---- Mobile open/close ----
    function openMobileSidebar() {
        sidebar.classList.add('open');
        overlay.style.display = 'block';
        requestAnimationFrame(function() { overlay.style.opacity = '1'; });
        document.body.style.overflow = 'hidden';
        document.body.classList.add('sidebar-open');
    }
    function closeMobileSidebar() {
        sidebar.classList.remove('open');
        overlay.style.opacity = '0';
        document.body.style.overflow = '';
        document.body.classList.remove('sidebar-open');
        setTimeout(function() { overlay.style.display = 'none'; }, 250);
    }

    if (mobileBtn) {
        mobileBtn.addEventListener('click', function() {
            if (sidebar.classList.contains('open')) {
                closeMobileSidebar();
            } else {
                openMobileSidebar();
            }
        });
    }

    overlay.addEventListener('click', closeMobileSidebar);

    // Close mobile sidebar on resize to desktop
    window.addEventListener('resize', function() {
        if (!isMobile()) {
            closeMobileSidebar();
            applyCollapsed(isCollapsed, false);
        } else {
            sidebar.classList.remove('collapsed');
            wrapper.classList.remove('sidebar-collapsed');
        }
    });
})();
</script>
</body>
</html>
