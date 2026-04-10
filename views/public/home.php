<?php
$page_title = "Kyros Commerce — Crea tu Tienda Online Profesional";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <meta name="description" content="Kyros Commerce es la plataforma SaaS para crear y gestionar tu tienda online sin complicaciones técnicas.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/style.css">
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/mobile-pro.css">
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #86efac, #fde68a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-v2 {
            background: linear-gradient(135deg, #0c1f12 0%, #1a4a2e 40%, #2a7a52 80%, #1d6b46 100%);
            position: relative;
            overflow: hidden;
            padding: 100px 0 120px;
        }
        .hero-v2::before {
            content: '';
            position: absolute;
            top: -20%; right: -10%;
            width: 700px; height: 700px;
            background: radial-gradient(circle, rgba(212,151,58,0.15) 0%, transparent 65%);
            border-radius: 50%;
        }
        .hero-v2::after {
            content: '';
            position: absolute;
            bottom: -20%; left: -10%;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(42,122,82,0.3) 0%, transparent 65%);
            border-radius: 50%;
        }

        .nav-link-home {
            font-size: 14px; font-weight: 500; color: #475569;
            padding: 6px 12px; border-radius: 8px; text-decoration: none; transition: all .15s;
        }
        .nav-link-home:hover { background: #f0fdf4; color: #2a7a52; }

        .feature-card-v2 {
            background: #fff;
            border: 1.5px solid #e8f5ee;
            border-radius: 20px;
            padding: 32px;
            transition: all .3s cubic-bezier(.4,0,.2,1);
            position: relative; overflow: hidden;
        }
        .feature-card-v2::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, #2a7a52, #d4973a);
            opacity: 0; transition: opacity .3s;
        }
        .feature-card-v2:hover { box-shadow: 0 20px 40px rgba(26,122,74,.12); transform: translateY(-6px); border-color: #b7e4c7; }
        .feature-card-v2:hover::before { opacity: 1; }

        .feature-icon-v2 {
            width: 60px; height: 60px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; margin-bottom: 20px;
        }

        .process-step { display: flex; gap: 24px; align-items: flex-start; position: relative; }
        .process-step:not(:last-child)::after {
            content: ''; position: absolute;
            left: 23px; top: 52px; width: 2px; height: calc(100% + 20px);
            background: linear-gradient(to bottom, rgba(42,122,82,.3), transparent);
        }
        .process-step-number {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            font-weight: 800;
            flex-shrink: 0;
        }
        .process-step-title {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
            line-height: 1.3;
        }
        .process-step-desc {
            font-size: 13.5px;
            color: #64748b;
            line-height: 1.6;
        }
        .home-process-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }
        .home-process-lead {
            font-size: 16px;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 40px;
            max-width: 62ch;
        }
        .home-process-steps {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .home-process-mobile-preview {
            display: none;
        }
        .home-process-mockup-shell {
            border-radius: 24px;
            padding: 32px;
        }
        .home-contact-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            max-width: 820px;
            margin: 0 auto;
        }
        .home-contact-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 18px;
            padding: 20px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            text-decoration: none;
            transition: all .2s ease;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
        }
        .home-contact-card:hover {
            border-color: #bbf7d0;
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(42, 122, 82, 0.14);
        }
        .home-contact-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }
        .home-contact-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.9px;
            font-weight: 700;
            color: #94a3b8;
            margin-bottom: 4px;
        }
        .home-contact-value {
            font-size: 17px;
            font-weight: 800;
            color: #1e293b;
            line-height: 1.25;
            margin-bottom: 3px;
            word-break: break-word;
        }
        .home-contact-note {
            font-size: 13px;
            color: #64748b;
            line-height: 1.45;
        }

        .integration-pill {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 9px 18px; background: #fff;
            border: 1.5px solid #e2e8f0; border-radius: 100px;
            font-size: 13px; font-weight: 600; color: #334155;
            box-shadow: 0 2px 8px rgba(0,0,0,.05);
            transition: all .15s;
        }
        .integration-pill:hover { border-color: #bbf7d0; box-shadow: 0 4px 14px rgba(42,122,82,.12); }

        .testimonial-v2 {
            background: #fff; border: 1.5px solid #e8f5ee;
            border-radius: 20px; padding: 32px;
            position: relative; transition: all .2s;
        }
        .testimonial-v2:hover { box-shadow: 0 12px 32px rgba(42,122,82,.1); transform: translateY(-4px); }
        .testimonial-v2::before {
            content: '"'; position: absolute;
            top: 14px; right: 22px; font-size: 80px; line-height: 1;
            color: #d1fae5; font-family: Georgia, serif;
        }

        .pricing-featured-v2 {
            background: linear-gradient(160deg, #ecfdf5 0%, #f0fdf4 100%) !important;
            border-color: #2a7a52 !important;
        }

        .cta-green {
            background: linear-gradient(135deg, #0c1f12 0%, #1a4a2e 50%, #0c1f12 100%);
            position: relative; overflow: hidden; padding: 100px 0;
        }
        .cta-green::before {
            content: ''; position: absolute;
            top: 50%; left: 50%; transform: translate(-50%,-50%);
            width: 800px; height: 400px;
            background: radial-gradient(ellipse, rgba(42,122,82,.25) 0%, transparent 70%);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .float-card  { animation: float 4s ease-in-out infinite; }
        .float-card-2 { animation: float 4s ease-in-out infinite 1.5s; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fadeInUp .6s ease-out both; }

        .home-compare-table { overflow: hidden; }
        .home-compare-head,
        .home-compare-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
        }

        @media (max-width: 768px) {
            .hero-v2 { padding: 72px 0 80px; }
            .grid-footer { grid-template-columns: 1fr 1fr !important; gap: 32px !important; }
            .process-step:not(:last-child)::after { display: none; }
            .home-process-grid {
                grid-template-columns: 1fr;
                gap: 28px;
            }
            .home-contact-grid {
                grid-template-columns: 1fr;
                max-width: 100%;
            }
            .home-process-mobile-preview {
                display: block;
                margin-top: 18px;
                border: 1px solid #dbe8e1;
                border-radius: 18px;
                overflow: hidden;
                background: #ffffff;
                box-shadow: 0 12px 26px rgba(15, 23, 42, 0.08);
            }
            .home-process-mobile-preview-head {
                background: linear-gradient(135deg, #0f2a19 0%, #1f5c3d 100%);
                padding: 10px 12px;
                color: #d1fae5;
                font-size: 11px;
                font-weight: 700;
                letter-spacing: 0.4px;
                text-transform: uppercase;
            }
            .home-process-mobile-preview-body {
                padding: 12px;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }
            .home-process-mobile-preview-card {
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 9px;
                background: #f8fafc;
            }
            .home-process-mobile-preview-thumb {
                height: 40px;
                border-radius: 8px;
                background: linear-gradient(135deg, #d1fae5 0%, #fef3c7 100%);
                margin-bottom: 8px;
            }
            .home-process-mobile-preview-name {
                font-size: 11px;
                font-weight: 700;
                color: #1e293b;
                line-height: 1.3;
            }
            .home-process-mobile-preview-price {
                font-size: 12px;
                font-weight: 800;
                color: #2a7a52;
                margin-top: 3px;
            }
        }

        @media (max-width: 1024px) {
            .home-process-mockup-shell {
                border-radius: 20px !important;
                padding: 24px !important;
            }
        }

        @media (max-width: 640px) {
            .home-nav-shell {
                padding: 0 16px !important;
                height: 58px !important;
            }
            .home-brand-text {
                font-size: 16px !important;
            }
            .hero-v2 {
                padding: 56px 0 64px;
            }
            .home-hero-shell {
                padding: 0 16px !important;
            }
            .home-hero-title {
                font-size: clamp(30px, 10vw, 42px) !important;
                letter-spacing: -1.2px !important;
                line-height: 1.1 !important;
            }
            .home-hero-sub {
                font-size: 15px !important;
                line-height: 1.6 !important;
                margin-bottom: 26px !important;
            }
            .home-hero-actions {
                display: grid !important;
                grid-template-columns: 1fr;
                gap: 10px !important;
            }
            .home-hero-actions a {
                width: 100%;
                justify-content: center;
            }
            .home-compare-table {
                max-width: 100% !important;
                border-radius: 16px !important;
            }
            .home-compare-head,
            .home-compare-row {
                grid-template-columns: minmax(0, 1fr) 62px 62px !important;
            }
            .home-compare-head-feature {
                padding: 12px 12px !important;
                font-size: 10px !important;
            }
            .home-compare-head-kyros,
            .home-compare-head-other {
                padding: 10px 8px !important;
            }
            .home-compare-head-kyros > div:first-child,
            .home-compare-head-other > div:first-child {
                font-size: 11px !important;
            }
            .home-compare-head-kyros > div:last-child {
                font-size: 9px !important;
            }
            .home-compare-feature {
                padding: 12px !important;
                font-size: 13px !important;
                line-height: 1.35;
            }
            .home-compare-kyros,
            .home-compare-other {
                padding: 12px 6px !important;
            }
            .home-compare-icon {
                font-size: 15px !important;
            }
            .home-cta-btn {
                width: 100%;
                justify-content: center;
                padding: 14px 20px !important;
                font-size: 15px !important;
            }
            .home-process-lead {
                font-size: 18px;
                line-height: 1.75;
                margin-bottom: 28px;
            }
            .home-process-steps {
                gap: 14px;
            }
            .process-step {
                gap: 14px;
                align-items: flex-start;
                padding: 14px 14px 14px 12px;
                border-radius: 18px;
                background: linear-gradient(160deg, #ffffff 0%, #f9fcfb 100%);
                border: 1px solid #e2ece7;
                box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            }
            .process-step-number {
                width: 56px;
                height: 56px;
                border-radius: 16px;
                font-size: 30px;
                line-height: 1;
            }
            .process-step-title {
                font-size: 18px;
                line-height: 1.3;
                margin-bottom: 6px;
                letter-spacing: -0.2px;
            }
            .process-step-desc {
                font-size: 16px;
                line-height: 1.7;
            }
        }

        @media (max-width: 480px) {
            .grid-footer { grid-template-columns: 1fr !important; }
            .feature-card-v2,
            .testimonial-v2 {
                padding: 22px;
                border-radius: 16px;
            }
            .home-brand-text {
                max-width: 155px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .home-process-grid {
                gap: 22px;
            }
            .home-process-lead {
                font-size: 15px;
                line-height: 1.65;
                margin-bottom: 22px;
            }
            .home-process-steps {
                gap: 12px;
            }
            .process-step {
                gap: 12px;
                padding: 12px 12px 12px 10px;
                border-radius: 16px;
            }
            .process-step-number {
                width: 42px;
                height: 42px;
                border-radius: 12px;
                font-size: 17px;
            }
            .process-step-title {
                font-size: 16px;
                line-height: 1.28;
                margin-bottom: 4px;
                letter-spacing: -0.1px;
            }
            .process-step-desc {
                font-size: 14px;
                line-height: 1.62;
            }
            .home-process-mobile-preview {
                margin-top: 14px;
                border-radius: 16px;
            }
            .home-process-mobile-preview-body {
                gap: 8px;
                padding: 10px;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .home-process-mobile-preview-card {
                padding: 8px;
            }
            .home-process-mobile-preview-thumb {
                height: 36px;
                margin-bottom: 7px;
            }
            .home-process-mobile-preview-name {
                font-size: 10.5px;
                line-height: 1.3;
            }
            .home-process-mobile-preview-price {
                font-size: 11px;
            }
            .home-contact-card {
                padding: 15px;
                border-radius: 14px;
                gap: 11px;
            }
            .home-contact-icon {
                width: 36px;
                height: 36px;
                border-radius: 10px;
                font-size: 15px;
            }
            .home-contact-value {
                font-size: 15px;
            }
            .home-contact-note {
                font-size: 12.5px;
            }
        }
    </style>
</head>
<body style="font-family:'Inter',sans-serif;background:#fff;color:#1e293b;">

<!-- =========== NAVBAR =========== -->
<nav style="position:sticky;top:0;z-index:150;background:rgba(255,255,255,0.97);backdrop-filter:blur(16px);border-bottom:1px solid #e2e8f0;">
    <div class="home-nav-shell" style="max-width:1200px;margin:0 auto;padding:0 24px;height:64px;display:flex;align-items:center;justify-content:space-between;">
        <!-- Logo -->
        <a href="<?= BASE_URL ?>" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
            <div style="width:34px;height:34px;background:linear-gradient(135deg,#2a7a52,#d4973a);border-radius:9px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:15px;color:#fff;letter-spacing:-0.5px;">K</div>
            <span class="home-brand-text" style="font-size:18px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Kyros Commerce</span>
        </a>

        <!-- Links (desktop) -->
        <div class="hidden md:flex items-center gap-1">
            <a href="#caracteristicas" class="nav-link-home">Características</a>
            <a href="#como-funciona" class="nav-link-home">Cómo funciona</a>
            <a href="#comparacion" class="nav-link-home">Por qué Kyros</a>
            <a href="#planes" class="nav-link-home">Precios</a>
            <a href="#contacto" class="nav-link-home">Contacto</a>
        </div>

        <!-- Auth (desktop) + Hamburger (mobile) -->
        <div style="display:flex;align-items:center;gap:8px;">
            <?php if (Auth::isLoggedIn()): ?>
                <span style="font-size:13.5px;font-weight:500;color:#64748b;" class="hidden md:inline"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                <?php if (Auth::isSuperAdmin()): ?>
                    <a href="<?= BASE_URL ?>superadmin/dashboard" style="font-size:13.5px;font-weight:600;color:#2a7a52;padding:7px 14px;border-radius:8px;border:1.5px solid #bbf7d0;background:#ecfdf5;text-decoration:none;" class="hidden md:inline-flex">Dashboard</a>
                <?php elseif (Auth::isStoreOwner()): ?>
                    <a href="<?= BASE_URL ?>admin/dashboard" style="font-size:13.5px;font-weight:600;color:#2a7a52;padding:7px 14px;border-radius:8px;border:1.5px solid #bbf7d0;background:#ecfdf5;text-decoration:none;" class="hidden md:inline-flex">Mi Tienda</a>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>auth/logout" style="font-size:13.5px;font-weight:600;color:#ef4444;padding:7px 14px;border-radius:8px;border:1.5px solid #fecaca;background:#fef2f2;text-decoration:none;" class="hidden md:inline-flex">Salir</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>auth/login" style="font-size:13.5px;font-weight:600;color:#475569;padding:7px 14px;border-radius:8px;border:1.5px solid #e2e8f0;background:#fff;text-decoration:none;transition:all .15s;" class="hidden md:inline-flex">Iniciar sesión</a>
                <a href="<?= BASE_URL ?>auth/register" style="font-size:13.5px;font-weight:700;color:#fff;padding:8px 18px;border-radius:9px;background:linear-gradient(135deg,#2a7a52,#1f5c3d);text-decoration:none;box-shadow:0 4px 14px rgba(42,122,82,0.35);transition:all .15s;" class="hidden md:inline-flex">Empezar gratis</a>
            <?php endif; ?>
            <button id="homeMenuBtn" class="mobile-menu-btn md:hidden" aria-label="Abrir menú">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile nav overlay -->
<div id="homeNavOverlay" class="mobile-nav-overlay" onclick="closeHomeNav()"></div>

<!-- Mobile nav drawer -->
<div id="homeNavDrawer" class="mobile-nav-drawer">
    <div class="mobile-nav-header">
        <div style="display:flex;align-items:center;gap:9px;">
            <div style="width:30px;height:30px;background:linear-gradient(135deg,#2a7a52,#d4973a);border-radius:8px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:13px;color:#fff;">K</div>
            <span style="font-size:16px;font-weight:800;color:#1e293b;">Kyros Commerce</span>
        </div>
        <button class="mobile-nav-close" onclick="closeHomeNav()"><i class="fas fa-times"></i></button>
    </div>
    <div class="mobile-nav-links">
        <a href="#caracteristicas" class="mobile-nav-link" onclick="closeHomeNav()"><i class="fas fa-star"></i> Características</a>
        <a href="#como-funciona" class="mobile-nav-link" onclick="closeHomeNav()"><i class="fas fa-play-circle"></i> Cómo funciona</a>
        <a href="#comparacion" class="mobile-nav-link" onclick="closeHomeNav()"><i class="fas fa-balance-scale"></i> Por qué Kyros</a>
        <a href="#planes" class="mobile-nav-link" onclick="closeHomeNav()"><i class="fas fa-tag"></i> Precios</a>
        <a href="#contacto" class="mobile-nav-link" onclick="closeHomeNav()"><i class="fas fa-envelope"></i> Contacto</a>
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

<!-- =========== HERO =========== -->
<section class="hero-v2">
    <div class="home-hero-shell" style="max-width:1200px;margin:0 auto;padding:0 24px;position:relative;z-index:1;">
        <div class="grid md:grid-cols-2 gap-14 items-center">
            <div class="fade-in-up">
                <!-- Badge -->
                <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.22);border-radius:100px;padding:6px 16px;margin-bottom:28px;">
                    <span style="width:6px;height:6px;background:#fde68a;border-radius:50%;display:inline-block;animation:pulse 2s ease-in-out infinite;"></span>
                    <span style="color:rgba(255,255,255,0.85);font-size:12.5px;font-weight:600;letter-spacing:.3px;">Plataforma SaaS de E-commerce #1 en Latam</span>
                </div>

                <h1 class="home-hero-title" style="font-size:clamp(36px,5vw,58px);font-weight:900;color:#fff;line-height:1.08;letter-spacing:-2px;margin-bottom:22px;">
                    Vende más,<br>
                    trabaja menos.<br>
                    <span class="gradient-text">Crece sin límites.</span>
                </h1>

                <p class="home-hero-sub" style="font-size:18px;color:rgba(255,255,255,0.72);line-height:1.75;margin-bottom:38px;max-width:500px;">
                    Kyros Commerce te da todo lo que necesitas para lanzar, crecer y escalar tu tienda online. Sin código, sin complicaciones.
                </p>

                <div class="home-hero-actions" style="display:flex;flex-wrap:wrap;gap:14px;margin-bottom:32px;">
                    <a href="<?= BASE_URL ?>auth/register"
                       style="display:inline-flex;align-items:center;gap:9px;background:#d4973a;color:#fff;padding:14px 28px;border-radius:12px;font-size:15px;font-weight:700;text-decoration:none;box-shadow:0 4px 20px rgba(212,151,58,.4);transition:all .2s;"
                       onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px rgba(212,151,58,.5)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 20px rgba(212,151,58,.4)'">
                        <i class="fas fa-rocket"></i> Comenzar Gratis
                    </a>
                    <a href="#como-funciona"
                       style="display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,0.12);color:#fff;padding:14px 24px;border-radius:12px;font-size:15px;font-weight:600;text-decoration:none;border:1.5px solid rgba(255,255,255,0.25);transition:all .2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.18)'" onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                        <i class="fas fa-play-circle"></i> Ver demo
                    </a>
                </div>

                <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                    <?php foreach (['15 días gratis', 'Sin tarjeta de crédito', 'Cancela cuando quieras'] as $t): ?>
                    <div style="display:flex;align-items:center;gap:7px;color:rgba(255,255,255,0.65);font-size:13px;">
                        <i class="fas fa-check-circle" style="color:#86efac;font-size:12px;"></i>
                        <?= $t ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Hero visual -->
            <div class="hidden md:block fade-in-up" style="animation-delay:0.2s;position:relative;">
                <div class="float-card" style="background:rgba(255,255,255,0.09);border:1px solid rgba(255,255,255,0.15);border-radius:24px;padding:24px;backdrop-filter:blur(12px);">
                    <!-- Topbar -->
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                        <div>
                            <div style="color:rgba(255,255,255,0.5);font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px;">Resumen del Día</div>
                            <div style="color:rgba(255,255,255,0.85);font-size:13px;font-weight:700;">Viernes 10 Abril, 2026</div>
                        </div>
                        <div style="background:rgba(134,239,172,0.15);border:1px solid rgba(134,239,172,0.3);border-radius:20px;padding:4px 12px;color:#86efac;font-size:11px;font-weight:700;">
                            <i class="fas fa-circle" style="font-size:6px;margin-right:4px;"></i> En línea
                        </div>
                    </div>
                    <!-- Revenue -->
                    <div style="background:rgba(255,255,255,0.07);border-radius:16px;padding:20px;margin-bottom:14px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                            <div style="color:rgba(255,255,255,0.65);font-size:12px;font-weight:600;">Ingresos del mes</div>
                            <div style="color:#86efac;font-size:12px;font-weight:700;background:rgba(134,239,172,0.15);padding:3px 10px;border-radius:20px;">↑ 32%</div>
                        </div>
                        <div style="font-size:36px;font-weight:900;color:#fff;letter-spacing:-1.5px;margin-bottom:14px;">$12,480</div>
                        <!-- Bar chart -->
                        <div style="display:flex;align-items:flex-end;gap:4px;height:44px;">
                            <?php
                            $bars   = [30,50,40,65,55,75,90,70,82,95,88,100];
                            $alphas = [.12,.16,.14,.2,.18,.25,.32,.22,.28,.36,.3,1];
                            foreach ($bars as $i => $h): ?>
                            <div style="flex:1;background:<?= $i===11 ? 'rgba(212,151,58,.9)' : 'rgba(134,239,172,'.$alphas[$i].')' ?>;border-radius:3px 3px 0 0;height:<?= $h ?>%;"></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- KPI grid -->
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
                        <?php foreach ([
                            ['icon'=>'fas fa-shopping-bag','label'=>'Órdenes','value'=>'247','color'=>'#86efac'],
                            ['icon'=>'fas fa-box',         'label'=>'Productos','value'=>'156','color'=>'#fde68a'],
                            ['icon'=>'fas fa-users',       'label'=>'Clientes', 'value'=>'2.4K','color'=>'#93c5fd'],
                        ] as $kpi): ?>
                        <div style="background:rgba(255,255,255,0.07);border-radius:12px;padding:14px;text-align:center;">
                            <i class="<?= $kpi['icon'] ?>" style="color:<?= $kpi['color'] ?>;font-size:16px;margin-bottom:6px;display:block;"></i>
                            <div style="color:rgba(255,255,255,0.5);font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px;"><?= $kpi['label'] ?></div>
                            <div style="color:#fff;font-size:17px;font-weight:800;"><?= $kpi['value'] ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- Floating notification -->
                <div class="float-card-2" style="position:absolute;right:-18px;bottom:50px;background:#fff;border-radius:14px;padding:13px 18px;box-shadow:0 12px 40px rgba(0,0,0,.22);display:flex;align-items:center;gap:12px;min-width:210px;z-index:10;">
                    <div style="width:36px;height:36px;background:linear-gradient(135deg,#2a7a52,#1f5c3d);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-bell" style="color:#fff;font-size:13px;"></i>
                    </div>
                    <div>
                        <div style="font-size:12px;font-weight:700;color:#1e293b;">Nueva orden recibida</div>
                        <div style="font-size:11px;color:#94a3b8;margin-top:1px;">Tenis Nike Air Max — $89.00</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========== TRUST / INTEGRATIONS BAR =========== -->
<section style="background:#f8fafc;border-bottom:1px solid #e2e8f0;padding:22px 0;">
    <div style="max-width:1200px;margin:0 auto;padding:0 24px;display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:12px;">
        <span style="font-size:11.5px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:1.2px;margin-right:8px;">Funciona con</span>
        <?php foreach ([
            ['icon'=>'fab fa-whatsapp',      'name'=>'WhatsApp',    'color'=>'#25D366'],
            ['icon'=>'fab fa-instagram',     'name'=>'Instagram',   'color'=>'#E1306C'],
            ['icon'=>'fas fa-credit-card',   'name'=>'Pagos Online','color'=>'#635bff'],
            ['icon'=>'fas fa-map-marker-alt','name'=>'Envíos',      'color'=>'#f59e0b'],
            ['icon'=>'fas fa-chart-bar',     'name'=>'Analytics',   'color'=>'#3b82f6'],
            ['icon'=>'fas fa-shield-alt',    'name'=>'SSL Gratis',  'color'=>'#2a7a52'],
        ] as $int): ?>
        <div class="integration-pill">
            <i class="<?= $int['icon'] ?>" style="color:<?= $int['color'] ?>;font-size:14px;"></i>
            <span><?= $int['name'] ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- =========== STATS =========== -->
<section style="background:#0c1f12;padding:60px 0;">
    <div style="max-width:1100px;margin:0 auto;padding:0 24px;">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:0;">
            <?php foreach ([
                ['value'=>'+5,000','label'=>'Tiendas activas',    'icon'=>'fas fa-store',    'color'=>'#86efac'],
                ['value'=>'$2M+',  'label'=>'Ventas procesadas',  'icon'=>'fas fa-dollar-sign','color'=>'#fde68a'],
                ['value'=>'99.9%', 'label'=>'Uptime garantizado', 'icon'=>'fas fa-server',   'color'=>'#93c5fd'],
                ['value'=>'4.9★',  'label'=>'Calificación prom.', 'icon'=>'fas fa-star',     'color'=>'#fca5a5'],
                ['value'=>'24/7',  'label'=>'Soporte disponible', 'icon'=>'fas fa-headset',  'color'=>'#d8b4fe'],
            ] as $s): ?>
            <div style="text-align:center;padding:24px 16px;">
                <div style="width:48px;height:48px;background:rgba(255,255,255,.06);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                    <i class="<?= $s['icon'] ?>" style="color:<?= $s['color'] ?>;font-size:18px;"></i>
                </div>
                <div style="font-size:30px;font-weight:900;color:#fff;letter-spacing:-1px;line-height:1.1;"><?= $s['value'] ?></div>
                <div style="font-size:12.5px;color:#4b7a5c;font-weight:500;margin-top:5px;"><?= $s['label'] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- =========== CARACTERÍSTICAS =========== -->
<section class="section" id="caracteristicas" style="background:#fff;">
    <div class="section-inner">
        <div class="text-center" style="margin-bottom:64px;">
            <div class="section-label"><i class="fas fa-leaf"></i> Características</div>
            <h2 class="section-title">Todo lo que necesitas para vender online</h2>
            <p class="section-subtitle">Una plataforma completa con carrito, portal de clientes y automatizaciones para crecer desde el primer día.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <?php
            $features = [
                ['icon'=>'fas fa-shopping-cart','bg'=>'#ecfdf5','color'=>'#2a7a52','title'=>'Carrito de Compras Avanzado',   'desc'=>'Carrito robusto y seguro con múltiples opciones. Tus clientes compran sin fricción, en segundos.'],
                ['icon'=>'fab fa-whatsapp',     'bg'=>'#f0fdf4','color'=>'#16a34a','title'=>'Contacto por wa.me',            'desc'=>'Comparte enlaces wa.me para que tus clientes te escriban y coordinen su compra rápidamente.'],
                ['icon'=>'fas fa-images',       'bg'=>'#fefce8','color'=>'#d97706','title'=>'Galerías de Productos HD',       'desc'=>'Sube fotos de alta calidad sin límite. Muestra tu catálogo de manera profesional y atractiva.'],
                ['icon'=>'fas fa-users-cog',    'bg'=>'#eff6ff','color'=>'#2563eb','title'=>'Portal de Clientes',            'desc'=>'Tus compradores crean cuenta por tienda, gestionan perfil, direcciones y revisan su historial de pedidos.'],
                ['icon'=>'fas fa-mobile-alt',   'bg'=>'#fdf4ff','color'=>'#9333ea','title'=>'100% Responsivo',               'desc'=>'Tu tienda luce perfecta en todos los dispositivos: desktop, tablet y smartphones modernos.'],
                ['icon'=>'fas fa-box',          'bg'=>'#fff7ed','color'=>'#ea580c','title'=>'Gestión de Inventario',         'desc'=>'Controla tu stock en tiempo real. Recibe alertas de stock bajo y evita vender lo que no tienes.'],
                ['icon'=>'fas fa-chart-line',   'bg'=>'#ecfeff','color'=>'#0891b2','title'=>'Analytics en Tiempo Real',      'desc'=>'Visualiza ventas, clientes recurrentes y productos más vendidos. Métricas claras para tomar mejores decisiones.'],
                ['icon'=>'fas fa-search',       'bg'=>'#f0fdf4','color'=>'#059669','title'=>'SEO Optimizado',                'desc'=>'Tu tienda está optimizada para aparecer en Google. Atrae tráfico orgánico sin esfuerzo extra.'],
                ['icon'=>'fas fa-lock',         'bg'=>'#fef2f2','color'=>'#dc2626','title'=>'Seguridad SSL Incluida',        'desc'=>'Certificado SSL gratuito en todos los planes. Tus clientes compran con total confianza y seguridad.'],
                ['icon'=>'fas fa-headset',      'bg'=>'#f8fafc','color'=>'#475569','title'=>'Soporte en Español 24/7',       'desc'=>'Nuestro equipo siempre disponible en tu idioma para ayudarte con cualquier duda o problema.'],
            ];
            foreach ($features as $i => $f): ?>
            <div class="feature-card-v2 fade-in-up" style="animation-delay:<?= $i * 0.06 ?>s;">
                <div class="feature-icon-v2" style="background:<?= $f['bg'] ?>;color:<?= $f['color'] ?>;">
                    <i class="<?= $f['icon'] ?>"></i>
                </div>
                <h3 style="font-size:16px;font-weight:700;color:#1e293b;margin-bottom:9px;"><?= $f['title'] ?></h3>
                <p style="font-size:14px;color:#64748b;line-height:1.65;"><?= $f['desc'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- =========== CÓMO FUNCIONA =========== -->
<section class="section" id="como-funciona" style="background:#f8fafc;">
    <div class="section-inner">
        <div class="home-process-grid">
            <div>
                <div class="section-label" style="margin-bottom:14px;"><i class="fas fa-route"></i> Proceso</div>
                <h2 class="section-title" style="text-align:left;margin-bottom:16px;">De 0 a ventas<br>en 4 pasos simples</h2>
                <p class="home-process-lead">No necesitas experiencia técnica. En menos de 15 minutos tienes tu tienda lista para recibir pedidos.</p>

                <div class="home-process-steps">
                    <?php
                    $steps = [
                        ['num'=>1,'title'=>'Crea tu cuenta',       'desc'=>'Regístrate en menos de 2 minutos. Solo necesitas tu correo electrónico.', 'color'=>'#2a7a52'],
                        ['num'=>2,'title'=>'Personaliza tu tienda','desc'=>'Sube tu logo, elige colores de marca y configura tu nombre de tienda.',    'color'=>'#d4973a'],
                        ['num'=>3,'title'=>'Sube tus productos',   'desc'=>'Agrega productos con fotos, precios y descripciones. Fácil e intuitivo.',  'color'=>'#2563eb'],
                        ['num'=>4,'title'=>'Comparte y vende',     'desc'=>'Comparte el link de tu tienda por WhatsApp, Instagram o redes sociales.',  'color'=>'#9333ea'],
                    ];
                    foreach ($steps as $i => $step): ?>
                    <div class="process-step fade-in-up" style="animation-delay:<?= $i * 0.1 ?>s;">
                        <div class="process-step-number" style="background:<?= $step['color'] ?>;">
                            <?= $step['num'] ?>
                        </div>
                        <div>
                            <h3 class="process-step-title"><?= $step['title'] ?></h3>
                            <p class="process-step-desc"><?= $step['desc'] ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="home-process-mobile-preview">
                    <div class="home-process-mobile-preview-head">Vista previa de tu tienda</div>
                    <div class="home-process-mobile-preview-body">
                        <div class="home-process-mobile-preview-card">
                            <div class="home-process-mobile-preview-thumb"></div>
                            <div class="home-process-mobile-preview-name">Producto Premium</div>
                            <div class="home-process-mobile-preview-price">$49.99</div>
                        </div>
                        <div class="home-process-mobile-preview-card">
                            <div class="home-process-mobile-preview-thumb"></div>
                            <div class="home-process-mobile-preview-name">Oferta del Dia</div>
                            <div class="home-process-mobile-preview-price">$19.99</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store mockup -->
            <div class="hidden md:block">
                <div class="home-process-mockup-shell" style="background:linear-gradient(135deg,#0c1f12,#1a4a2e);border-radius:24px;padding:32px;position:relative;">
                    <!-- Browser chrome -->
                    <div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:16px;overflow:hidden;">
                        <div style="background:rgba(255,255,255,.08);padding:10px 16px;display:flex;align-items:center;gap:6px;border-bottom:1px solid rgba(255,255,255,.08);">
                            <div style="width:8px;height:8px;border-radius:50%;background:#ff5f57;"></div>
                            <div style="width:8px;height:8px;border-radius:50%;background:#febc2e;"></div>
                            <div style="width:8px;height:8px;border-radius:50%;background:#28c840;"></div>
                            <div style="flex:1;background:rgba(255,255,255,.08);border-radius:20px;height:22px;margin:0 12px;display:flex;align-items:center;padding:0 12px;">
                                <i class="fas fa-lock" style="color:rgba(255,255,255,.3);font-size:9px;margin-right:6px;"></i>
                                <div style="font-size:10px;color:rgba(255,255,255,.35);">mitienda.kyros.com</div>
                            </div>
                        </div>
                        <div style="padding:20px;">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                                <div style="font-size:13px;font-weight:700;color:rgba(255,255,255,.8);">Mi Tienda Online</div>
                                <div style="background:#d4973a;border-radius:6px;padding:4px 10px;font-size:10px;font-weight:700;color:#fff;">Carrito (3)</div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                                <?php foreach ([
                                    ['name'=>'Producto Premium','price'=>'$49.99','bg'=>'#1a4a2e'],
                                    ['name'=>'Artículo Especial','price'=>'$29.99','bg'=>'#2a5a3c'],
                                    ['name'=>'Oferta del Día',  'price'=>'$19.99','bg'=>'#1f4a2c'],
                                    ['name'=>'Pack Bundle',     'price'=>'$89.99','bg'=>'#163d22'],
                                ] as $p): ?>
                                <div style="background:<?= $p['bg'] ?>;border:1px solid rgba(255,255,255,.1);border-radius:10px;padding:12px;">
                                    <div style="width:100%;height:48px;background:rgba(255,255,255,.07);border-radius:7px;margin-bottom:8px;"></div>
                                    <div style="font-size:10px;font-weight:600;color:rgba(255,255,255,.65);margin-bottom:3px;"><?= $p['name'] ?></div>
                                    <div style="font-size:12px;font-weight:800;color:#fde68a;"><?= $p['price'] ?></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Active badge -->
                    <div style="position:absolute;top:-14px;right:-14px;background:#fff;border-radius:12px;padding:10px 16px;box-shadow:0 8px 24px rgba(0,0,0,.2);display:flex;align-items:center;gap:8px;">
                        <div style="width:28px;height:28px;background:#ecfdf5;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-check" style="color:#2a7a52;font-size:12px;"></i>
                        </div>
                        <div>
                            <div style="font-size:11px;font-weight:700;color:#1e293b;">Tienda activa</div>
                            <div style="font-size:10px;color:#94a3b8;">Lista para vender</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========== POR QUÉ KYROS =========== -->
<section class="section" id="comparacion" style="background:#fff;">
    <div class="section-inner">
        <div class="text-center" style="margin-bottom:60px;">
            <div class="section-label"><i class="fas fa-trophy"></i> Por qué Kyros</div>
            <h2 class="section-title">Diseñado para emprendedores<br>que quieren resultados reales</h2>
            <p class="section-subtitle">Comparado con otras plataformas, Kyros Commerce te da más por menos — en español y sin comisiones.</p>
        </div>

        <div class="home-compare-table" style="max-width:780px;margin:0 auto;border:1.5px solid #e2e8f0;border-radius:20px;overflow:hidden;box-shadow:var(--shadow-lg);">
            <!-- Table header -->
            <div class="home-compare-head" style="display:grid;grid-template-columns:2fr 1fr 1fr;background:#f8fafc;border-bottom:2px solid #e2e8f0;">
                <div class="home-compare-head-feature" style="padding:16px 20px;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;">Característica</div>
                <div class="home-compare-head-kyros" style="padding:16px 20px;text-align:center;background:#ecfdf5;border-left:1px solid #d1fae5;">
                    <div style="font-size:13px;font-weight:800;color:#2a7a52;">Kyros</div>
                    <div style="font-size:10px;color:#86efac;font-weight:600;margin-top:2px;">★ Recomendado</div>
                </div>
                <div class="home-compare-head-other" style="padding:16px 20px;text-align:center;border-left:1px solid #e2e8f0;">
                    <div style="font-size:13px;font-weight:700;color:#94a3b8;">Otros</div>
                </div>
            </div>
            <?php
            $compare = [
                ['feat'=>'Configuración sin código',    'kyros'=>true,  'other'=>false],
                ['feat'=>'Enlaces wa.me para contacto', 'kyros'=>true,  'other'=>false],
                ['feat'=>'SSL gratuito incluido',       'kyros'=>true,  'other'=>true],
                ['feat'=>'Sin comisiones por venta',    'kyros'=>true,  'other'=>false],
                ['feat'=>'Soporte en español 24/7',     'kyros'=>true,  'other'=>false],
                ['feat'=>'15 días de prueba gratis',    'kyros'=>true,  'other'=>false],
                ['feat'=>'Panel multitienda incluido',  'kyros'=>true,  'other'=>true],
                ['feat'=>'Portal de clientes por tienda','kyros'=>true,  'other'=>false],
                ['feat'=>'Analytics integrado',         'kyros'=>true,  'other'=>true],
            ];
            foreach ($compare as $i => $row): ?>
            <div class="home-compare-row" style="display:grid;grid-template-columns:2fr 1fr 1fr;border-top:1px solid #f1f5f9;background:<?= $i%2===0 ? '#fff' : '#fafafa' ?>;">
                <div class="home-compare-feature" style="padding:14px 20px;font-size:14px;color:#334155;font-weight:500;"><?= $row['feat'] ?></div>
                <div class="home-compare-kyros" style="padding:14px 20px;text-align:center;background:rgba(236,253,245,.5);border-left:1px solid #d1fae5;">
                    <i class="home-compare-icon fas fa-<?= $row['kyros'] ? 'check-circle' : 'times-circle' ?>" style="color:<?= $row['kyros'] ? '#2a7a52' : '#fca5a5' ?>;font-size:16px;"></i>
                </div>
                <div class="home-compare-other" style="padding:14px 20px;text-align:center;border-left:1px solid #f1f5f9;">
                    <i class="home-compare-icon fas fa-<?= $row['other'] ? 'check-circle' : 'times-circle' ?>" style="color:<?= $row['other'] ? '#94a3b8' : '#fca5a5' ?>;font-size:16px;"></i>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- =========== PLANES =========== -->
<section class="section" id="planes" style="background:#f8fafc;">
    <div class="section-inner">
        <div class="text-center" style="margin-bottom:64px;">
            <div class="section-label"><i class="fas fa-tags"></i> Precios</div>
            <h2 class="section-title">Planes para cada etapa de tu negocio</h2>
            <p class="section-subtitle">Empieza gratis y escala cuando lo necesites. Todos los planes incluyen portal de clientes.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 items-start">

            <!-- Starter -->
            <div class="pricing-card fade-in-up" style="animation-delay:0s;">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#64748b;margin-bottom:6px;">Starter</div>
                <div style="font-size:44px;font-weight:900;color:#1e293b;letter-spacing:-2px;line-height:1.05;margin-bottom:6px;">
                    $0<span style="font-size:15px;font-weight:500;color:#94a3b8;letter-spacing:0;">/mes</span>
                </div>
                <div style="font-size:12.5px;color:#94a3b8;margin-bottom:24px;">Perfecto para comenzar</div>
                <hr style="border-color:#f1f5f9;margin-bottom:24px;">
                <ul style="list-style:none;margin-bottom:28px;display:flex;flex-direction:column;gap:10px;">
                    <?php foreach (['50 productos activos','5 GB de almacenamiento','Portal de clientes (perfil, direcciones y pedidos)','Módulo de Inventario','Carrito de compras','Contacto por wa.me','Soporte por email'] as $feat): ?>
                    <li style="display:flex;align-items:center;gap:10px;font-size:14px;color:#334155;">
                        <i class="fas fa-check-circle" style="color:#2a7a52;font-size:13px;flex-shrink:0;"></i><?= $feat ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?= BASE_URL ?>auth/register?plan=starter"
                   style="display:block;text-align:center;padding:13px;border-radius:10px;border:1.5px solid #d1d5db;color:#374151;font-weight:700;font-size:14px;text-decoration:none;transition:all .15s;"
                   onmouseover="this.style.background='#f9fafb';this.style.borderColor='#9ca3af'" onmouseout="this.style.background='transparent';this.style.borderColor='#d1d5db'">
                    Comenzar gratis
                </a>
            </div>

            <!-- Professional (featured) -->
            <div class="pricing-card pricing-featured-v2 fade-in-up" style="animation-delay:0.08s;transform:scale(1.04);">
                <div class="pricing-badge">★ MÁS POPULAR</div>
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#2a7a52;margin-bottom:6px;">Professional</div>
                <div style="font-size:44px;font-weight:900;color:#1e293b;letter-spacing:-2px;line-height:1.05;margin-bottom:6px;">
                    $99<span style="font-size:15px;font-weight:500;color:#94a3b8;letter-spacing:0;">/mes</span>
                </div>
                <div style="font-size:12.5px;color:#94a3b8;margin-bottom:24px;">Primeros 30 días con 50% off</div>
                <hr style="border-color:#bbf7d0;margin-bottom:24px;">
                <ul style="list-style:none;margin-bottom:28px;display:flex;flex-direction:column;gap:10px;">
                    <?php foreach (['500 productos activos','50 GB almacenamiento','Portal de clientes + checkout autocompletado','Módulo de Inventario','Módulo de Finanzas','Carrito avanzado + upsell','Analytics completo','SEO avanzado','API REST acceso','Soporte prioritario'] as $feat): ?>
                    <li style="display:flex;align-items:center;gap:10px;font-size:14px;color:#334155;">
                        <i class="fas fa-check-circle" style="color:#2a7a52;font-size:13px;flex-shrink:0;"></i><?= $feat ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?= BASE_URL ?>auth/register?plan=professional"
                   style="display:block;text-align:center;padding:14px;border-radius:11px;background:linear-gradient(135deg,#2a7a52,#1f5c3d);color:#fff;font-weight:700;font-size:14px;text-decoration:none;box-shadow:0 4px 18px rgba(42,122,82,.4);transition:all .2s;"
                   onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px rgba(42,122,82,.5)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 18px rgba(42,122,82,.4)'">
                    Comenzar Ahora
                </a>
            </div>

            <!-- Enterprise -->
            <div class="pricing-card fade-in-up" style="animation-delay:0.16s;">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#64748b;margin-bottom:6px;">Enterprise</div>
                <div style="font-size:44px;font-weight:900;color:#1e293b;letter-spacing:-2px;line-height:1.05;margin-bottom:6px;">
                    $299<span style="font-size:15px;font-weight:500;color:#94a3b8;letter-spacing:0;">/mes</span>
                </div>
                <div style="font-size:12.5px;color:#94a3b8;margin-bottom:24px;">Para grandes operaciones</div>
                <hr style="border-color:#f1f5f9;margin-bottom:24px;">
                <ul style="list-style:none;margin-bottom:28px;display:flex;flex-direction:column;gap:10px;">
                    <?php foreach (['Productos ilimitados','500 GB almacenamiento','Portal de clientes + experiencia personalizada','Todo el plan Professional','Personalización completa','Webhooks e integraciones','White label disponible','Consultoría incluida','SLA garantizado','Soporte dedicado 24/7'] as $feat): ?>
                    <li style="display:flex;align-items:center;gap:10px;font-size:14px;color:#334155;">
                        <i class="fas fa-check-circle" style="color:#10b981;font-size:13px;flex-shrink:0;"></i><?= $feat ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?= BASE_URL ?>auth/register?plan=enterprise"
                   style="display:block;text-align:center;padding:13px;border-radius:10px;border:1.5px solid #d1d5db;color:#374151;font-weight:700;font-size:14px;text-decoration:none;transition:all .15s;"
                   onmouseover="this.style.background='#f9fafb';this.style.borderColor='#9ca3af'" onmouseout="this.style.background='transparent';this.style.borderColor='#d1d5db'">
                    Contactar Ventas
                </a>
            </div>
        </div>

        <!-- Guarantees -->
        <div style="text-align:center;margin-top:44px;display:flex;align-items:center;justify-content:center;gap:28px;flex-wrap:wrap;">
            <?php foreach ([
                ['icon'=>'fas fa-shield-alt', 'text'=>'Garantía de devolución 30 días'],
                ['icon'=>'fas fa-credit-card','text'=>'Sin tarjeta para la prueba'],
                ['icon'=>'fas fa-sync-alt',   'text'=>'Cambia de plan cuando quieras'],
            ] as $g): ?>
            <div style="display:flex;align-items:center;gap:8px;font-size:13.5px;color:#64748b;">
                <i class="<?= $g['icon'] ?>" style="color:#2a7a52;"></i> <?= $g['text'] ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- =========== TESTIMONIOS =========== -->
<section class="section" style="background:#fff;">
    <div class="section-inner">
        <div class="text-center" style="margin-bottom:60px;">
            <div class="section-label"><i class="fas fa-heart"></i> Historias de Éxito</div>
            <h2 class="section-title">Emprendedores que ya están creciendo</h2>
            <p class="section-subtitle">Más de 5,000 tiendas confían en Kyros Commerce para hacer crecer su negocio.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <?php
            $testimonials = [
                ['name'=>'Juan Martínez', 'role'=>'Tienda de Tecnología', 'initials'=>'JM', 'color'=>'#2a7a52', 'revenue'=>'+$8,400/mes',
                 'text'=>'Kyros cambió mi negocio por completo. Antes vendía poco por redes sociales; ahora recibo órdenes todos los días. La plataforma es increíblemente fácil.'],
                ['name'=>'María Rodríguez','role'=>'Artesanías Handmade',  'initials'=>'MR', 'color'=>'#d4973a', 'revenue'=>'Primera venta en 3 días',
                 'text'=>'El soporte de Kyros es increíble. Siempre disponibles en español para resolver mis dudas. En menos de una semana ya había realizado mis primeras ventas.'],
                ['name'=>'Carlos Ruiz',   'role'=>'Boutique de Ropa',     'initials'=>'CR', 'color'=>'#2563eb', 'revenue'=>'200% más ventas',
                 'text'=>'Migré desde otra plataforma y la diferencia es brutal. Gasto menos, tengo más funciones, y el soporte en español marca toda la diferencia. 100% recomendado.'],
            ];
            foreach ($testimonials as $t): ?>
            <div class="testimonial-v2 fade-in-up">
                <div style="display:inline-flex;align-items:center;gap:6px;background:#ecfdf5;border:1px solid #bbf7d0;border-radius:100px;padding:4px 12px;font-size:11px;font-weight:700;color:#2a7a52;margin-bottom:16px;">
                    <i class="fas fa-arrow-trend-up" style="font-size:10px;"></i>
                    <?= $t['revenue'] ?>
                </div>
                <div class="stars" style="margin-bottom:14px;">★★★★★</div>
                <p style="font-size:14.5px;color:#475569;line-height:1.75;margin-bottom:22px;">"<?= $t['text'] ?>"</p>
                <div style="display:flex;align-items:center;gap:12px;border-top:1px solid #f1f5f9;padding-top:16px;">
                    <div style="width:44px;height:44px;border-radius:50%;background:<?= $t['color'] ?>;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:800;flex-shrink:0;"><?= $t['initials'] ?></div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#1e293b;"><?= $t['name'] ?></div>
                        <div style="font-size:12px;color:#94a3b8;margin-top:1px;"><?= $t['role'] ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- =========== CTA =========== -->
<section class="cta-green">
    <div style="max-width:1200px;margin:0 auto;padding:0 24px;text-align:center;position:relative;z-index:1;">
        <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(42,122,82,.25);border:1px solid rgba(42,122,82,.4);border-radius:100px;padding:7px 18px;margin-bottom:28px;">
            <i class="fas fa-users" style="color:#86efac;font-size:11px;"></i>
            <span style="color:#86efac;font-size:12px;font-weight:700;">Únete a más de 5,000 emprendedores</span>
        </div>
        <h2 style="font-size:clamp(32px,4.5vw,52px);font-weight:900;color:#fff;letter-spacing:-1.5px;line-height:1.1;margin-bottom:20px;">
            ¿Listo para llevar tu<br>negocio al siguiente nivel?
        </h2>
        <p style="font-size:18px;color:rgba(255,255,255,.6);margin-bottom:40px;max-width:520px;margin-left:auto;margin-right:auto;line-height:1.7;">
            Crea tu tienda online gratis hoy. Sin tarjeta, sin contrato, sin complicaciones.
        </p>
        <a href="<?= BASE_URL ?>auth/register"
              class="home-cta-btn"
           style="display:inline-flex;align-items:center;gap:10px;background:#d4973a;color:#fff;padding:16px 36px;border-radius:14px;font-size:16px;font-weight:800;text-decoration:none;box-shadow:0 4px 24px rgba(212,151,58,.4);transition:all .2s;"
           onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 36px rgba(212,151,58,.55)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 24px rgba(212,151,58,.4)'">
            <i class="fas fa-rocket"></i> Comenzar Prueba Gratuita de 15 Días
        </a>
        <p style="font-size:13px;color:rgba(255,255,255,.3);margin-top:18px;">
            <i class="fas fa-lock" style="font-size:11px;margin-right:4px;"></i> Datos 100% seguros · Sin spam · Cancela cuando quieras
        </p>
    </div>
</section>

<!-- =========== FAQ =========== -->
<section class="section" style="background:#f8fafc;">
    <div style="max-width:720px;margin:0 auto;padding:0 24px;">
        <div class="text-center" style="margin-bottom:52px;">
            <div class="section-label"><i class="fas fa-question-circle"></i> FAQ</div>
            <h2 class="section-title">Preguntas frecuentes</h2>
            <p class="section-subtitle">¿Tienes dudas? Aquí respondemos las más comunes.</p>
        </div>
        <div style="display:flex;flex-direction:column;gap:10px;" id="faqList">
            <?php
            $faqs = [
                ['q'=>'¿Necesito conocimientos técnicos para usar Kyros?',
                 'a'=>'No. Kyros Commerce está diseñado para que cualquier persona pueda crear y administrar su tienda online. Si puedes usar WhatsApp, puedes usar Kyros.'],
                ['q'=>'¿Qué incluye la prueba gratuita de 15 días?',
                 'a'=>'La prueba incluye acceso completo a todas las funciones del plan Professional, sin restricciones. No se requiere tarjeta de crédito.'],
                ['q'=>'¿Puedo cambiar de plan en cualquier momento?',
                 'a'=>'Sí. Puedes actualizar o cambiar tu plan desde tu panel de administración en cualquier momento, sin perder tus datos ni historial de ventas.'],
                ['q'=>'¿Kyros cobra comisiones por cada venta?',
                 'a'=>'No. En los planes pagados no cobramos comisiones. El 100% de tus ganancias son tuyas. Solo pagas tu suscripción mensual.'],
                ['q'=>'¿Cómo recibo el pago de mis clientes?',
                 'a'=>'Actualmente coordinas pagos directamente con tus clientes vía WhatsApp o transferencia. Próximamente integraremos Stripe, PayPal y más pasarelas de pago automáticas.'],
                ['q'=>'¿Puedo usar mi propio dominio?',
                 'a'=>'Sí, en los planes Professional y Enterprise puedes conectar tu dominio personalizado para que tu tienda tenga una URL completamente propia.'],
            ];
            foreach ($faqs as $i => $faq): ?>
            <div class="faq-item" id="faq-<?= $i ?>">
                <div class="faq-question" onclick="toggleFaq(<?= $i ?>)">
                    <span style="font-size:15px;font-weight:600;color:#1e293b;padding-right:16px;"><?= $faq['q'] ?></span>
                    <i class="fas fa-chevron-down" id="faq-icon-<?= $i ?>" style="font-size:12px;color:#94a3b8;transition:transform .25s;flex-shrink:0;"></i>
                </div>
                <div class="faq-answer" id="faq-answer-<?= $i ?>"><?= $faq['a'] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- =========== CONTACTO =========== -->
<section class="section" id="contacto" style="background:#ffffff;">
    <div class="section-inner">
        <div class="text-center" style="margin-bottom:42px;">
            <div class="section-label"><i class="fas fa-envelope-open-text"></i> Contacto</div>
            <h2 class="section-title">Estamos listos para ayudarte</h2>
            <p class="section-subtitle">Escríbenos por correo o WhatsApp y te respondemos lo antes posible.</p>
        </div>

        <div class="home-contact-grid">
            <a class="home-contact-card fade-in-up" href="mailto:jonathansandoval@kyrosrd.com">
                <div class="home-contact-icon" style="background:#eff6ff;color:#2563eb;">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <div class="home-contact-label">Correo</div>
                    <div class="home-contact-value">jonathansandoval@kyrosrd.com</div>
                    <div class="home-contact-note">Ideal para soporte, alianzas y consultas comerciales.</div>
                </div>
            </a>

            <a class="home-contact-card fade-in-up" href="https://wa.me/18495024061" target="_blank" rel="noopener noreferrer">
                <div class="home-contact-icon" style="background:#ecfdf5;color:#16a34a;">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div>
                    <div class="home-contact-label">WhatsApp</div>
                    <div class="home-contact-value">1 849-502-4061</div>
                    <div class="home-contact-note">Atención directa para dudas rápidas y seguimiento.</div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- =========== FOOTER =========== -->
<footer style="background:#0c1f12;color:#4b7a5c;padding:72px 0 36px;">
    <div style="max-width:1200px;margin:0 auto;padding:0 24px;">
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:48px;margin-bottom:56px;" class="grid-footer">
            <!-- Brand -->
            <div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                    <div style="width:34px;height:34px;background:linear-gradient(135deg,#2a7a52,#d4973a);border-radius:9px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:15px;color:#fff;">K</div>
                    <span style="font-size:17px;font-weight:800;color:#ecfdf5;">Kyros Commerce</span>
                </div>
                <p style="font-size:14px;line-height:1.75;color:#4b7a5c;max-width:260px;margin-bottom:20px;">La plataforma de e-commerce SaaS diseñada para emprendedores latinoamericanos que quieren vender más.</p>
                <div style="display:flex;gap:10px;">
                    <?php foreach ([
                        ['icon'=>'fab fa-instagram','href'=>'#'],
                        ['icon'=>'fab fa-facebook', 'href'=>'#'],
                        ['icon'=>'fab fa-twitter',  'href'=>'#'],
                        ['icon'=>'fab fa-whatsapp', 'href'=>'#'],
                    ] as $s): ?>
                    <a href="<?= $s['href'] ?>" style="width:36px;height:36px;background:rgba(255,255,255,.06);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#6b9e7d;text-decoration:none;transition:all .15s;font-size:14px;"
                       onmouseover="this.style.background='rgba(255,255,255,.12)';this.style.color='#86efac'" onmouseout="this.style.background='rgba(255,255,255,.06)';this.style.color='#6b9e7d'">
                        <i class="<?= $s['icon'] ?>"></i>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Producto -->
            <div>
                <h4 style="color:#ecfdf5;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:18px;">Producto</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:11px;">
                    <?php foreach ([
                        ['label'=>'Características','href'=>'#caracteristicas'],
                        ['label'=>'Precios',        'href'=>'#planes'],
                        ['label'=>'Changelog',      'href'=>'#'],
                        ['label'=>'Seguridad',      'href'=>BASE_URL.'security'],
                    ] as $l): ?>
                    <li><a href="<?= $l['href'] ?>" style="font-size:13.5px;color:#4b7a5c;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#86efac'" onmouseout="this.style.color='#4b7a5c'"><?= $l['label'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Compañía -->
            <div>
                <h4 style="color:#ecfdf5;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:18px;">Compañía</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:11px;">
                    <?php foreach ([
                        ['label'=>'Acerca de','href'=>BASE_URL.'about'],
                        ['label'=>'Blog',     'href'=>BASE_URL.'blog'],
                        ['label'=>'Contacto', 'href'=>BASE_URL.'contact'],
                        ['label'=>'Afiliados','href'=>'#'],
                    ] as $l): ?>
                    <li><a href="<?= $l['href'] ?>" style="font-size:13.5px;color:#4b7a5c;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#86efac'" onmouseout="this.style.color='#4b7a5c'"><?= $l['label'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h4 style="color:#ecfdf5;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:18px;">Legal</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:11px;">
                    <?php foreach ([
                        ['label'=>'Términos de uso','href'=>BASE_URL.'terms'],
                        ['label'=>'Privacidad',     'href'=>BASE_URL.'privacy'],
                        ['label'=>'Cookies',        'href'=>BASE_URL.'cookies'],
                    ] as $l): ?>
                    <li><a href="<?= $l['href'] ?>" style="font-size:13.5px;color:#4b7a5c;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#86efac'" onmouseout="this.style.color='#4b7a5c'"><?= $l['label'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div style="border-top:1px solid rgba(255,255,255,.06);padding-top:28px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <p style="font-size:13px;color:#2d5c3d;">&copy; <?= date('Y') ?> Kyros Commerce. Todos los derechos reservados.</p>
            <div style="display:flex;align-items:center;gap:6px;font-size:12.5px;color:#2d5c3d;">
                <i class="fas fa-leaf" style="color:#4b7a5c;font-size:11px;"></i>
                Hecho con pasión para emprendedores
            </div>
        </div>
    </div>
</footer>

<script>
function toggleFaq(id) {
    const answer = document.getElementById('faq-answer-' + id);
    const icon   = document.getElementById('faq-icon-' + id);
    const item   = document.getElementById('faq-' + id);
    const isOpen = item.classList.contains('open');

    document.querySelectorAll('[id^="faq-answer-"]').forEach(el => el.style.display = 'none');
    document.querySelectorAll('[id^="faq-icon-"]').forEach(el  => el.style.transform = 'none');
    document.querySelectorAll('.faq-item').forEach(el => el.classList.remove('open'));

    if (!isOpen) {
        answer.style.display = 'block';
        icon.style.transform  = 'rotate(180deg)';
        item.classList.add('open');
    }
}

// Mobile nav
function openHomeNav() {
    document.getElementById('homeNavDrawer').classList.add('open');
    document.getElementById('homeNavOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeHomeNav() {
    document.getElementById('homeNavDrawer').classList.remove('open');
    document.getElementById('homeNavOverlay').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('homeMenuBtn').addEventListener('click', openHomeNav);

// Scroll reveal
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.fade-in-up').forEach(el => {
    if (el.getBoundingClientRect().top > window.innerHeight) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(24px)';
        el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        observer.observe(el);
    }
});
</script>
</body>
</html>
