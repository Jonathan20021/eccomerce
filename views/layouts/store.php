<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' — ' . APP_NAME : APP_NAME ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/style.css">
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/mobile-pro.css">
    <style>
        /* ── Store-specific overrides ── */
        body { background: #fff; }

        /* Announcement bar */
        .store-announcement {
            background: #1e293b;
            color: rgba(255,255,255,0.82);
            font-size: 12.5px;
            font-weight: 500;
            text-align: center;
            padding: 8px 16px;
            letter-spacing: .2px;
        }
        .store-announcement a { color: #a5b4fc; text-decoration: underline; }

        /* Navbar */
        .store-nav {
            position: sticky; top: 0; z-index: 200;
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid #f1f5f9;
        }
        .store-nav-inner {
            max-width: 1280px; margin: 0 auto;
            padding: 0 24px;
            height: 68px;
            display: flex; align-items: center; gap: 20px;
        }
        .store-nav-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; flex-shrink: 0;
        }
        .store-nav-logo-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: #0f172a;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 900;
            flex-shrink: 0;
        }
        .store-nav-logo-text {
            font-size: 17px; font-weight: 800;
            color: #0f172a; letter-spacing: -.4px;
            white-space: nowrap;
        }
        .store-nav-links {
            display: flex; align-items: center; gap: 2px;
            flex: 1;
        }
        .store-nav-link {
            font-size: 14px; font-weight: 600; color: #475569;
            padding: 7px 12px; border-radius: 8px;
            text-decoration: none; white-space: nowrap;
            transition: background .15s, color .15s;
        }
        .store-nav-link:hover { background: #f8fafc; color: #0f172a; }
        .store-nav-actions { display: flex; align-items: center; gap: 8px; }
        .store-nav-search {
            position: relative;
        }
        .store-nav-search input {
            height: 38px; width: 220px;
            padding: 0 14px 0 38px;
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            font-size: 13px; color: #1e293b; font-family: 'Inter', sans-serif;
            background: #f8fafc; outline: none;
            transition: border-color .15s, background .15s, width .25s;
        }
        .store-nav-search input:focus {
            border-color: #4f46e5; background: #fff; width: 260px;
        }
        .store-nav-search i {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 12px; pointer-events: none;
        }
        .store-cart-btn {
            position: relative;
            display: inline-flex; align-items: center; gap: 7px;
            background: #0f172a; color: #fff;
            padding: 9px 16px; border-radius: 10px;
            font-size: 13.5px; font-weight: 700;
            text-decoration: none; white-space: nowrap;
            transition: background .15s, transform .15s;
        }
        .store-cart-btn:hover { background: #1e293b; transform: translateY(-1px); }
        .store-cart-badge {
            position: absolute; top: -6px; right: -6px;
            min-width: 18px; height: 18px;
            background: #ef4444; color: #fff;
            border-radius: 9999px; font-size: 10px; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            padding: 0 4px;
            border: 2px solid #fff;
        }
        .store-hamburger {
            display: none;
            background: none; border: none;
            font-size: 18px; color: #475569;
            padding: 6px; border-radius: 6px; cursor: pointer;
        }

        /* Promo / Trust strip */
        .store-trust {
            background: #f8fafc;
            border-bottom: 1px solid #f1f5f9;
            padding: 11px 24px;
        }
        .store-trust-inner {
            max-width: 1280px; margin: 0 auto;
            display: flex; align-items: center; justify-content: center;
            gap: 32px; flex-wrap: wrap;
        }
        .store-trust-item {
            display: flex; align-items: center; gap: 7px;
            font-size: 12.5px; font-weight: 600; color: #475569;
            white-space: nowrap;
        }
        .store-trust-item i { color: #4f46e5; font-size: 13px; }

        /* Hero */
        .store-hero-v2 {
            position: relative; overflow: hidden;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #312e81 75%, #4338ca 100%);
            min-height: 320px;
            display: flex; align-items: center;
        }
        .store-hero-v2::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(circle at 80% 20%, rgba(139,92,246,0.25) 0%, transparent 50%),
                radial-gradient(circle at 20% 80%, rgba(79,70,229,0.2) 0%, transparent 40%);
        }
        .store-hero-v2::after {
            content: '';
            position: absolute; bottom: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.12), transparent);
        }
        .store-hero-inner {
            position: relative; z-index: 1;
            max-width: 1280px; margin: 0 auto; width: 100%;
            padding: 56px 24px;
            display: flex; align-items: center; justify-content: space-between; gap: 32px;
            flex-wrap: wrap;
        }
        .store-hero-brand { display: flex; align-items: center; gap: 20px; }
        .store-hero-logo-wrap {
            width: 72px; height: 72px;
            border-radius: 18px;
            background: rgba(255,255,255,0.1);
            border: 1.5px solid rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            backdrop-filter: blur(10px);
        }
        .store-hero-logo-wrap img { width: 60px; height: 60px; object-fit: cover; border-radius: 14px; }
        .store-hero-logo-letter {
            font-size: 28px; font-weight: 900; color: #fff; line-height: 1;
        }
        .store-hero-info {}
        .store-hero-name {
            font-size: clamp(22px, 3.5vw, 38px);
            font-weight: 900; color: #fff; letter-spacing: -.8px; line-height: 1.1;
            margin-bottom: 8px;
        }
        .store-hero-desc {
            font-size: 15px; color: rgba(255,255,255,.62); line-height: 1.55; max-width: 460px;
        }
        .store-hero-meta {
            display: flex; align-items: center; gap: 16px;
            margin-top: 14px; flex-wrap: wrap;
        }
        .store-hero-chip {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            color: rgba(255,255,255,.7);
            font-size: 12.5px; font-weight: 600;
            padding: 5px 12px; border-radius: 9999px;
        }
        .store-hero-actions { display: flex; flex-direction: column; gap: 10px; align-items: flex-end; }
        .store-hero-wa {
            display: inline-flex; align-items: center; gap: 8px;
            background: #25D366; color: #fff;
            padding: 11px 20px; border-radius: 12px;
            font-size: 14px; font-weight: 700; text-decoration: none;
            box-shadow: 0 6px 20px rgba(37,211,102,.35);
            transition: transform .2s, box-shadow .2s;
        }
        .store-hero-wa:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(37,211,102,.45); }

        /* Category chips */
        .cat-strip {
            max-width: 1280px; margin: 0 auto;
            padding: 20px 24px 0;
            display: flex; align-items: center; gap: 8px;
            overflow-x: auto; scrollbar-width: none;
        }
        .cat-strip::-webkit-scrollbar { display: none; }
        .cat-chip {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 15px; border-radius: 9999px;
            border: 1.5px solid #e2e8f0;
            background: #fff; color: #475569;
            font-size: 13px; font-weight: 600;
            white-space: nowrap; text-decoration: none;
            transition: all .15s;
            flex-shrink: 0;
        }
        .cat-chip:hover { border-color: #a5b4fc; color: #4f46e5; background: #eef2ff; }
        .cat-chip.active { background: #1e293b; border-color: #1e293b; color: #fff; }

        /* Product grid */
        .products-wrap { max-width: 1280px; margin: 0 auto; padding: 28px 24px 60px; }
        .products-toolbar {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
        }
        .products-count { font-size: 13.5px; color: #94a3b8; font-weight: 500; }
        .products-count strong { color: #1e293b; }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 20px;
        }

        /* Product card — portrait Shopify style */
        .sf-product-card {
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            transition: box-shadow .25s cubic-bezier(.4,0,.2,1), transform .25s;
            cursor: pointer;
        }
        .sf-product-card:hover {
            box-shadow: 0 16px 40px -8px rgba(0,0,0,.14);
            transform: translateY(-4px);
        }
        .sf-product-img {
            aspect-ratio: 3/4;
            background: #f1f5f9;
            overflow: hidden;
            position: relative;
        }
        .sf-product-img img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform .45s cubic-bezier(.4,0,.2,1);
            display: block;
        }
        .sf-product-card:hover .sf-product-img img { transform: scale(1.07); }
        .sf-product-img-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        }
        .sf-product-img-placeholder i { font-size: 52px; color: #e2e8f0; }

        /* Badges */
        .sf-badge-wrap {
            position: absolute; top: 12px; left: 12px;
            display: flex; flex-direction: column; gap: 5px;
        }
        .sf-badge {
            padding: 3px 9px; border-radius: 6px;
            font-size: 10.5px; font-weight: 700; letter-spacing: .3px;
            line-height: 1.4;
        }
        .sf-badge-sale { background: #ef4444; color: #fff; }
        .sf-badge-new  { background: #0f172a; color: #fff; }
        .sf-badge-out  {
            position: absolute; inset: 0;
            background: rgba(15,23,42,.45);
            display: flex; align-items: center; justify-content: center;
        }
        .sf-badge-out span {
            background: #1e293b; color: #fff;
            font-size: 12px; font-weight: 700;
            padding: 6px 16px; border-radius: 8px; letter-spacing: .5px;
        }

        /* Hover CTA overlay */
        .sf-product-overlay {
            position: absolute; bottom: 0; left: 0; right: 0;
            padding: 12px;
            transform: translateY(100%);
            transition: transform .25s cubic-bezier(.4,0,.2,1);
        }
        .sf-product-card:hover .sf-product-overlay { transform: translateY(0); }
        .sf-add-btn {
            width: 100%;
            padding: 11px;
            border: none;
            border-radius: 10px;
            background: rgba(15,23,42,.92);
            backdrop-filter: blur(6px);
            color: #fff;
            font-size: 13.5px; font-weight: 700; font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            transition: background .15s;
        }
        .sf-add-btn:hover { background: #4f46e5; }
        .sf-add-btn:disabled { background: rgba(100,116,139,.7); cursor: not-allowed; }

        /* Product info */
        .sf-product-info { padding: 14px 4px 4px; }
        .sf-product-cat {
            font-size: 11px; font-weight: 700; color: #94a3b8;
            text-transform: uppercase; letter-spacing: .6px;
            margin-bottom: 5px;
        }
        .sf-product-name {
            font-size: 14.5px; font-weight: 700; color: #1e293b;
            line-height: 1.35; margin-bottom: 8px;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .sf-product-prices { display: flex; align-items: baseline; gap: 7px; }
        .sf-price { font-size: 17px; font-weight: 800; color: #1e293b; }
        .sf-price-sale { color: #ef4444; }
        .sf-price-original { font-size: 13px; color: #94a3b8; text-decoration: line-through; }
        .sf-stock-dot {
            display: inline-block; width: 6px; height: 6px;
            background: #22c55e; border-radius: 50%; margin-right: 4px;
        }

        /* Empty state */
        .sf-empty {
            text-align: center; padding: 80px 24px;
            grid-column: 1 / -1;
        }
        .sf-empty-icon {
            width: 80px; height: 80px;
            background: #f1f5f9; border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px; font-size: 32px; color: #cbd5e1;
        }

        /* Mobile drawer */
        .store-mobile-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.45); z-index: 300;
        }
        .store-mobile-overlay.open { display: block; }
        .store-mobile-drawer {
            position: fixed; top: 0; right: 0;
            width: min(320px, 88vw); height: 100%;
            background: #fff; z-index: 301;
            display: flex; flex-direction: column;
            transform: translateX(100%);
            transition: transform .3s cubic-bezier(.4,0,.2,1);
        }
        .store-mobile-drawer.open { transform: translateX(0); }
        .store-mobile-head {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 20px; border-bottom: 1px solid #f1f5f9;
        }
        .store-mobile-body { flex: 1; overflow-y: auto; padding: 14px 14px; }
        .store-mobile-link {
            display: block; padding: 12px 14px; border-radius: 10px;
            font-size: 15px; font-weight: 600; color: #1e293b;
            text-decoration: none; transition: background .15s;
        }
        .store-mobile-link:hover { background: #f8fafc; }

        /* Footer */
        .store-footer {
            background: #0b1220;
            color: #9ca3af;
            margin-top: 0;
        }
        .store-footer-main {
            max-width: 1280px; margin: 0 auto;
            padding: 48px 24px 36px;
            display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 32px;
        }
        .store-footer-brand-name {
            font-size: 16px; font-weight: 800; color: #f8fafc;
            margin-bottom: 10px; letter-spacing: -.3px;
        }
        .store-footer-desc {
            font-size: 13px; line-height: 1.7; color: #9ca3af; margin-bottom: 16px;
        }
        .store-footer-socials { display: flex; gap: 10px; }
        .store-footer-social {
            width: 34px; height: 34px; border-radius: 8px;
            background: rgba(255,255,255,.07); color: #9ca3af;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; transition: background .15s, color .15s;
        }
        .store-footer-social:hover { background: #4f46e5; color: #fff; }
        .store-footer-col-title {
            font-size: 11.5px; font-weight: 700;
            color: #f8fafc; text-transform: uppercase; letter-spacing: .8px;
            margin-bottom: 14px;
        }
        .store-footer-link {
            display: block; font-size: 13px; color: #9ca3af; margin-bottom: 9px;
            text-decoration: none; transition: color .15s;
        }
        .store-footer-link:hover { color: #e2e8f0; }
        .store-footer-bottom {
            border-top: 1px solid rgba(255,255,255,.06);
            max-width: 1280px; margin: 0 auto;
            padding: 16px 24px;
            display: flex; align-items: center; justify-content: space-between;
            font-size: 12px; flex-wrap: wrap; gap: 8px;
        }
        .store-footer-powered { color: #475569; }
        .store-footer-powered a { color: #6366f1; text-decoration: none; font-weight: 600; }

        /* Pagination */
        .sf-pagination {
            display: flex; justify-content: center; gap: 6px;
            margin-top: 36px; flex-wrap: wrap;
        }
        .sf-page-btn {
            min-width: 38px; height: 38px;
            display: flex; align-items: center; justify-content: center;
            border: 1.5px solid #e2e8f0; border-radius: 9px;
            font-size: 13.5px; font-weight: 600; color: #475569;
            text-decoration: none; transition: all .15s;
        }
        .sf-page-btn:hover { border-color: #4f46e5; color: #4f46e5; }
        .sf-page-btn.active { background: #1e293b; border-color: #1e293b; color: #fff; }

        /* Responsive */
        @media (max-width: 1024px) {
            .store-nav-search { display: none; }
            .store-hamburger { display: flex; align-items: center; }
            .store-nav-links { display: none; }
            .store-footer-main { grid-template-columns: 1fr 1fr; gap: 24px; }
        }
        @media (max-width: 640px) {
            .store-nav-inner { padding: 0 16px; height: 60px; }
            .store-hero-inner { padding: 36px 16px; }
            .store-hero-name { font-size: 24px; }
            .store-hero-logo-wrap { width: 56px; height: 56px; }
            .products-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
            .products-wrap { padding: 20px 16px 48px; }
            .cat-strip { padding: 16px 16px 0; }
            .store-trust { display: none; }
            .store-footer-main { grid-template-columns: 1fr; gap: 24px; }
        }
    </style>
</head>
<body>

<?php
$menuLinks  = is_array($storeTheme['menu']   ?? null) ? $storeTheme['menu']   : [];
$footer     = is_array($storeTheme['footer'] ?? null) ? $storeTheme['footer'] : [];
$storeSlug  = $storeData['slug']  ?? '';
$storeName  = $storeData['name']  ?? 'Tienda';
$storeInitial = strtoupper(substr($storeName, 0, 1));
?>

<!-- Announcement bar (optional) -->
<?php if (!empty($storeTheme['announcement'])): ?>
<div class="store-announcement">
    <?= htmlspecialchars($storeTheme['announcement']) ?>
</div>
<?php endif; ?>

<!-- Navbar -->
<nav class="store-nav">
    <div class="store-nav-inner">
        <!-- Logo -->
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>" class="store-nav-logo">
            <?php if (!empty($storeData['logo'])): ?>
                <img src="<?= htmlspecialchars($storeData['logo']) ?>" alt=""
                     style="width:36px;height:36px;border-radius:9px;object-fit:cover;flex-shrink:0;">
            <?php else: ?>
                <div class="store-nav-logo-icon"><?= $storeInitial ?></div>
            <?php endif; ?>
            <span class="store-nav-logo-text"><?= htmlspecialchars($storeName) ?></span>
        </a>

        <!-- Desktop nav links -->
        <div class="store-nav-links">
            <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>" class="store-nav-link">
                <i class="fas fa-home" style="font-size:11px;margin-right:3px;"></i> Inicio
            </a>
            <?php foreach ($menuLinks as $item): ?>
                <?php if (!empty($item['label']) && !empty($item['url'])): ?>
                <a href="<?= htmlspecialchars($item['url']) ?>" class="store-nav-link">
                    <?= htmlspecialchars($item['label']) ?>
                </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Right actions -->
        <div class="store-nav-actions">
            <!-- Search (desktop) -->
            <div class="store-nav-search">
                <i class="fas fa-search"></i>
                <form method="GET" action="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>">
                    <input type="search" name="q" placeholder="Buscar productos..."
                           value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                </form>
            </div>

            <!-- Cart -->
            <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>/cart" class="store-cart-btn">
                <i class="fas fa-shopping-bag" style="font-size:14px;"></i>
                <span>Carrito</span>
                <span class="store-cart-badge" id="cart-count">0</span>
            </a>

            <!-- Hamburger -->
            <button class="store-hamburger" id="storeMenuBtn" onclick="openStoreMenu()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Trust strip (desktop) -->
<div class="store-trust">
    <div class="store-trust-inner">
        <div class="store-trust-item"><i class="fas fa-truck"></i> Envío rápido y seguro</div>
        <div class="store-trust-item"><i class="fas fa-shield-alt"></i> Pago 100% seguro</div>
        <div class="store-trust-item"><i class="fab fa-whatsapp"></i> Atención por WhatsApp</div>
        <div class="store-trust-item"><i class="fas fa-undo"></i> Devoluciones fáciles</div>
    </div>
</div>

<main>
    <?php include VIEWS_PATH . $view_content; ?>
</main>

<!-- Footer -->
<footer class="store-footer">
    <div class="store-footer-main">
        <div>
            <div class="store-footer-brand-name"><?= htmlspecialchars($storeName) ?></div>
            <p class="store-footer-desc">
                <?= htmlspecialchars($footer['text'] ?? 'Tu tienda online de confianza.') ?>
            </p>
            <div class="store-footer-socials">
                <?php if (!empty($footer['facebook'])): ?>
                <a href="<?= htmlspecialchars($footer['facebook']) ?>" target="_blank" rel="noopener" class="store-footer-social"><i class="fab fa-facebook-f"></i></a>
                <?php endif; ?>
                <?php if (!empty($footer['instagram'])): ?>
                <a href="<?= htmlspecialchars($footer['instagram']) ?>" target="_blank" rel="noopener" class="store-footer-social"><i class="fab fa-instagram"></i></a>
                <?php endif; ?>
                <?php if (!empty($footer['tiktok'])): ?>
                <a href="<?= htmlspecialchars($footer['tiktok']) ?>" target="_blank" rel="noopener" class="store-footer-social"><i class="fab fa-tiktok"></i></a>
                <?php endif; ?>
                <?php if (!empty($storeData['whatsapp_number'])): ?>
                <a href="<?= Helper::getWhatsAppLink($storeData['whatsapp_number']) ?>" target="_blank" rel="noopener" class="store-footer-social"><i class="fab fa-whatsapp"></i></a>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <div class="store-footer-col-title">Tienda</div>
            <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>" class="store-footer-link">Inicio</a>
            <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>/cart" class="store-footer-link">Mi Carrito</a>
            <?php foreach ($menuLinks as $item): ?>
                <?php if (!empty($item['label']) && !empty($item['url'])): ?>
                <a href="<?= htmlspecialchars($item['url']) ?>" class="store-footer-link"><?= htmlspecialchars($item['label']) ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div>
            <div class="store-footer-col-title">Contacto</div>
            <?php if (!empty($footer['contact_email'])): ?>
            <a href="mailto:<?= htmlspecialchars($footer['contact_email']) ?>" class="store-footer-link">
                <i class="fas fa-envelope" style="margin-right:6px;font-size:11px;"></i><?= htmlspecialchars($footer['contact_email']) ?>
            </a>
            <?php endif; ?>
            <?php if (!empty($footer['contact_phone'])): ?>
            <a href="tel:<?= htmlspecialchars($footer['contact_phone']) ?>" class="store-footer-link">
                <i class="fas fa-phone" style="margin-right:6px;font-size:11px;"></i><?= htmlspecialchars($footer['contact_phone']) ?>
            </a>
            <?php endif; ?>
            <?php if (!empty($storeData['whatsapp_number'])): ?>
            <a href="<?= Helper::getWhatsAppLink($storeData['whatsapp_number']) ?>" target="_blank" rel="noopener" class="store-footer-link" style="color:#25D366;">
                <i class="fab fa-whatsapp" style="margin-right:6px;"></i><?= htmlspecialchars($storeData['whatsapp_number']) ?>
            </a>
            <?php endif; ?>
            <?php if (!empty($storeData['city'])): ?>
            <p class="store-footer-link" style="cursor:default;">
                <i class="fas fa-map-marker-alt" style="margin-right:6px;font-size:11px;"></i>
                <?= htmlspecialchars($storeData['city']) ?><?= !empty($storeData['country']) ? ', ' . htmlspecialchars($storeData['country']) : '' ?>
            </p>
            <?php endif; ?>
        </div>
        <div>
            <div class="store-footer-col-title">Legal</div>
            <a href="<?= htmlspecialchars($footer['terms_url'] ?? '#') ?>" class="store-footer-link">Términos y condiciones</a>
            <a href="<?= htmlspecialchars($footer['privacy_url'] ?? '#') ?>" class="store-footer-link">Política de privacidad</a>
        </div>
    </div>
    <div class="store-footer-bottom">
        <span>© <?= date('Y') ?> <?= htmlspecialchars($storeName) ?>. Todos los derechos reservados.</span>
        <span class="store-footer-powered">Impulsado por <a href="<?= BASE_URL ?>" target="_blank">Kyros Commerce</a></span>
    </div>
</footer>

<!-- Mobile menu overlay -->
<div class="store-mobile-overlay" id="storeMobileOverlay" onclick="closeStoreMenu()"></div>
<div class="store-mobile-drawer" id="storeMobileDrawer">
    <div class="store-mobile-head">
        <span style="font-size:16px;font-weight:800;color:#1e293b;"><?= htmlspecialchars($storeName) ?></span>
        <button onclick="closeStoreMenu()" style="background:none;border:none;font-size:18px;color:#94a3b8;cursor:pointer;padding:4px;border-radius:6px;">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="store-mobile-body">
        <!-- Mobile search -->
        <form method="GET" action="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>" style="margin-bottom:12px;">
            <div style="position:relative;">
                <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:12px;pointer-events:none;"></i>
                <input type="search" name="q" placeholder="Buscar productos..."
                       value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                       style="width:100%;box-sizing:border-box;padding:10px 14px 10px 36px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;font-family:'Inter',sans-serif;color:#1e293b;outline:none;">
            </div>
        </form>
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>" class="store-mobile-link">
            <i class="fas fa-home" style="width:18px;color:#4f46e5;margin-right:8px;"></i> Inicio
        </a>
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>/cart" class="store-mobile-link">
            <i class="fas fa-shopping-bag" style="width:18px;color:#4f46e5;margin-right:8px;"></i> Mi Carrito
        </a>
        <?php foreach ($menuLinks as $item): ?>
            <?php if (!empty($item['label']) && !empty($item['url'])): ?>
            <a href="<?= htmlspecialchars($item['url']) ?>" class="store-mobile-link">
                <?= htmlspecialchars($item['label']) ?>
            </a>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if (!empty($storeData['whatsapp_number'])): ?>
        <a href="<?= Helper::getWhatsAppLink($storeData['whatsapp_number']) ?>" target="_blank" rel="noopener"
           class="store-mobile-link" style="color:#16a34a;margin-top:8px;">
            <i class="fab fa-whatsapp" style="width:18px;margin-right:8px;"></i> WhatsApp
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- Toast container -->
<div id="toastContainer" style="position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:8px;"></div>

<script src="<?= ASSETS_PATH ?>js/script.js"></script>
<script>
function openStoreMenu() {
    document.getElementById('storeMobileOverlay').classList.add('open');
    document.getElementById('storeMobileDrawer').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeStoreMenu() {
    document.getElementById('storeMobileOverlay').classList.remove('open');
    document.getElementById('storeMobileDrawer').classList.remove('open');
    document.body.style.overflow = '';
}
</script>
</body>
</html>
