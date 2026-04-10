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
        /* ══════════════════════════════════════
           STORE PREMIUM DESIGN SYSTEM
        ══════════════════════════════════════ */
        :root {
            --store-primary:    #2a7a52;
            --store-primary-dk: #1f5c3d;
            --store-primary-lt: #ecfdf5;
            --store-accent:     #d4973a;
            --store-dark:       #0c1f12;
            --store-navy:       #0f172a;
            --store-wa:         #25D366;
        }

        * { box-sizing: border-box; }
        body { background: #fff; font-family: 'Inter', sans-serif; }

        /* ── Scroll progress bar ── */
        .scroll-progress {
            position: fixed; top: 0; left: 0; z-index: 9999;
            height: 3px; width: 0%;
            background: linear-gradient(90deg, var(--store-primary), var(--store-accent), var(--store-primary));
            background-size: 200% 100%;
            animation: progress-shimmer 2s linear infinite;
            transition: width .08s linear;
            pointer-events: none;
        }
        @keyframes progress-shimmer {
            0%   { background-position: 100% 0; }
            100% { background-position: -100% 0; }
        }

        /* ── Announcement bar ── */
        .store-announcement {
            background: linear-gradient(90deg, #0c1f12 0%, #1a4a2e 50%, #0c1f12 100%);
            background-size: 200% 100%;
            animation: ann-slide 8s linear infinite;
            color: rgba(255,255,255,0.85);
            font-size: 12.5px; font-weight: 500;
            text-align: center; padding: 9px 16px;
            letter-spacing: .25px; position: relative; overflow: hidden;
        }
        @keyframes ann-slide {
            0%   { background-position: 0% 0; }
            100% { background-position: 200% 0; }
        }
        .store-announcement::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 40% 100% at 50% 50%, rgba(212,151,58,.12), transparent);
            pointer-events: none;
        }
        .store-announcement a { color: #86efac; text-decoration: underline; text-underline-offset: 2px; }
        .store-announcement .ann-icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 16px; height: 16px;
            background: rgba(212,151,58,.25);
            border-radius: 50%; margin-right: 6px; font-size: 9px; color: #fde68a;
            vertical-align: middle;
        }

        /* ── Navbar ── */
        .store-nav {
            position: sticky; top: 0; z-index: 200;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(241,245,249,0.8);
            transition: box-shadow .25s ease, background .25s ease;
        }
        .store-nav.scrolled {
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            background: rgba(255,255,255,0.98);
        }
        .store-nav-inner {
            max-width: 1280px; margin: 0 auto;
            padding: 0 24px; height: 68px;
            display: flex; align-items: center; gap: 20px;
        }
        .store-nav-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; flex-shrink: 0;
        }
        .store-nav-logo-icon {
            width: 38px; height: 38px; border-radius: 11px;
            background: linear-gradient(135deg, var(--store-dark) 0%, var(--store-primary) 100%);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 900; flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(42,122,82,.35);
            transition: transform .2s, box-shadow .2s;
        }
        .store-nav-logo:hover .store-nav-logo-icon {
            transform: scale(1.07) rotate(-3deg);
            box-shadow: 0 6px 18px rgba(42,122,82,.45);
        }
        .store-nav-logo-text {
            font-size: 17px; font-weight: 800; color: #0f172a;
            letter-spacing: -.4px; white-space: nowrap;
        }
        .store-nav-links {
            display: flex; align-items: center; gap: 2px; flex: 1;
        }
        .store-nav-link {
            font-size: 14px; font-weight: 600; color: #475569;
            padding: 7px 12px; border-radius: 8px;
            text-decoration: none; white-space: nowrap;
            transition: background .15s, color .15s;
            position: relative;
        }
        .store-nav-link::after {
            content: ''; position: absolute; bottom: 4px; left: 12px; right: 12px;
            height: 2px; border-radius: 1px;
            background: var(--store-primary);
            transform: scaleX(0); transition: transform .2s ease;
        }
        .store-nav-link:hover { color: var(--store-primary); }
        .store-nav-link:hover::after { transform: scaleX(1); }
        .store-nav-actions { display: flex; align-items: center; gap: 8px; }
        .store-nav-search { position: relative; }
        .store-nav-search input {
            height: 38px; width: 220px;
            padding: 0 14px 0 38px;
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            font-size: 13px; color: #1e293b; font-family: 'Inter', sans-serif;
            background: #f8fafc; outline: none;
            transition: border-color .2s, background .2s, width .3s, box-shadow .2s;
        }
        .store-nav-search input:focus {
            border-color: var(--store-primary); background: #fff;
            width: 260px; box-shadow: 0 0 0 3px rgba(42,122,82,.1);
        }
        .store-nav-search i {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 12px; pointer-events: none;
            transition: color .2s;
        }
        .store-nav-search:focus-within i { color: var(--store-primary); }
        .store-cart-btn {
            position: relative;
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, var(--store-dark), var(--store-primary-dk));
            color: #fff;
            padding: 9px 18px; border-radius: 11px;
            font-size: 13.5px; font-weight: 700;
            text-decoration: none; white-space: nowrap;
            transition: transform .18s, box-shadow .18s;
            box-shadow: 0 4px 14px rgba(15,23,42,.25);
        }
        .store-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(15,23,42,.32);
        }
        .store-cart-badge {
            position: absolute; top: -7px; right: -7px;
            min-width: 20px; height: 20px;
            background: #ef4444; color: #fff;
            border-radius: 9999px; font-size: 10px; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            padding: 0 5px; border: 2.5px solid #fff;
            animation: badge-pop .3s cubic-bezier(.34,1.56,.64,1);
        }
        @keyframes badge-pop {
            from { transform: scale(0); }
            to   { transform: scale(1); }
        }
        .store-hamburger {
            display: none;
            background: none; border: 1.5px solid #e2e8f0;
            font-size: 16px; color: #475569;
            padding: 7px 9px; border-radius: 9px; cursor: pointer;
            transition: border-color .15s, color .15s, background .15s;
        }
        .store-hamburger:hover { border-color: #cbd5e1; color: #1e293b; background: #f8fafc; }

        /* ── Trust strip ── */
        .store-trust {
            background: linear-gradient(90deg, #f0fdf4, #f8fafc, #f0fdf4);
            border-bottom: 1px solid #dcfce7;
            padding: 10px 24px; overflow: hidden;
        }
        .store-trust-inner {
            max-width: 1280px; margin: 0 auto;
            display: flex; align-items: center; justify-content: center;
            gap: 36px; flex-wrap: wrap;
        }
        .store-trust-item {
            display: flex; align-items: center; gap: 8px;
            font-size: 12.5px; font-weight: 600; color: #374151;
            white-space: nowrap;
        }
        .store-trust-item .trust-icon {
            width: 28px; height: 28px; border-radius: 8px;
            background: linear-gradient(135deg, var(--store-primary), var(--store-primary-dk));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 12px; flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(42,122,82,.3);
        }

        /* ── Store Hero (in store.php, for the brand header) ── */
        .store-hero-v2 {
            position: relative; overflow: hidden;
            background: linear-gradient(135deg, #0c1f12 0%, #1a4a2e 45%, #2a7a52 80%, #1f5c3d 100%);
            min-height: 300px;
            display: flex; align-items: center;
        }
        .store-hero-v2::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(circle at 80% 20%, rgba(212,151,58,0.22) 0%, transparent 50%),
                radial-gradient(circle at 20% 80%, rgba(42,122,82,0.28) 0%, transparent 40%);
        }
        /* Animated mesh dots */
        .store-hero-v2::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                radial-gradient(circle, rgba(255,255,255,.07) 1px, transparent 1px);
            background-size: 32px 32px;
            animation: mesh-drift 20s linear infinite;
        }
        @keyframes mesh-drift {
            from { background-position: 0 0; }
            to   { background-position: 32px 32px; }
        }
        .store-hero-inner {
            position: relative; z-index: 1;
            max-width: 1280px; margin: 0 auto; width: 100%;
            padding: 52px 24px;
            display: flex; align-items: center; justify-content: space-between; gap: 32px;
            flex-wrap: wrap;
        }
        .store-hero-brand { display: flex; align-items: center; gap: 22px; }
        .store-hero-logo-wrap {
            width: 76px; height: 76px; border-radius: 20px;
            background: rgba(255,255,255,0.1);
            border: 1.5px solid rgba(255,255,255,0.18);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px rgba(0,0,0,.2);
            animation: logo-float 5s ease-in-out infinite;
        }
        @keyframes logo-float {
            0%,100% { transform: translateY(0); }
            50%     { transform: translateY(-6px); }
        }
        .store-hero-logo-wrap img { width: 62px; height: 62px; object-fit: cover; border-radius: 15px; }
        .store-hero-logo-letter { font-size: 30px; font-weight: 900; color: #fff; line-height: 1; }
        .store-hero-name {
            font-size: clamp(22px, 3.5vw, 36px);
            font-weight: 900; color: #fff; letter-spacing: -.8px; line-height: 1.1;
            margin-bottom: 8px;
        }
        .store-hero-desc {
            font-size: 14.5px; color: rgba(255,255,255,.62); line-height: 1.55; max-width: 460px;
        }
        .store-hero-meta {
            display: flex; align-items: center; gap: 14px;
            margin-top: 14px; flex-wrap: wrap;
        }
        .store-hero-chip {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.14);
            color: rgba(255,255,255,.75);
            font-size: 12px; font-weight: 600;
            padding: 5px 13px; border-radius: 9999px;
            backdrop-filter: blur(4px);
            transition: background .2s;
        }
        .store-hero-chip:hover { background: rgba(255,255,255,.14); }
        .store-hero-actions { display: flex; flex-direction: column; gap: 10px; align-items: flex-end; }
        .store-hero-wa {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--store-wa); color: #fff;
            padding: 12px 22px; border-radius: 13px;
            font-size: 14px; font-weight: 700; text-decoration: none;
            box-shadow: 0 6px 20px rgba(37,211,102,.38);
            transition: transform .2s, box-shadow .2s;
        }
        .store-hero-wa:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(37,211,102,.52); }

        /* ── Scroll-reveal animation ── */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .6s cubic-bezier(.4,0,.2,1), transform .6s cubic-bezier(.4,0,.2,1);
        }
        .reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-delay-1 { transition-delay: .08s; }
        .reveal-delay-2 { transition-delay: .16s; }
        .reveal-delay-3 { transition-delay: .24s; }
        .reveal-delay-4 { transition-delay: .32s; }
        .reveal-delay-5 { transition-delay: .40s; }
        .reveal-delay-6 { transition-delay: .48s; }

        /* ── Floating WhatsApp button ── */
        .float-wa-btn {
            position: fixed; bottom: 28px; right: 28px; z-index: 490;
            width: 58px; height: 58px;
            background: var(--store-wa);
            border-radius: 50%; font-size: 26px; color: #fff;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none;
            box-shadow: 0 6px 22px rgba(37,211,102,.45);
            transition: transform .25s, box-shadow .25s;
            animation: wa-pulse 2.8s ease-in-out infinite;
        }
        .float-wa-btn:hover {
            transform: scale(1.12) translateY(-3px);
            box-shadow: 0 12px 32px rgba(37,211,102,.6);
            animation: none;
        }
        .float-wa-btn .float-wa-tooltip {
            position: absolute; right: calc(100% + 12px); top: 50%;
            transform: translateY(-50%);
            background: #1e293b; color: #fff;
            font-size: 12.5px; font-weight: 600; font-family: 'Inter', sans-serif;
            padding: 6px 12px; border-radius: 8px; white-space: nowrap;
            opacity: 0; pointer-events: none;
            transition: opacity .2s;
        }
        .float-wa-btn .float-wa-tooltip::after {
            content: '';
            position: absolute; left: 100%; top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-left-color: #1e293b;
        }
        .float-wa-btn:hover .float-wa-tooltip { opacity: 1; }
        @keyframes wa-pulse {
            0%,100% { box-shadow: 0 6px 22px rgba(37,211,102,.45); }
            50%      { box-shadow: 0 6px 30px rgba(37,211,102,.7), 0 0 0 10px rgba(37,211,102,.1); }
        }

        /* ── Mobile drawer ── */
        .store-mobile-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.5); z-index: 300;
            backdrop-filter: blur(4px);
        }
        .store-mobile-overlay.open { display: block; }
        .store-mobile-drawer {
            position: fixed; top: 0; right: 0;
            width: min(320px, 88vw); height: 100%;
            background: #fff; z-index: 301;
            display: flex; flex-direction: column;
            transform: translateX(100%);
            transition: transform .32s cubic-bezier(.4,0,.2,1);
            box-shadow: -8px 0 48px rgba(0,0,0,.15);
        }
        .store-mobile-drawer.open { transform: translateX(0); }
        .store-mobile-head {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 20px; border-bottom: 1px solid #f1f5f9;
            background: linear-gradient(135deg, #0c1f12, #1a4a2e);
        }
        .store-mobile-head .store-name-mob {
            font-size: 16px; font-weight: 800; color: #fff;
        }
        .store-mobile-close {
            background: rgba(255,255,255,.12); border: none;
            font-size: 16px; color: rgba(255,255,255,.8); cursor: pointer;
            padding: 7px 9px; border-radius: 8px;
            transition: background .15s;
        }
        .store-mobile-close:hover { background: rgba(255,255,255,.22); }
        .store-mobile-body { flex: 1; overflow-y: auto; padding: 14px; }
        .store-mobile-link {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 14px; border-radius: 10px;
            font-size: 15px; font-weight: 600; color: #1e293b;
            text-decoration: none; transition: background .15s, color .15s;
        }
        .store-mobile-link:hover { background: #f0fdf4; color: var(--store-primary); }
        .store-mobile-link i { width: 18px; color: var(--store-primary); font-size: 14px; }
        .store-mobile-divider {
            height: 1px; background: #f1f5f9; margin: 8px 0;
        }
        .store-mobile-wa-btn {
            display: flex; align-items: center; justify-content: center; gap: 9px;
            margin: 12px; padding: 13px;
            background: var(--store-wa); color: #fff;
            border-radius: 12px; font-size: 14.5px; font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(37,211,102,.3);
        }

        /* ── Footer ── */
        .store-footer {
            background: #0b1220;
            color: #9ca3af;
            border-top: 3px solid transparent;
            background-clip: padding-box;
            position: relative;
        }
        .store-footer::before {
            content: '';
            position: absolute; top: -3px; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--store-dark), var(--store-primary), var(--store-accent), var(--store-primary), var(--store-dark));
            background-size: 300% 100%;
            animation: footer-line 6s ease infinite;
        }
        @keyframes footer-line {
            0%,100% { background-position: 0% 50%; }
            50%      { background-position: 100% 50%; }
        }
        .store-footer-main {
            max-width: 1280px; margin: 0 auto;
            padding: 52px 24px 36px;
            display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 36px;
        }
        .store-footer-brand-name {
            font-size: 17px; font-weight: 800; color: #f8fafc;
            margin-bottom: 10px; letter-spacing: -.3px;
        }
        .store-footer-desc {
            font-size: 13px; line-height: 1.75; color: #9ca3af; margin-bottom: 20px;
        }
        .store-footer-socials { display: flex; gap: 10px; margin-bottom: 0; }
        .store-footer-social {
            width: 36px; height: 36px; border-radius: 9px;
            background: rgba(255,255,255,.07); color: #9ca3af;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; transition: background .2s, color .2s, transform .2s;
            text-decoration: none;
        }
        .store-footer-social:hover {
            background: var(--store-primary); color: #fff;
            transform: translateY(-3px);
        }
        .store-footer-col-title {
            font-size: 11px; font-weight: 800;
            color: #f8fafc; text-transform: uppercase; letter-spacing: 1px;
            margin-bottom: 16px; padding-bottom: 8px;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .store-footer-link {
            display: block; font-size: 13px; color: #9ca3af; margin-bottom: 10px;
            text-decoration: none; transition: color .15s, padding-left .15s;
        }
        .store-footer-link:hover { color: #e2e8f0; padding-left: 4px; }
        .store-footer-bottom {
            border-top: 1px solid rgba(255,255,255,.06);
            max-width: 1280px; margin: 0 auto;
            padding: 18px 24px;
            display: flex; align-items: center; justify-content: space-between;
            font-size: 12px; flex-wrap: wrap; gap: 8px;
        }
        .store-footer-powered { color: #475569; }
        .store-footer-powered a { color: #86efac; text-decoration: none; font-weight: 600; }
        .store-footer-powered a:hover { color: #4ade80; }

        /* ── Toast ── */
        #toastContainer { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 8px; }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .store-nav-search { display: none; }
            .store-hamburger { display: flex; align-items: center; }
            .store-nav-links { display: none; }
            .store-footer-main { grid-template-columns: 1fr 1fr; gap: 28px; }
        }
        @media (max-width: 640px) {
            .store-nav-inner { padding: 0 16px; height: 60px; }
            .store-hero-inner { padding: 36px 16px; }
            .store-hero-name { font-size: 24px; }
            .store-hero-logo-wrap { width: 58px; height: 58px; }
            .store-trust { display: none; }
            .store-footer-main { grid-template-columns: 1fr; gap: 24px; }
            .float-wa-btn { bottom: 20px; right: 20px; width: 52px; height: 52px; font-size: 22px; }
        }
    </style>
</head>
<body>

<!-- Scroll progress -->
<div class="scroll-progress" id="scrollProgress"></div>

<?php
$menuLinks    = is_array($storeTheme['menu']   ?? null) ? $storeTheme['menu']   : [];
$footer       = is_array($storeTheme['footer'] ?? null) ? $storeTheme['footer'] : [];
$storeSlug    = $storeData['slug']  ?? '';
$storeName    = $storeData['name']  ?? 'Tienda';
$storeInitial = strtoupper(substr($storeName, 0, 1));
$hasWhatsApp  = !empty($storeData['whatsapp_number']);
$isCustomerInThisStore = Auth::isCustomerLoggedIn() && intval(Auth::getCustomerStoreId()) === intval($storeData['id'] ?? 0);
?>

<!-- Announcement bar (optional) -->
<?php if (!empty($storeTheme['announcement'])): ?>
<div class="store-announcement">
    <span class="ann-icon"><i class="fas fa-tag"></i></span>
    <?= htmlspecialchars($storeTheme['announcement']) ?>
</div>
<?php endif; ?>

<!-- Navbar -->
<nav class="store-nav" id="storeNav">
    <div class="store-nav-inner">
        <!-- Logo -->
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>" class="store-nav-logo">
            <?php if (!empty($storeData['logo'])): ?>
                <img src="<?= htmlspecialchars($storeData['logo']) ?>" alt=""
                     style="width:38px;height:38px;border-radius:10px;object-fit:cover;flex-shrink:0;box-shadow:0 2px 8px rgba(0,0,0,.12);">
            <?php else: ?>
                <div class="store-nav-logo-icon"><?= $storeInitial ?></div>
            <?php endif; ?>
            <span class="store-nav-logo-text"><?= htmlspecialchars($storeName) ?></span>
        </a>

        <!-- Desktop nav links -->
        <div class="store-nav-links">
            <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>" class="store-nav-link">
                <i class="fas fa-home" style="font-size:11px;margin-right:4px;opacity:.7;"></i> Inicio
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

            <?php if ($isCustomerInThisStore): ?>
            <a href="<?= BASE_URL ?>customer/panel"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:10px;color:#334155;text-decoration:none;font-size:13px;font-weight:700;white-space:nowrap;">
                <i class="fas fa-user" style="font-size:12px;"></i>
                Mi cuenta
            </a>
            <a href="<?= BASE_URL ?>customer/logout"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 12px;border:1.5px solid #fee2e2;border-radius:10px;color:#dc2626;text-decoration:none;font-size:13px;font-weight:700;white-space:nowrap;">
                <i class="fas fa-sign-out-alt" style="font-size:12px;"></i>
                Salir
            </a>
            <?php else: ?>
            <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>/customer/login"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:10px;color:#334155;text-decoration:none;font-size:13px;font-weight:700;white-space:nowrap;">
                <i class="fas fa-sign-in-alt" style="font-size:12px;"></i>
                Ingresar
            </a>
            <?php endif; ?>

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
        <div class="store-trust-item">
            <span class="trust-icon"><i class="fas fa-truck"></i></span>
            Envío rápido y seguro
        </div>
        <div class="store-trust-item">
            <span class="trust-icon"><i class="fas fa-shield-alt"></i></span>
            Pago 100% seguro
        </div>
        <?php if ($hasWhatsApp): ?>
        <div class="store-trust-item">
            <span class="trust-icon" style="background:linear-gradient(135deg,#16a34a,#15803d);"><i class="fab fa-whatsapp"></i></span>
            Atención por WhatsApp
        </div>
        <?php endif; ?>
        <div class="store-trust-item">
            <span class="trust-icon" style="background:linear-gradient(135deg,#b45309,#92400e);"><i class="fas fa-undo"></i></span>
            Devoluciones fáciles
        </div>
    </div>
</div>

<main id="mainContent">
    <?php include VIEWS_PATH . $view_content; ?>
</main>

<!-- Footer -->
<footer class="store-footer">
    <div class="store-footer-main">
        <div>
            <div class="store-footer-brand-name"><?= htmlspecialchars($storeName) ?></div>
            <p class="store-footer-desc">
                <?= htmlspecialchars($footer['text'] ?? 'Tu tienda online de confianza. Productos de calidad con atención personalizada.') ?>
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
                <?php if ($hasWhatsApp): ?>
                <a href="<?= Helper::getWhatsAppLink($storeData['whatsapp_number']) ?>" target="_blank" rel="noopener" class="store-footer-social" style="background:rgba(37,211,102,.15);color:#4ade80;"><i class="fab fa-whatsapp"></i></a>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <div class="store-footer-col-title">Tienda</div>
            <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>" class="store-footer-link">
                <i class="fas fa-home" style="margin-right:6px;font-size:10px;opacity:.6;"></i>Inicio
            </a>
            <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>/cart" class="store-footer-link">
                <i class="fas fa-shopping-bag" style="margin-right:6px;font-size:10px;opacity:.6;"></i>Mi Carrito
            </a>
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
                <i class="fas fa-envelope" style="margin-right:6px;font-size:10px;opacity:.6;"></i><?= htmlspecialchars($footer['contact_email']) ?>
            </a>
            <?php endif; ?>
            <?php if (!empty($footer['contact_phone'])): ?>
            <a href="tel:<?= htmlspecialchars($footer['contact_phone']) ?>" class="store-footer-link">
                <i class="fas fa-phone" style="margin-right:6px;font-size:10px;opacity:.6;"></i><?= htmlspecialchars($footer['contact_phone']) ?>
            </a>
            <?php endif; ?>
            <?php if ($hasWhatsApp): ?>
            <a href="<?= Helper::getWhatsAppLink($storeData['whatsapp_number']) ?>" target="_blank" rel="noopener" class="store-footer-link" style="color:#4ade80;">
                <i class="fab fa-whatsapp" style="margin-right:6px;"></i><?= htmlspecialchars($storeData['whatsapp_number']) ?>
            </a>
            <?php endif; ?>
            <?php if (!empty($storeData['city'])): ?>
            <p class="store-footer-link" style="cursor:default;">
                <i class="fas fa-map-marker-alt" style="margin-right:6px;font-size:10px;opacity:.6;"></i>
                <?= htmlspecialchars($storeData['city']) ?><?= !empty($storeData['country']) ? ', ' . htmlspecialchars($storeData['country']) : '' ?>
            </p>
            <?php endif; ?>
        </div>
        <div>
            <div class="store-footer-col-title">Legal</div>
            <a href="<?= htmlspecialchars($footer['terms_url'] ?? '#') ?>" class="store-footer-link">
                <i class="fas fa-file-alt" style="margin-right:6px;font-size:10px;opacity:.6;"></i>Términos y condiciones
            </a>
            <a href="<?= htmlspecialchars($footer['privacy_url'] ?? '#') ?>" class="store-footer-link">
                <i class="fas fa-lock" style="margin-right:6px;font-size:10px;opacity:.6;"></i>Política de privacidad
            </a>
        </div>
    </div>
    <div class="store-footer-bottom">
        <span>© <?= date('Y') ?> <?= htmlspecialchars($storeName) ?>. Todos los derechos reservados.</span>
        <span class="store-footer-powered">Impulsado por <a href="<?= BASE_URL ?>" target="_blank">Kyros Commerce</a></span>
    </div>
</footer>

<!-- Floating WhatsApp Button -->
<?php if ($hasWhatsApp): ?>
<a href="<?= Helper::getWhatsAppLink($storeData['whatsapp_number']) ?>"
   target="_blank" rel="noopener"
   class="float-wa-btn" aria-label="Contactar por WhatsApp">
    <i class="fab fa-whatsapp"></i>
    <span class="float-wa-tooltip">¿Necesitas ayuda?</span>
</a>
<?php endif; ?>

<!-- Mobile menu overlay -->
<div class="store-mobile-overlay" id="storeMobileOverlay" onclick="closeStoreMenu()"></div>
<div class="store-mobile-drawer" id="storeMobileDrawer">
    <div class="store-mobile-head">
        <span class="store-name-mob"><?= htmlspecialchars($storeName) ?></span>
        <button class="store-mobile-close" onclick="closeStoreMenu()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="store-mobile-body">
        <!-- Mobile search -->
        <form method="GET" action="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>" style="margin-bottom:8px;">
            <div style="position:relative;">
                <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:12px;pointer-events:none;"></i>
                <input type="search" name="q" placeholder="Buscar productos..."
                       value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                       style="width:100%;box-sizing:border-box;padding:11px 14px 11px 36px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;font-family:'Inter',sans-serif;color:#1e293b;outline:none;">
            </div>
        </form>
        <div class="store-mobile-divider"></div>
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>" class="store-mobile-link">
            <i class="fas fa-home"></i> Inicio
        </a>
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>/cart" class="store-mobile-link">
            <i class="fas fa-shopping-bag"></i> Mi Carrito
        </a>
        <?php if ($isCustomerInThisStore): ?>
        <a href="<?= BASE_URL ?>customer/panel" class="store-mobile-link">
            <i class="fas fa-user"></i> Mi cuenta
        </a>
        <a href="<?= BASE_URL ?>customer/logout" class="store-mobile-link" style="color:#dc2626;">
            <i class="fas fa-sign-out-alt" style="color:#dc2626;"></i> Cerrar sesión
        </a>
        <?php else: ?>
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>/customer/login" class="store-mobile-link">
            <i class="fas fa-sign-in-alt"></i> Ingresar
        </a>
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeSlug) ?>/customer/register" class="store-mobile-link">
            <i class="fas fa-user-plus"></i> Crear cuenta
        </a>
        <?php endif; ?>
        <?php foreach ($menuLinks as $item): ?>
            <?php if (!empty($item['label']) && !empty($item['url'])): ?>
            <a href="<?= htmlspecialchars($item['url']) ?>" class="store-mobile-link">
                <i class="fas fa-link"></i> <?= htmlspecialchars($item['label']) ?>
            </a>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($hasWhatsApp): ?>
        <div class="store-mobile-divider"></div>
        <a href="<?= Helper::getWhatsAppLink($storeData['whatsapp_number']) ?>" target="_blank" rel="noopener" class="store-mobile-wa-btn">
            <i class="fab fa-whatsapp" style="font-size:18px;"></i> Contactar por WhatsApp
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- Toast container -->
<div id="toastContainer"></div>

<script src="<?= ASSETS_PATH ?>js/script.js"></script>
<script>
/* ── Mobile menu ── */
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

/* ── Scroll progress ── */
(function() {
    const bar = document.getElementById('scrollProgress');
    const nav = document.getElementById('storeNav');
    if (!bar && !nav) return;
    function onScroll() {
        const scrolled = window.scrollY;
        const total = document.documentElement.scrollHeight - window.innerHeight;
        if (bar && total > 0) bar.style.width = (scrolled / total * 100) + '%';
        if (nav) nav.classList.toggle('scrolled', scrolled > 12);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
})();

/* ── Scroll reveal (IntersectionObserver) ── */
(function() {
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -32px 0px' });

    /* Observe all elements with .reveal class */
    document.querySelectorAll('.reveal').forEach(function(el) {
        observer.observe(el);
    });

    /* Auto-apply reveal to product cards */
    document.querySelectorAll('.sf-card').forEach(function(el, i) {
        el.classList.add('reveal');
        const delay = Math.min(i % 4, 5);
        if (delay > 0) el.classList.add('reveal-delay-' + delay);
        observer.observe(el);
    });
})();

/* ── Cart badge init from session ── */
(function loadCartCount() {
    fetch('<?= BASE_URL ?>api/cart/count')
        .then(function(r) { return r.ok ? r.json() : null; })
        .then(function(data) {
            if (data && data.count !== undefined) {
                const badge = document.getElementById('cart-count');
                if (badge) badge.textContent = data.count;
            }
        })
        .catch(function() {});
})();
</script>
</body>
</html>
