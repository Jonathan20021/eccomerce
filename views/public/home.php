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
</head>
<body style="font-family:'Inter',sans-serif;background:#fff;color:#1e293b;">

<!-- =========== NAVBAR =========== -->
<nav style="position:sticky;top:0;z-index:150;background:rgba(255,255,255,0.97);backdrop-filter:blur(16px);border-bottom:1px solid #e2e8f0;">
    <div style="max-width:1200px;margin:0 auto;padding:0 24px;height:64px;display:flex;align-items:center;justify-content:space-between;">
        <!-- Logo -->
        <a href="<?= BASE_URL ?>" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
            <div style="width:34px;height:34px;background:linear-gradient(135deg,#4f46e5,#7c3aed);border-radius:9px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:15px;color:#fff;letter-spacing:-0.5px;">K</div>
            <span style="font-size:18px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Kyros Commerce</span>
        </a>

        <!-- Links (desktop) -->
        <div class="hidden md:flex items-center gap-1">
            <a href="#caracteristicas" style="font-size:14px;font-weight:500;color:#475569;padding:6px 12px;border-radius:7px;text-decoration:none;transition:all .15s;" onmouseover="this.style.background='#f8fafc';this.style.color='#1e293b'" onmouseout="this.style.background='transparent';this.style.color='#475569'">Características</a>
            <a href="#como-funciona" style="font-size:14px;font-weight:500;color:#475569;padding:6px 12px;border-radius:7px;text-decoration:none;transition:all .15s;" onmouseover="this.style.background='#f8fafc';this.style.color='#1e293b'" onmouseout="this.style.background='transparent';this.style.color='#475569'">Cómo funciona</a>
            <a href="#planes" style="font-size:14px;font-weight:500;color:#475569;padding:6px 12px;border-radius:7px;text-decoration:none;transition:all .15s;" onmouseover="this.style.background='#f8fafc';this.style.color='#1e293b'" onmouseout="this.style.background='transparent';this.style.color='#475569'">Precios</a>
        </div>

        <!-- Auth (desktop) + Hamburger (mobile) -->
        <div style="display:flex;align-items:center;gap:8px;">
            <?php if (Auth::isLoggedIn()): ?>
                <span style="font-size:13.5px;font-weight:500;color:#64748b;" class="hidden md:inline"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                <?php if (Auth::isSuperAdmin()): ?>
                    <a href="<?= BASE_URL ?>superadmin/dashboard" style="font-size:13.5px;font-weight:600;color:#4f46e5;padding:7px 14px;border-radius:8px;border:1.5px solid #e0e7ff;background:#f5f3ff;text-decoration:none;" class="hidden md:inline-flex">Dashboard</a>
                <?php elseif (Auth::isStoreOwner()): ?>
                    <a href="<?= BASE_URL ?>admin/dashboard" style="font-size:13.5px;font-weight:600;color:#4f46e5;padding:7px 14px;border-radius:8px;border:1.5px solid #e0e7ff;background:#f5f3ff;text-decoration:none;" class="hidden md:inline-flex">Mi Tienda</a>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>auth/logout" style="font-size:13.5px;font-weight:600;color:#ef4444;padding:7px 14px;border-radius:8px;border:1.5px solid #fecaca;background:#fef2f2;text-decoration:none;" class="hidden md:inline-flex">Salir</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>auth/login" style="font-size:13.5px;font-weight:600;color:#475569;padding:7px 14px;border-radius:8px;border:1.5px solid #e2e8f0;background:#fff;text-decoration:none;transition:all .15s;" class="hidden md:inline-flex">Iniciar sesión</a>
                <a href="<?= BASE_URL ?>auth/register" style="font-size:13.5px;font-weight:700;color:#fff;padding:8px 18px;border-radius:9px;background:linear-gradient(135deg,#4f46e5,#7c3aed);text-decoration:none;box-shadow:0 4px 14px rgba(79,70,229,0.3);transition:all .15s;" class="hidden md:inline-flex">Empezar gratis</a>
            <?php endif; ?>

            <!-- Hamburger button (mobile) -->
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
            <div style="width:30px;height:30px;background:linear-gradient(135deg,#4f46e5,#7c3aed);border-radius:8px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:13px;color:#fff;">K</div>
            <span style="font-size:16px;font-weight:800;color:#1e293b;">Kyros Commerce</span>
        </div>
        <button class="mobile-nav-close" onclick="closeHomeNav()"><i class="fas fa-times"></i></button>
    </div>
    <div class="mobile-nav-links">
        <a href="#caracteristicas" class="mobile-nav-link" onclick="closeHomeNav()">
            <i class="fas fa-star"></i> Características
        </a>
        <a href="#como-funciona" class="mobile-nav-link" onclick="closeHomeNav()">
            <i class="fas fa-play-circle"></i> Cómo funciona
        </a>
        <a href="#planes" class="mobile-nav-link" onclick="closeHomeNav()">
            <i class="fas fa-tag"></i> Precios
        </a>
    </div>
    <div class="mobile-nav-footer">
        <?php if (Auth::isLoggedIn()): ?>
            <?php if (Auth::isSuperAdmin()): ?>
                <a href="<?= BASE_URL ?>superadmin/dashboard" style="display:flex;align-items:center;justify-content:center;gap:8px;height:42px;border-radius:9px;background:#f5f3ff;border:1.5px solid #e0e7ff;color:#4f46e5;font-size:14px;font-weight:600;text-decoration:none;">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
            <?php elseif (Auth::isStoreOwner()): ?>
                <a href="<?= BASE_URL ?>admin/dashboard" style="display:flex;align-items:center;justify-content:center;gap:8px;height:42px;border-radius:9px;background:#f5f3ff;border:1.5px solid #e0e7ff;color:#4f46e5;font-size:14px;font-weight:600;text-decoration:none;">
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
            <a href="<?= BASE_URL ?>auth/register" style="display:flex;align-items:center;justify-content:center;gap:8px;height:42px;border-radius:9px;background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;font-size:14px;font-weight:700;text-decoration:none;">
                <i class="fas fa-rocket"></i> Empezar gratis
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- =========== HERO =========== -->
<section class="hero">
    <div class="hero-inner">
        <div class="grid md:grid-cols-2 gap-14 items-center">
            <div class="fade-in-up">
                <!-- Label -->
                <div style="display:inline-flex;align-items:center;gap:7px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);border-radius:100px;padding:6px 14px;margin-bottom:24px;">
                    <span style="color:#fbbf24;font-size:10px;">●</span>
                    <span style="color:rgba(255,255,255,0.85);font-size:12.5px;font-weight:600;">Plataforma SaaS de E-commerce</span>
                </div>

                <h1 style="font-size:clamp(36px,5vw,56px);font-weight:900;color:#fff;line-height:1.1;letter-spacing:-1.5px;margin-bottom:20px;">
                    Tu tienda online,<br>
                    <span style="background:linear-gradient(135deg,#a78bfa,#60a5fa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">lista en minutos</span>
                </h1>

                <p style="font-size:18px;color:rgba(255,255,255,0.7);line-height:1.7;margin-bottom:36px;max-width:480px;">
                    Kyros Commerce es la plataforma ideal para vender online. Sin límites de productos, sin complicaciones técnicas, 100% administrable.
                </p>

                <div style="display:flex;flex-wrap:wrap;gap:12px;margin-bottom:28px;">
                    <a href="<?= BASE_URL ?>auth/register" class="btn-hero">
                        <i class="fas fa-rocket"></i> Comenzar Gratuitamente
                    </a>
                    <a href="#planes" class="btn-outline-white">
                        <i class="fas fa-tag"></i> Ver Planes
                    </a>
                </div>

                <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                    <div style="display:flex;align-items:center;gap:6px;color:rgba(255,255,255,0.65);font-size:13px;">
                        <i class="fas fa-check" style="color:#4ade80;font-size:11px;"></i>
                        15 días gratis
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;color:rgba(255,255,255,0.65);font-size:13px;">
                        <i class="fas fa-check" style="color:#4ade80;font-size:11px;"></i>
                        Sin tarjeta de crédito
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;color:rgba(255,255,255,0.65);font-size:13px;">
                        <i class="fas fa-check" style="color:#4ade80;font-size:11px;"></i>
                        Cancela cuando quieras
                    </div>
                </div>
            </div>

            <!-- Hero visual -->
            <div class="hidden md:block fade-in-up" style="animation-delay:0.15s;">
                <div style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);border-radius:20px;padding:24px;backdrop-filter:blur(10px);">
                    <!-- Mini dashboard preview -->
                    <div style="background:rgba(255,255,255,0.08);border-radius:14px;padding:16px;margin-bottom:14px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                            <div style="color:rgba(255,255,255,0.7);font-size:12px;font-weight:600;">Ventas hoy</div>
                            <div style="color:#4ade80;font-size:11px;font-weight:700;background:rgba(74,222,128,0.15);padding:3px 8px;border-radius:20px;">+24%</div>
                        </div>
                        <div style="font-size:32px;font-weight:900;color:#fff;letter-spacing:-1px;">$2,847</div>
                        <!-- Mini bar chart -->
                        <div style="display:flex;align-items:flex-end;gap:5px;margin-top:14px;height:40px;">
                            <?php
                            $bars = [35, 55, 45, 70, 60, 80, 95, 75, 85, 100, 90, 100];
                            foreach ($bars as $h):
                            ?>
                            <div style="flex:1;background:rgba(255,255,255,<?= $h/100 * 0.25 ?>);border-radius:3px;height:<?= $h ?>%;transition:all .2s;"></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- Stats row -->
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
                        <div style="background:rgba(255,255,255,0.08);border-radius:10px;padding:12px;text-align:center;">
                            <div style="color:rgba(255,255,255,0.55);font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Órdenes</div>
                            <div style="color:#fff;font-size:18px;font-weight:800;">148</div>
                        </div>
                        <div style="background:rgba(255,255,255,0.08);border-radius:10px;padding:12px;text-align:center;">
                            <div style="color:rgba(255,255,255,0.55);font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Productos</div>
                            <div style="color:#fff;font-size:18px;font-weight:800;">92</div>
                        </div>
                        <div style="background:rgba(255,255,255,0.08);border-radius:10px;padding:12px;text-align:center;">
                            <div style="color:rgba(255,255,255,0.55);font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Clientes</div>
                            <div style="color:#fff;font-size:18px;font-weight:800;">1.2K</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========== STATS BAR =========== -->
<section style="background:#0f172a;padding:36px 0;border-bottom:1px solid rgba(255,255,255,0.05);">
    <div style="max-width:1200px;margin:0 auto;padding:0 24px;">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:32px;text-align:center;">
            <div>
                <div style="font-size:32px;font-weight:900;color:#fff;letter-spacing:-1px;">+5,000</div>
                <div style="font-size:13px;color:#64748b;font-weight:500;margin-top:3px;">Tiendas activas</div>
            </div>
            <div>
                <div style="font-size:32px;font-weight:900;color:#fff;letter-spacing:-1px;">$2M+</div>
                <div style="font-size:13px;color:#64748b;font-weight:500;margin-top:3px;">Ventas procesadas</div>
            </div>
            <div>
                <div style="font-size:32px;font-weight:900;color:#fff;letter-spacing:-1px;">99.9%</div>
                <div style="font-size:13px;color:#64748b;font-weight:500;margin-top:3px;">Uptime garantizado</div>
            </div>
            <div>
                <div style="font-size:32px;font-weight:900;color:#fff;letter-spacing:-1px;">4.9★</div>
                <div style="font-size:13px;color:#64748b;font-weight:500;margin-top:3px;">Calificación promedio</div>
            </div>
        </div>
    </div>
</section>

<!-- =========== CARACTERÍSTICAS =========== -->
<section class="section" id="caracteristicas" style="background:#fff;">
    <div class="section-inner">
        <div class="text-center" style="margin-bottom:60px;">
            <div class="section-label"><i class="fas fa-star"></i> Características</div>
            <h2 class="section-title">Todo lo que necesitas para vender</h2>
            <p class="section-subtitle">Una plataforma completa para gestionar tu negocio online desde el primer día.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="feature-card fade-in-up" style="animation-delay:0s;">
                <div class="feature-icon" style="background:#eef2ff;color:#4f46e5;"><i class="fas fa-shopping-cart"></i></div>
                <h3 class="feature-title">Carrito de Compras</h3>
                <p class="feature-text">Carrito robusto y seguro. Tus clientes pueden agregar, editar y procesar su compra sin fricción.</p>
            </div>
            <div class="feature-card fade-in-up" style="animation-delay:0.05s;">
                <div class="feature-icon" style="background:#f0fdf4;color:#16a34a;"><i class="fab fa-whatsapp"></i></div>
                <h3 class="feature-title">Integración WhatsApp</h3>
                <p class="feature-text">Recibe notificaciones de nuevas órdenes directamente en WhatsApp y atiende a tus clientes.</p>
            </div>
            <div class="feature-card fade-in-up" style="animation-delay:0.10s;">
                <div class="feature-icon" style="background:#faf5ff;color:#7c3aed;"><i class="fas fa-images"></i></div>
                <h3 class="feature-title">Galerías de Imágenes</h3>
                <p class="feature-text">Sube fotos de tus productos sin límite. Muestra tu catálogo con imágenes de alta calidad.</p>
            </div>
            <div class="feature-card fade-in-up" style="animation-delay:0.15s;">
                <div class="feature-icon" style="background:#eff6ff;color:#2563eb;"><i class="fas fa-chart-bar"></i></div>
                <h3 class="feature-title">Analytics en Tiempo Real</h3>
                <p class="feature-text">Visualiza tus ventas, clientes y productos más vendidos con métricas actualizadas al instante.</p>
            </div>
            <div class="feature-card fade-in-up" style="animation-delay:0.20s;">
                <div class="feature-icon" style="background:#fff7ed;color:#c2410c;"><i class="fas fa-mobile-alt"></i></div>
                <h3 class="feature-title">100% Responsivo</h3>
                <p class="feature-text">Tu tienda se ve perfecta en todos los dispositivos: desktop, tablets y smartphones.</p>
            </div>
            <div class="feature-card fade-in-up" style="animation-delay:0.25s;">
                <div class="feature-icon" style="background:#fef2f2;color:#dc2626;"><i class="fas fa-headset"></i></div>
                <h3 class="feature-title">Soporte 24/7</h3>
                <p class="feature-text">Nuestro equipo siempre disponible para ayudarte con cualquier duda o problema.</p>
            </div>
        </div>
    </div>
</section>

<!-- =========== CÓMO FUNCIONA =========== -->
<section class="section" id="como-funciona" style="background:#f8fafc;">
    <div class="section-inner">
        <div class="text-center" style="margin-bottom:60px;">
            <div class="section-label"><i class="fas fa-play-circle"></i> Proceso</div>
            <h2 class="section-title">¿Cómo funciona Kyros Commerce?</h2>
            <p class="section-subtitle">En 4 simples pasos tienes tu tienda online lista para vender.</p>
        </div>

        <div class="grid md:grid-cols-4 gap-6 relative">
            <!-- Line connector (desktop) -->
            <div class="hidden md:block" style="position:absolute;top:26px;left:calc(12.5% + 26px);right:calc(12.5% + 26px);height:2px;background:linear-gradient(90deg,#4f46e5,#7c3aed);z-index:0;opacity:0.25;"></div>

            <?php
            $steps = [
                ['num'=>1, 'icon'=>'fas fa-user-plus', 'title'=>'Regístrate', 'desc'=>'Crea tu cuenta gratuitamente con tu correo electrónico en menos de 2 minutos.'],
                ['num'=>2, 'icon'=>'fas fa-store', 'title'=>'Configura tu Tienda', 'desc'=>'Personaliza nombre, logo, descripción y colores de marca de tu tienda.'],
                ['num'=>3, 'icon'=>'fas fa-box', 'title'=>'Sube tus Productos', 'desc'=>'Agrega los productos que deseas vender con precios, imágenes y descripciones.'],
                ['num'=>4, 'icon'=>'fas fa-rocket', 'title'=>'¡Vende!', 'desc'=>'Comparte el link de tu tienda y comienza a recibir órdenes de tus clientes.'],
            ];
            foreach ($steps as $i => $step):
            ?>
            <div class="text-center fade-in-up" style="position:relative;z-index:1;animation-delay:<?= $i * 0.1 ?>s;">
                <div class="step-circle" style="margin-bottom:18px;">
                    <?= $step['num'] ?>
                </div>
                <h3 style="font-size:15px;font-weight:700;margin-bottom:8px;"><?= $step['title'] ?></h3>
                <p style="font-size:13.5px;color:#64748b;line-height:1.6;"><?= $step['desc'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- =========== PLANES =========== -->
<section class="section" id="planes" style="background:#fff;">
    <div class="section-inner">
        <div class="text-center" style="margin-bottom:60px;">
            <div class="section-label"><i class="fas fa-tag"></i> Precios</div>
            <h2 class="section-title">Planes para cada negocio</h2>
            <p class="section-subtitle">Elige el plan que mejor se adapte a tu negocio. Cambia cuando quieras.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 items-start">

            <!-- Starter -->
            <div class="pricing-card">
                <div style="margin-bottom:24px;">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#64748b;margin-bottom:8px;">Starter</div>
                    <div style="font-size:42px;font-weight:900;color:#1e293b;letter-spacing:-2px;line-height:1;">$0<span style="font-size:16px;font-weight:500;color:#94a3b8;letter-spacing:0;">/mes</span></div>
                    <div style="font-size:12.5px;color:#94a3b8;margin-top:6px;">15 días de prueba gratis</div>
                </div>
                <hr style="border-color:#f1f5f9;margin-bottom:24px;">
                <ul style="space-y:10px;margin-bottom:28px;">
                    <?php foreach (['50 productos', '5 GB almacenamiento', 'Módulo de Inventario', 'Carrito básico', 'WhatsApp integrado', 'Soporte por email'] as $feat): ?>
                    <li style="display:flex;align-items:center;gap:10px;padding:5px 0;font-size:14px;color:#334155;">
                        <i class="fas fa-check-circle" style="color:#10b981;font-size:13px;flex-shrink:0;"></i>
                        <?= $feat ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?= BASE_URL ?>auth/register?plan=starter"
                   style="display:block;text-align:center;padding:12px;border-radius:9px;border:1.5px solid #e2e8f0;color:#1e293b;font-weight:700;font-size:14px;text-decoration:none;transition:all .15s;"
                   onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    Comenzar gratis
                </a>
            </div>

            <!-- Professional (featured) -->
            <div class="pricing-card featured" style="transform:scale(1.03);">
                <div class="pricing-badge">MÁS POPULAR</div>
                <div style="margin-bottom:24px;">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#4f46e5;margin-bottom:8px;">Professional</div>
                    <div style="font-size:42px;font-weight:900;color:#1e293b;letter-spacing:-2px;line-height:1;">$99<span style="font-size:16px;font-weight:500;color:#94a3b8;letter-spacing:0;">/mes</span></div>
                    <div style="font-size:12.5px;color:#94a3b8;margin-top:6px;">Primeros 30 días con 50% descuento</div>
                </div>
                <hr style="border-color:#ddd6fe;margin-bottom:24px;">
                <ul style="margin-bottom:28px;">
                    <?php foreach (['500 productos', '50 GB almacenamiento', 'Módulo de Inventario', 'Módulo de Finanzas', 'Carrito avanzado', 'Analytics completo', 'SEO mejorado', 'API REST', 'Soporte prioritario'] as $feat): ?>
                    <li style="display:flex;align-items:center;gap:10px;padding:5px 0;font-size:14px;color:#334155;">
                        <i class="fas fa-check-circle" style="color:#4f46e5;font-size:13px;flex-shrink:0;"></i>
                        <?= $feat ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?= BASE_URL ?>auth/register?plan=professional"
                   style="display:block;text-align:center;padding:13px;border-radius:10px;background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;font-weight:700;font-size:14px;text-decoration:none;box-shadow:0 4px 16px rgba(79,70,229,0.35);transition:all .2s;"
                   onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 22px rgba(79,70,229,0.45)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 16px rgba(79,70,229,0.35)'">
                    Comenzar Ahora
                </a>
            </div>

            <!-- Enterprise -->
            <div class="pricing-card">
                <div style="margin-bottom:24px;">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#64748b;margin-bottom:8px;">Enterprise</div>
                    <div style="font-size:42px;font-weight:900;color:#1e293b;letter-spacing:-2px;line-height:1;">$299<span style="font-size:16px;font-weight:500;color:#94a3b8;letter-spacing:0;">/mes</span></div>
                    <div style="font-size:12.5px;color:#94a3b8;margin-top:6px;">Personalizable según tus necesidades</div>
                </div>
                <hr style="border-color:#f1f5f9;margin-bottom:24px;">
                <ul style="margin-bottom:28px;">
                    <?php foreach (['Productos ilimitados', '500 GB almacenamiento', 'Módulo de Inventario', 'Módulo de Finanzas', 'Personalización completa', 'Webhooks e integraciones', 'White label', 'Consultoría incluida', 'Soporte dedicado 24/7'] as $feat): ?>
                    <li style="display:flex;align-items:center;gap:10px;padding:5px 0;font-size:14px;color:#334155;">
                        <i class="fas fa-check-circle" style="color:#10b981;font-size:13px;flex-shrink:0;"></i>
                        <?= $feat ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?= BASE_URL ?>auth/register?plan=enterprise"
                   style="display:block;text-align:center;padding:12px;border-radius:9px;border:1.5px solid #e2e8f0;color:#1e293b;font-weight:700;font-size:14px;text-decoration:none;transition:all .15s;"
                   onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    Contactar Ventas
                </a>
            </div>
        </div>
    </div>
</section>

<!-- =========== TESTIMONIOS =========== -->
<section class="section" style="background:#f8fafc;">
    <div class="section-inner">
        <div class="text-center" style="margin-bottom:56px;">
            <div class="section-label"><i class="fas fa-heart"></i> Testimonios</div>
            <h2 class="section-title">Lo que dicen nuestros clientes</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <?php
            $testimonials = [
                ['name'=>'Juan Martínez', 'role'=>'Tienda de Tecnología', 'initials'=>'JM', 'color'=>'#4f46e5',
                 'text'=>'"Kyros Commerce cambió mi negocio por completo. Antes vendía muy poco, ahora recibo órdenes todos los días. La plataforma es increíblemente fácil de usar."'],
                ['name'=>'María Rodríguez', 'role'=>'Artesanías Handmade', 'initials'=>'MR', 'color'=>'#7c3aed',
                 'text'=>'"El soporte de Kyros Commerce es increíble. Siempre están disponibles para resolver mis dudas. En menos de 1 semana ya tenía mi primera venta."'],
                ['name'=>'Carlos Ruiz', 'role'=>'Boutique de Ropa', 'initials'=>'CR', 'color'=>'#0891b2',
                 'text'=>'"Gasto menos en mantener mi tienda con Kyros Commerce que con cualquier otra plataforma. Excelente relación precio-calidad. 100% recomendado."'],
            ];
            foreach ($testimonials as $t):
            ?>
            <div class="testimonial-card fade-in-up">
                <div class="stars">★★★★★</div>
                <p class="testimonial-text"><?= $t['text'] ?></p>
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:42px;height:42px;border-radius:50%;background:<?= $t['color'] ?>;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:800;flex-shrink:0;"><?= $t['initials'] ?></div>
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
<section class="cta-dark">
    <div style="max-width:1200px;margin:0 auto;padding:0 24px;text-align:center;position:relative;z-index:1;">
        <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(79,70,229,0.2);border:1px solid rgba(79,70,229,0.3);border-radius:100px;padding:6px 16px;margin-bottom:24px;">
            <span style="color:#a5b4fc;font-size:12px;font-weight:700;">Únete a +5,000 emprendedores</span>
        </div>
        <h2 style="font-size:clamp(30px,4vw,48px);font-weight:900;color:#fff;letter-spacing:-1.5px;line-height:1.1;margin-bottom:18px;">
            ¿Listo para comenzar a vender?
        </h2>
        <p style="font-size:17px;color:#94a3b8;margin-bottom:36px;max-width:500px;margin-left:auto;margin-right:auto;line-height:1.6;">
            Crea tu tienda online en minutos y empieza a generar ingresos desde el primer día.
        </p>
        <a href="<?= BASE_URL ?>auth/register"
           style="display:inline-flex;align-items:center;gap:8px;background:#fff;color:#1e293b;padding:15px 32px;border-radius:12px;font-size:16px;font-weight:800;text-decoration:none;box-shadow:0 4px 24px rgba(0,0,0,0.2);transition:all .2s;"
           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 32px rgba(0,0,0,0.3)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 24px rgba(0,0,0,0.2)'">
            <i class="fas fa-rocket" style="color:#4f46e5;"></i>
            Comienza tu Prueba Gratis de 15 Días
        </a>
        <p style="font-size:13px;color:#475569;margin-top:16px;">
            <i class="fas fa-lock text-xs mr-1"></i> Sin tarjeta de crédito requerida
        </p>
    </div>
</section>

<!-- =========== FAQ =========== -->
<section class="section" style="background:#fff;">
    <div style="max-width:700px;margin:0 auto;padding:0 24px;">
        <div class="text-center" style="margin-bottom:48px;">
            <div class="section-label"><i class="fas fa-question-circle"></i> FAQ</div>
            <h2 class="section-title">Preguntas Frecuentes</h2>
        </div>

        <div style="display:flex;flex-direction:column;gap:10px;" id="faqList">
            <?php
            $faqs = [
                ['q'=>'¿Necesito conocimientos técnicos?', 'a'=>'No. Kyros Commerce está diseñado para que cualquier persona pueda crear y administrar su tienda online sin necesidad de programación o conocimientos técnicos.'],
                ['q'=>'¿Puedo cambiar de plan en cualquier momento?', 'a'=>'Sí. Puedes actualizar o cambiar tu plan en cualquier momento desde tu panel de administración sin perder tus datos.'],
                ['q'=>'¿Qué pasa después de los 15 días de prueba?', 'a'=>'Después del período de prueba, tu tienda continuará funcionando en el plan Starter gratuito o puedes elegir un plan de pago para desbloquear más funcionalidades.'],
                ['q'=>'¿Kyros Commerce cobra comisiones por venta?', 'a'=>'No. En los planes pagados no cobramos comisiones. El 100% de las ganancias de tus ventas son tuyas.'],
                ['q'=>'¿Cómo recibo mis pagos?', 'a'=>'Puedes gestionar cobros directamente con tus clientes vía WhatsApp. Próximamente integraremos Stripe, PayPal y más pasarelas de pago.'],
            ];
            foreach ($faqs as $i => $faq):
            ?>
            <div class="faq-item" id="faq-<?= $i ?>">
                <div class="faq-question" onclick="toggleFaq(<?= $i ?>)">
                    <span style="font-size:15px;font-weight:600;color:#1e293b;"><?= $faq['q'] ?></span>
                    <i class="fas fa-chevron-down" id="faq-icon-<?= $i ?>" style="font-size:12px;color:#94a3b8;transition:transform .25s;flex-shrink:0;"></i>
                </div>
                <div class="faq-answer" id="faq-answer-<?= $i ?>" style="display:none;padding:0 20px 16px;font-size:14px;color:#64748b;line-height:1.7;">
                    <?= $faq['a'] ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- =========== FOOTER =========== -->
<footer style="background:#0f172a;color:#94a3b8;padding:64px 0 32px;">
    <div style="max-width:1200px;margin:0 auto;padding:0 24px;">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:40px;margin-bottom:48px;">
            <div>
                <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;">
                    <div style="width:32px;height:32px;background:linear-gradient(135deg,#4f46e5,#7c3aed);border-radius:8px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:13px;color:#fff;">K</div>
                    <span style="font-size:16px;font-weight:800;color:#f8fafc;">Kyros Commerce</span>
                </div>
                <p style="font-size:13.5px;line-height:1.7;">Plataforma de e-commerce SaaS para emprendedores.</p>
            </div>
            <div>
                <h4 style="color:#f8fafc;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px;">Producto</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:9px;">
                    <li><a href="#caracteristicas" style="font-size:13.5px;color:#64748b;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#64748b'">Características</a></li>
                    <li><a href="#planes" style="font-size:13.5px;color:#64748b;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#64748b'">Precios</a></li>
                    <li><a href="<?= BASE_URL ?>security" style="font-size:13.5px;color:#64748b;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#64748b'">Seguridad</a></li>
                </ul>
            </div>
            <div>
                <h4 style="color:#f8fafc;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px;">Compañía</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:9px;">
                    <li><a href="<?= BASE_URL ?>about" style="font-size:13.5px;color:#64748b;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#64748b'">Acerca de</a></li>
                    <li><a href="<?= BASE_URL ?>blog" style="font-size:13.5px;color:#64748b;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#64748b'">Blog</a></li>
                    <li><a href="<?= BASE_URL ?>contact" style="font-size:13.5px;color:#64748b;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#64748b'">Contacto</a></li>
                </ul>
            </div>
            <div>
                <h4 style="color:#f8fafc;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px;">Legal</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:9px;">
                    <li><a href="<?= BASE_URL ?>terms" style="font-size:13.5px;color:#64748b;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#64748b'">Términos</a></li>
                    <li><a href="<?= BASE_URL ?>privacy" style="font-size:13.5px;color:#64748b;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#64748b'">Privacidad</a></li>
                    <li><a href="<?= BASE_URL ?>cookies" style="font-size:13.5px;color:#64748b;text-decoration:none;transition:color .15s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#64748b'">Cookies</a></li>
                </ul>
            </div>
        </div>
        <div style="border-top:1px solid rgba(255,255,255,0.06);padding-top:24px;text-align:center;">
            <p style="font-size:13px;">&copy; <?= date('Y') ?> Kyros Commerce. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<script>
function toggleFaq(id) {
    const answer = document.getElementById('faq-answer-' + id);
    const icon   = document.getElementById('faq-icon-' + id);
    const item   = document.getElementById('faq-' + id);
    const isOpen = answer.style.display !== 'none';

    // Close all
    document.querySelectorAll('[id^="faq-answer-"]').forEach(el => el.style.display = 'none');
    document.querySelectorAll('[id^="faq-icon-"]').forEach(el => el.style.transform = 'none');
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
</script>
</body>
</html>
