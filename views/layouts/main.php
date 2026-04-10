<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' — ' . APP_NAME : APP_NAME ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/style.css">
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/mobile-pro.css">
    <style>
        :root { --primary: #2a7a52; --primary-hover: #1f5c3d; }
        .nav-link { font-size: 14px; font-weight: 500; color: #475569; padding: 6px 10px; border-radius: 7px; transition: all 0.15s; text-decoration: none; }
        .nav-link:hover { color: #1f5c3d; background: #ecfdf5; }
    </style>
</head>
<body class="bg-white text-gray-900">

<?php
$socialLinks = [
    ['icon' => 'fab fa-twitter', 'url' => trim((string)(getenv('SOCIAL_TWITTER_URL') ?: ''))],
    ['icon' => 'fab fa-instagram', 'url' => trim((string)(getenv('SOCIAL_INSTAGRAM_URL') ?: ''))],
    ['icon' => 'fab fa-linkedin', 'url' => trim((string)(getenv('SOCIAL_LINKEDIN_URL') ?: ''))],
];

$socialLinks = array_values(array_filter($socialLinks, function ($item) {
    return !empty($item['url']);
}));
?>

<!-- Navbar -->
<nav class="main-nav">
    <div class="nav-inner">
        <!-- Logo -->
        <a href="<?= BASE_URL ?>" class="nav-logo">
            <div class="logo-icon" style="background:linear-gradient(135deg,#2a7a52,#d4973a);color:#fff;display:flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:9px;font-weight:800;font-size:14px;">K</div>
            <span class="nav-logo-text">Kyros Commerce</span>
        </a>

        <!-- Nav links (desktop) -->
        <div class="hidden md:flex items-center gap-1">
            <a href="#caracteristicas" class="nav-link">Características</a>
            <a href="#planes" class="nav-link">Precios</a>
            <?php if (isset($storeData)): ?>
                <a href="<?= BASE_URL ?>shop/<?= $storeData['slug'] ?>/cart" class="nav-link flex items-center gap-1.5">
                    <i class="fas fa-shopping-cart text-xs"></i> Carrito
                    <span id="cart-count" class="bg-green-700 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-content-center">0</span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Auth actions (desktop) + hamburger (mobile) -->
        <div class="flex items-center gap-2">
            <?php if (Auth::isLoggedIn()): ?>
                <span class="hidden md:inline text-sm text-slate-500 font-medium">
                    <?= htmlspecialchars($_SESSION['user_name']) ?>
                </span>
                <?php if (Auth::isSuperAdmin()): ?>
                    <a href="<?= BASE_URL ?>superadmin/dashboard" class="btn btn-ghost btn-sm hidden md:inline-flex">
                        <i class="fas fa-chart-line text-xs"></i> Admin
                    </a>
                <?php elseif (Auth::isStoreOwner()): ?>
                    <a href="<?= BASE_URL ?>admin/dashboard" class="btn btn-ghost btn-sm hidden md:inline-flex">
                        <i class="fas fa-store text-xs"></i> Mi Tienda
                    </a>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>auth/logout" class="btn btn-ghost btn-sm text-red-500 hover:text-red-600 hidden md:inline-flex">
                    <i class="fas fa-sign-out-alt text-xs"></i>
                </a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>auth/login" class="btn btn-ghost btn-sm hidden md:inline-flex">Iniciar sesión</a>
                <a href="<?= BASE_URL ?>auth/register" class="btn btn-primary btn-sm hidden md:inline-flex">
                    Empezar gratis
                </a>
            <?php endif; ?>

            <!-- Hamburger (mobile) -->
            <button id="mainMenuBtn" class="mobile-menu-btn md:hidden" aria-label="Abrir menú">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile nav overlay -->
<div id="mainNavOverlay" class="mobile-nav-overlay" onclick="closeMainNav()"></div>

<!-- Mobile nav drawer -->
<div id="mainNavDrawer" class="mobile-nav-drawer">
    <div class="mobile-nav-header">
        <div style="display:flex;align-items:center;gap:9px;">
            <div style="width:30px;height:30px;background:linear-gradient(135deg,#2a7a52,#d4973a);border-radius:8px;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:13px;color:#fff;">K</div>
            <span style="font-size:16px;font-weight:800;color:#1e293b;">Kyros Commerce</span>
        </div>
        <button class="mobile-nav-close" onclick="closeMainNav()"><i class="fas fa-times"></i></button>
    </div>
    <div class="mobile-nav-links">
        <a href="#caracteristicas" class="mobile-nav-link" onclick="closeMainNav()">
            <i class="fas fa-star"></i> Características
        </a>
        <a href="#planes" class="mobile-nav-link" onclick="closeMainNav()">
            <i class="fas fa-tag"></i> Precios
        </a>
        <?php if (isset($storeData)): ?>
        <a href="<?= BASE_URL ?>shop/<?= $storeData['slug'] ?>/cart" class="mobile-nav-link" onclick="closeMainNav()">
            <i class="fas fa-shopping-cart"></i> Carrito
        </a>
        <?php endif; ?>
    </div>
    <div class="mobile-nav-footer">
        <?php if (Auth::isLoggedIn()): ?>
            <?php if (Auth::isSuperAdmin()): ?>
                <a href="<?= BASE_URL ?>superadmin/dashboard" style="display:flex;align-items:center;justify-content:center;gap:8px;height:42px;border-radius:9px;background:#ecfdf5;border:1.5px solid #bbf7d0;color:#2a7a52;font-size:14px;font-weight:600;text-decoration:none;">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
            <?php elseif (Auth::isStoreOwner()): ?>
                <a href="<?= BASE_URL ?>admin/dashboard" style="display:flex;align-items:center;justify-content:center;gap:8px;height:42px;border-radius:9px;background:#ecfdf5;border:1.5px solid #bbf7d0;color:#2a7a52;font-size:14px;font-weight:600;text-decoration:none;">
                    <i class="fas fa-store"></i> Mi Tienda
                </a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>auth/logout" style="display:flex;align-items:center;justify-content:center;gap:8px;height:42px;border-radius:9px;background:#fef2f2;border:1.5px solid #fecaca;color:#ef4444;font-size:14px;font-weight:600;text-decoration:none;">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>auth/login" style="display:flex;align-items:center;justify-content:center;gap:8px;height:42px;border-radius:9px;border:1.5px solid #e2e8f0;color:#475569;font-size:14px;font-weight:600;text-decoration:none;">
                Iniciar sesión
            </a>
            <a href="<?= BASE_URL ?>auth/register" style="display:flex;align-items:center;justify-content:center;gap:8px;height:42px;border-radius:9px;background:linear-gradient(135deg,#2a7a52,#1f5c3d);color:#fff;font-size:14px;font-weight:700;text-decoration:none;">
                <i class="fas fa-rocket"></i> Empezar gratis
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Main Content -->
<main>
    <?php include VIEWS_PATH . $view_content; ?>
</main>

<!-- Footer -->
<footer style="background:#0f172a;color:#94a3b8;" class="py-16 mt-20">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
            <!-- Brand -->
            <div>
                <div class="flex items-center gap-2.5 mb-4">
                    <div style="background:linear-gradient(135deg,#2a7a52,#d4973a);border-radius:9px;width:34px;height:34px;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px;color:#fff;">K</div>
                    <span style="color:#f8fafc;font-size:17px;font-weight:700;">Kyros Commerce</span>
                </div>
                <p class="text-sm leading-relaxed mb-5">La plataforma ideal para vender online sin complicaciones.</p>
                <?php if (!empty($socialLinks)): ?>
                <div class="flex gap-3">
                    <?php foreach ($socialLinks as $social): ?>
                    <a href="<?= htmlspecialchars($social['url']) ?>" target="_blank" rel="noopener noreferrer" style="color:#475569;" class="hover:text-white transition-colors w-8 h-8 rounded-lg border border-slate-700 flex items-center justify-content-center">
                        <i class="<?= htmlspecialchars($social['icon']) ?> text-sm" style="margin:auto;display:block;text-align:center;line-height:32px;"></i>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Producto -->
            <div>
                <h4 style="color:#f8fafc;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:1px;" class="mb-4">Producto</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#caracteristicas" class="hover:text-white transition-colors">Características</a></li>
                    <li><a href="#planes" class="hover:text-white transition-colors">Precios</a></li>
                    <li><a href="<?= BASE_URL ?>security" class="hover:text-white transition-colors">Seguridad</a></li>
                    <li><a href="<?= BASE_URL ?>api-docs" class="hover:text-white transition-colors">API</a></li>
                </ul>
            </div>

            <!-- Compañía -->
            <div>
                <h4 style="color:#f8fafc;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:1px;" class="mb-4">Compañía</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="<?= BASE_URL ?>about" class="hover:text-white transition-colors">Acerca de</a></li>
                    <li><a href="<?= BASE_URL ?>blog" class="hover:text-white transition-colors">Blog</a></li>
                    <li><a href="<?= BASE_URL ?>contact" class="hover:text-white transition-colors">Contacto</a></li>
                    <li><a href="<?= BASE_URL ?>jobs" class="hover:text-white transition-colors">Empleos</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h4 style="color:#f8fafc;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:1px;" class="mb-4">Legal</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="<?= BASE_URL ?>terms" class="hover:text-white transition-colors">Términos de servicio</a></li>
                    <li><a href="<?= BASE_URL ?>privacy" class="hover:text-white transition-colors">Política de privacidad</a></li>
                    <li><a href="<?= BASE_URL ?>cookies" class="hover:text-white transition-colors">Cookies</a></li>
                </ul>
            </div>
        </div>

        <div style="border-top:1px solid rgba(255,255,255,0.07);" class="pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm">&copy; <?= date('Y') ?> Kyros Commerce. Todos los derechos reservados.</p>
            <p class="text-sm flex items-center gap-1.5">
                <span style="color:#4ade80;" class="text-xs">●</span>
                Todos los sistemas operativos
            </p>
        </div>
    </div>
</footer>

<script src="<?= ASSETS_PATH ?>js/script.js"></script>
<script>
function openMainNav() {
    document.getElementById('mainNavDrawer').classList.add('open');
    document.getElementById('mainNavOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeMainNav() {
    document.getElementById('mainNavDrawer').classList.remove('open');
    document.getElementById('mainNavOverlay').classList.remove('open');
    document.body.style.overflow = '';
}
var mainMenuBtn = document.getElementById('mainMenuBtn');
if (mainMenuBtn) {
    mainMenuBtn.addEventListener('click', openMainNav);
}
</script>
</body>
</html>
