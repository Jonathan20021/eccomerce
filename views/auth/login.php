<?php
$page_title = "Iniciar Sesión — Kyros Commerce";
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
    <style>
        html, body { height: 100%; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
    </style>
</head>
<body>

<div style="min-height:100vh;display:grid;grid-template-columns:1fr 1fr;" class="max-lg:block">

    <!-- ====== LEFT PANEL (brand) ====== -->
    <div style="background:linear-gradient(145deg,#1e1b4b 0%,#312e81 40%,#4c1d95 70%,#1e40af 100%);
                position:relative;overflow:hidden;display:flex;flex-direction:column;justify-content:space-between;padding:48px;"
         class="hidden lg:flex">

        <!-- Background decorations -->
        <div style="position:absolute;top:-20%;right:-10%;width:500px;height:500px;background:radial-gradient(circle,rgba(139,92,246,.25) 0%,transparent 60%);border-radius:50%;pointer-events:none;"></div>
        <div style="position:absolute;bottom:-20%;left:-10%;width:400px;height:400px;background:radial-gradient(circle,rgba(59,130,246,.2) 0%,transparent 60%);border-radius:50%;pointer-events:none;"></div>

        <!-- Logo -->
        <a href="<?= BASE_URL ?>" style="display:flex;align-items:center;gap:10px;text-decoration:none;position:relative;z-index:1;">
            <div style="width:36px;height:36px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:16px;color:#fff;">K</div>
            <span style="font-size:20px;font-weight:800;color:#fff;letter-spacing:-0.5px;">Kyros Commerce</span>
        </a>

        <!-- Center content -->
        <div style="position:relative;z-index:1;">
            <div style="font-size:clamp(28px,3vw,40px);font-weight:900;color:#fff;line-height:1.15;letter-spacing:-1px;margin-bottom:18px;">
                Tu negocio online,<br>
                <span style="background:linear-gradient(135deg,#a78bfa,#60a5fa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">sin complicaciones</span>
            </div>
            <p style="font-size:16px;color:rgba(255,255,255,0.65);line-height:1.7;max-width:340px;">
                Miles de emprendedores ya confían en Kyros Commerce para vender online y hacer crecer su negocio.
            </p>

            <!-- Proof dots -->
            <div style="display:flex;align-items:center;gap:12px;margin-top:32px;">
                <div style="display:flex;">
                    <?php
                    $colors = ['#4f46e5','#7c3aed','#0891b2','#059669','#d97706'];
                    foreach ($colors as $c):
                    ?>
                    <div style="width:30px;height:30px;border-radius:50%;background:<?= $c ?>;border:2px solid rgba(255,255,255,.3);margin-left:-8px;first:margin-left:0;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;"></div>
                    <?php endforeach; ?>
                    <div style="width:30px;height:30px;border-radius:50%;background:rgba(255,255,255,.15);border:2px solid rgba(255,255,255,.3);margin-left:-8px;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;color:rgba(255,255,255,.8);">+5K</div>
                </div>
                <span style="font-size:13px;color:rgba(255,255,255,.6);">más de 5,000 tiendas activas</span>
            </div>
        </div>

        <!-- Bottom quote -->
        <div style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:14px;padding:20px;position:relative;z-index:1;">
            <p style="font-size:14px;color:rgba(255,255,255,.75);line-height:1.6;margin-bottom:14px;">
                "Kyros Commerce me permitió lanzar mi tienda en un fin de semana. Ahora vendo todos los días sin preocupaciones técnicas."
            </p>
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:34px;height:34px;border-radius:50%;background:#7c3aed;display:flex;align-items:center;justify-content:center;color:#fff;font-size:12px;font-weight:800;">AV</div>
                <div>
                    <div style="font-size:13px;font-weight:700;color:#fff;">Ana Vargas</div>
                    <div style="font-size:11px;color:rgba(255,255,255,.45);">Tienda de Bisutería</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== RIGHT PANEL (form) ====== -->
    <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px 24px;background:#fff;min-height:100vh;">

        <!-- Mobile logo -->
        <a href="<?= BASE_URL ?>" style="display:flex;align-items:center;gap:9px;text-decoration:none;margin-bottom:40px;" class="lg:hidden">
            <div style="width:32px;height:32px;background:linear-gradient(135deg,#4f46e5,#7c3aed);border-radius:9px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:14px;color:#fff;">K</div>
            <span style="font-size:17px;font-weight:800;color:#1e293b;">Kyros Commerce</span>
        </a>

        <div style="width:100%;max-width:400px;">
            <!-- Header -->
            <div style="margin-bottom:32px;">
                <h1 style="font-size:26px;font-weight:800;color:#1e293b;letter-spacing:-0.7px;margin-bottom:7px;">Bienvenido de vuelta</h1>
                <p style="font-size:14.5px;color:#64748b;">Inicia sesión en tu cuenta de Kyros Commerce</p>
            </div>

            <!-- Error message -->
            <?php if (isset($_GET['error'])): ?>
            <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:22px;display:flex;align-items:center;gap:10px;">
                <i class="fas fa-exclamation-circle" style="color:#dc2626;font-size:14px;flex-shrink:0;"></i>
                <p style="font-size:13.5px;color:#dc2626;font-weight:500;"><?= htmlspecialchars($_GET['error']) ?></p>
            </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;margin-bottom:22px;display:flex;align-items:center;gap:10px;">
                <i class="fas fa-check-circle" style="color:#16a34a;font-size:14px;flex-shrink:0;"></i>
                <p style="font-size:13.5px;color:#15803d;font-weight:500;"><?= htmlspecialchars($_GET['success']) ?></p>
            </div>
            <?php endif; ?>

            <!-- Form -->
            <form method="POST" id="login-form" style="display:flex;flex-direction:column;gap:18px;">
                <input type="hidden" name="demo_login_key" id="demo_login_key" value="">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" required
                           class="form-input"
                           placeholder="tu@email.com"
                           autocomplete="email">
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                        <label class="form-label" for="password" style="margin-bottom:0;">Contraseña</label>
                        <a href="<?= BASE_URL ?>auth/forgot-password" style="font-size:12.5px;color:#4f46e5;font-weight:600;text-decoration:none;">¿Olvidaste tu contraseña?</a>
                    </div>
                    <div style="position:relative;">
                        <input type="password" id="password" name="password" required
                               class="form-input"
                               placeholder="••••••••"
                               autocomplete="current-password"
                               style="padding-right:44px;">
                        <button type="button" onclick="togglePasswordVisibility('password', this)"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:#94a3b8;cursor:pointer;padding:4px;">
                            <i class="fas fa-eye text-sm" id="password-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        style="width:100%;padding:13px;border-radius:10px;background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;font-size:15px;font-weight:700;border:none;cursor:pointer;box-shadow:0 4px 16px rgba(79,70,229,0.3);transition:all .2s;"
                        onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 22px rgba(79,70,229,0.4)'"
                        onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 16px rgba(79,70,229,0.3)'">
                    Iniciar Sesión
                </button>
            </form>

            <?php if (!empty($showDemoBlock) && !empty($demoAccounts) && is_array($demoAccounts)): ?>
            <div style="margin-top:18px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:14px;">
                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                    <p style="font-size:12px;font-weight:800;letter-spacing:.4px;text-transform:uppercase;color:#475569;">Usuarios demo para pruebas</p>
                    <span style="font-size:11px;color:#64748b;">autocompletar o entrar directo</span>
                </div>
                <div style="display:grid;gap:8px;margin-top:10px;">
                    <?php foreach ($demoAccounts as $account): ?>
                    <div style="text-align:left;background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:10px;transition:all .15s;"
                         onmouseover="this.style.borderColor='#cbd5e1';this.style.transform='translateY(-1px)'"
                         onmouseout="this.style.borderColor='#e2e8f0';this.style.transform='none'">
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                            <span style="font-size:13px;font-weight:700;color:#1e293b;"><?= htmlspecialchars($account['name']) ?></span>
                            <span style="font-size:11px;font-weight:700;color:#475569;background:#eef2ff;border-radius:999px;padding:3px 8px;"><?= htmlspecialchars($account['role']) ?></span>
                        </div>
                        <div style="font-size:12px;color:#64748b;margin-top:4px;"><?= htmlspecialchars($account['email']) ?></div>
                        <?php if (!empty($showDemoPasswords)): ?>
                        <div style="font-size:12px;color:#334155;margin-top:2px;">Pass: <?= htmlspecialchars($account['password']) ?></div>
                        <?php endif; ?>
                        <div style="display:flex;gap:8px;margin-top:8px;">
                            <button type="button"
                                    onclick="fillDemoCredentials('<?= htmlspecialchars($account['email']) ?>', '<?= htmlspecialchars($account['password']) ?>')"
                                    style="border:1px solid #cbd5e1;background:#fff;color:#334155;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:600;cursor:pointer;">
                                Autocompletar
                            </button>
                            <button type="button"
                                    onclick="demoDirectLogin('<?= htmlspecialchars($account['key']) ?>')"
                                    style="border:1px solid #4f46e5;background:#4f46e5;color:#fff;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:700;cursor:pointer;">
                                Entrar como demo
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Divider -->
            <div style="display:flex;align-items:center;gap:12px;margin:24px 0;">
                <div style="flex:1;height:1px;background:#f1f5f9;"></div>
                <span style="font-size:12px;color:#94a3b8;font-weight:500;">o continúa con</span>
                <div style="flex:1;height:1px;background:#f1f5f9;"></div>
            </div>

            <!-- Register link -->
            <p style="text-align:center;font-size:14px;color:#64748b;">
                ¿No tienes una cuenta?
                <a href="<?= BASE_URL ?>auth/register" style="color:#4f46e5;font-weight:700;text-decoration:none;margin-left:4px;">
                    Regístrate gratis
                </a>
            </p>
        </div>

        <!-- Footer -->
        <div style="margin-top:40px;text-align:center;">
            <p style="font-size:12px;color:#cbd5e1;">
                &copy; <?= date('Y') ?> Kyros Commerce ·
                <a href="<?= BASE_URL ?>terms" style="color:#94a3b8;text-decoration:none;">Términos</a> ·
                <a href="<?= BASE_URL ?>privacy" style="color:#94a3b8;text-decoration:none;">Privacidad</a>
            </p>
        </div>
    </div>

</div><!-- /grid -->

<script>
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye','fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash','fa-eye');
    }
}

function fillDemoCredentials(email, password) {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const demoKeyInput = document.getElementById('demo_login_key');

    if (!emailInput || !passwordInput) return;

    emailInput.value = email;
    passwordInput.value = password;
    if (demoKeyInput) demoKeyInput.value = '';
    emailInput.focus();
}

function demoDirectLogin(demoKey) {
    const form = document.getElementById('login-form');
    const demoKeyInput = document.getElementById('demo_login_key');

    if (!form || !demoKeyInput) return;

    demoKeyInput.value = demoKey;
    form.submit();
}
</script>
</body>
</html>
