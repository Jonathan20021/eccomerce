<?php
$page_title = "Crear Tienda — Kyros Commerce";
$plan = isset($_GET['plan']) ? $_GET['plan'] : 'starter';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/style.css">
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/mobile-pro.css">
    <style>
        html, body { height: 100%; }
        body { font-family: 'Inter', sans-serif; background: #fff; }
    </style>
</head>
<body>

<div class="auth-split-layout">

    <!-- ====== LEFT PANEL (brand) ====== -->
    <div class="auth-brand-panel" style="background:linear-gradient(145deg,#0c1f12 0%,#1a4a2e 40%,#2a7a52 72%,#1f5c3d 100%);
                position:relative;overflow:hidden;display:flex;flex-direction:column;justify-content:space-between;padding:48px;">

        <div style="position:absolute;top:-20%;right:-10%;width:500px;height:500px;background:radial-gradient(circle,rgba(212,151,58,.22) 0%,transparent 60%);border-radius:50%;pointer-events:none;"></div>
        <div style="position:absolute;bottom:-20%;left:-10%;width:400px;height:400px;background:radial-gradient(circle,rgba(42,122,82,.25) 0%,transparent 60%);border-radius:50%;pointer-events:none;"></div>

        <!-- Logo -->
        <a href="<?= BASE_URL ?>" style="display:flex;align-items:center;gap:10px;text-decoration:none;position:relative;z-index:1;">
            <div style="width:36px;height:36px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:16px;color:#fff;">K</div>
            <span style="font-size:20px;font-weight:800;color:#fff;letter-spacing:-0.5px;">Kyros Commerce</span>
        </a>

        <!-- Center content -->
        <div style="position:relative;z-index:1;">
            <div style="font-size:clamp(26px,2.5vw,38px);font-weight:900;color:#fff;line-height:1.15;letter-spacing:-1px;margin-bottom:18px;">
                Empieza a vender<br>
                <span style="background:linear-gradient(135deg,#86efac,#fde68a);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">hoy mismo</span>
            </div>
            <p style="font-size:15px;color:rgba(255,255,255,0.65);line-height:1.7;max-width:320px;margin-bottom:32px;">
                Crea tu tienda online en minutos. Sin tarjeta de crédito, sin complicaciones técnicas.
            </p>

            <!-- Benefits list -->
            <div style="display:flex;flex-direction:column;gap:13px;">
                <?php
                $benefits = [
                    ['icon'=>'fas fa-check-circle','color'=>'#4ade80','text'=>'15 días de prueba gratis en todos los planes'],
                    ['icon'=>'fas fa-check-circle','color'=>'#4ade80','text'=>'Sin tarjeta de crédito requerida'],
                    ['icon'=>'fas fa-check-circle','color'=>'#4ade80','text'=>'Cancela cuando quieras, sin penalizaciones'],
                    ['icon'=>'fas fa-check-circle','color'=>'#4ade80','text'=>'Soporte incluido desde el primer día'],
                ];
                foreach ($benefits as $b):
                ?>
                <div style="display:flex;align-items:center;gap:10px;">
                    <i class="<?= $b['icon'] ?>" style="color:<?= $b['color'] ?>;font-size:14px;flex-shrink:0;"></i>
                    <span style="font-size:14px;color:rgba(255,255,255,.75);"><?= $b['text'] ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Bottom rating -->
        <div style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:14px;padding:18px 20px;position:relative;z-index:1;">
            <div style="display:flex;align-items:center;gap:3px;margin-bottom:6px;">
                <?php for($i=0;$i<5;$i++): ?>
                <i class="fas fa-star" style="color:#fbbf24;font-size:14px;"></i>
                <?php endfor; ?>
                <span style="font-size:13px;font-weight:700;color:#fff;margin-left:8px;">4.9/5</span>
            </div>
            <p style="font-size:13px;color:rgba(255,255,255,.6);">Más de 500 reseñas de 5 estrellas en plataformas de tecnología.</p>
        </div>
    </div>

    <!-- ====== RIGHT PANEL (form) ====== -->
    <div class="auth-form-panel" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px 24px;background:#fff;overflow-y:auto;">

        <!-- Mobile logo -->
        <a href="<?= BASE_URL ?>" class="auth-mobile-logo" style="display:flex;align-items:center;gap:9px;text-decoration:none;margin-bottom:32px;">
            <div style="width:32px;height:32px;background:linear-gradient(135deg,#2a7a52,#d4973a);border-radius:9px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:14px;color:#fff;">K</div>
            <span style="font-size:17px;font-weight:800;color:#1e293b;">Kyros Commerce</span>
        </a>

        <div style="width:100%;max-width:440px;">
            <div style="margin-bottom:28px;">
                <h1 style="font-size:24px;font-weight:800;color:#1e293b;letter-spacing:-0.7px;margin-bottom:7px;">Crea tu cuenta gratis</h1>
                <p style="font-size:14px;color:#64748b;">Únete a Kyros Commerce y comienza a vender en línea hoy</p>
            </div>

            <!-- Error message -->
            <?php if (isset($_GET['error'])): ?>
            <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
                <i class="fas fa-exclamation-circle" style="color:#dc2626;font-size:14px;flex-shrink:0;"></i>
                <p style="font-size:13.5px;color:#dc2626;font-weight:500;"><?= htmlspecialchars($_GET['error']) ?></p>
            </div>
            <?php endif; ?>

            <form method="POST" style="display:flex;flex-direction:column;gap:15px;">
                <!-- Name + Phone -->
                <div class="auth-form-grid-2">
                    <div>
                        <label class="form-label" for="name">Nombre completo <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="name" name="name" required class="form-input" placeholder="Juan Pérez">
                    </div>
                    <div>
                        <label class="form-label" for="phone">Teléfono <span style="color:#94a3b8;font-weight:400;font-size:11px;">(opcional)</span></label>
                        <input type="tel" id="phone" name="phone" class="form-input" placeholder="+34 612...">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="form-label" for="email">Correo electrónico <span style="color:#ef4444;">*</span></label>
                    <input type="email" id="email" name="email" required class="form-input" placeholder="tu@email.com" autocomplete="email">
                </div>

                <!-- Passwords -->
                <div class="auth-form-grid-2">
                    <div>
                        <label class="form-label" for="password">Contraseña <span style="color:#ef4444;">*</span></label>
                        <div style="position:relative;">
                            <input type="password" id="password" name="password" required
                                   class="form-input" placeholder="••••••••"
                                   style="padding-right:40px;" autocomplete="new-password">
                            <button type="button" onclick="togglePasswordVisibility('password')"
                                    style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:#94a3b8;cursor:pointer;">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                        <p style="font-size:11px;color:#94a3b8;margin-top:4px;">Mínimo 6 caracteres</p>
                    </div>
                    <div>
                        <label class="form-label" for="password_confirm">Confirmar contraseña <span style="color:#ef4444;">*</span></label>
                        <div style="position:relative;">
                            <input type="password" id="password_confirm" name="password_confirm" required
                                   class="form-input" placeholder="••••••••"
                                   style="padding-right:40px;" autocomplete="new-password">
                            <button type="button" onclick="togglePasswordVisibility('password_confirm')"
                                    style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:#94a3b8;cursor:pointer;">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Plan -->
                <div>
                    <label class="form-label" for="plan_id">Plan de inicio</label>
                    <select id="plan_id" name="plan_id" class="form-input">
                        <option value="1" <?= $plan == 'starter' ? 'selected' : '' ?>>Starter — Gratis · 50 productos, 5 GB</option>
                        <option value="2" <?= $plan == 'professional' ? 'selected' : '' ?>>Professional — $99/mes · 500 productos, 50 GB</option>
                        <option value="3" <?= $plan == 'enterprise' ? 'selected' : '' ?>>Enterprise — $299/mes · Ilimitado</option>
                    </select>
                </div>

                <!-- Trial notice -->
                <div style="background:#ecfdf5;border:1px solid #bbf7d0;border-radius:9px;padding:12px 14px;display:flex;align-items:center;gap:10px;">
                    <i class="fas fa-gift" style="color:#2a7a52;font-size:14px;flex-shrink:0;"></i>
                    <p style="font-size:13px;color:#166534;font-weight:500;line-height:1.5;">
                        <strong>15 días de prueba gratis</strong> con todas las características del plan elegido. Sin tarjeta de crédito.
                    </p>
                </div>

                <!-- Terms -->
                <div style="display:flex;align-items:flex-start;gap:10px;">
                    <input type="checkbox" id="terms" name="terms" required
                           style="width:15px;height:15px;margin-top:2px;accent-color:#2a7a52;cursor:pointer;">
                    <label for="terms" style="font-size:13px;color:#64748b;cursor:pointer;line-height:1.5;">
                        Acepto los
                        <a href="<?= BASE_URL ?>terms" style="color:#2a7a52;font-weight:600;text-decoration:none;">Términos de Servicio</a>
                        y la
                        <a href="<?= BASE_URL ?>privacy" style="color:#2a7a52;font-weight:600;text-decoration:none;">Política de Privacidad</a>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit"
                        style="width:100%;padding:13px;border-radius:10px;background:linear-gradient(135deg,#2a7a52,#1f5c3d);color:#fff;font-size:15px;font-weight:700;border:none;cursor:pointer;box-shadow:0 4px 16px rgba(42,122,82,0.3);transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px;"
                        onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 22px rgba(42,122,82,0.4)'"
                        onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 16px rgba(42,122,82,0.3)'">
                    <i class="fas fa-rocket"></i> Crear Tienda Gratis
                </button>
            </form>

            <p style="text-align:center;font-size:14px;color:#64748b;margin-top:20px;">
                ¿Ya tienes cuenta?
                <a href="<?= BASE_URL ?>auth/login" style="color:#2a7a52;font-weight:700;text-decoration:none;margin-left:4px;">Inicia sesión aquí</a>
            </p>
        </div>

        <div style="margin-top:32px;text-align:center;">
            <p style="font-size:12px;color:#cbd5e1;">
                &copy; <?= date('Y') ?> Kyros Commerce ·
                <a href="<?= BASE_URL ?>terms" style="color:#94a3b8;text-decoration:none;">Términos</a> ·
                <a href="<?= BASE_URL ?>privacy" style="color:#94a3b8;text-decoration:none;">Privacidad</a>
            </p>
        </div>
    </div>

</div><!-- /grid -->

<script>
function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const icon  = input.parentElement.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
</body>
</html>
