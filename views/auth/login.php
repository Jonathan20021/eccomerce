<?php
$page_title = "Iniciar Sesion - Kyros Commerce";
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
        :root {
            --bg-soft: #f4f7fb;
            --ink-900: #0f172a;
            --ink-700: #334155;
            --ink-500: #64748b;
            --line: #dbe5f1;
            --brand: #1f7a53;
            --brand-dark: #166241;
            --navy: #12314d;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-soft);
        }

        .auth-shell {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border: 1px solid #e6edf5;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.08);
        }

        .demo-panel {
            margin-top: 18px;
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow: hidden;
            background: #f7fbff;
        }

        .demo-panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 11px 13px;
            background: linear-gradient(135deg, #15324c 0%, #20486b 100%);
        }

        .demo-panel-body {
            padding: 12px;
        }

        .demo-list {
            margin-top: 10px;
            display: grid;
            gap: 9px;
        }

        .demo-item {
            border: 1px solid #d8e4f2;
            border-radius: 11px;
            background: #fff;
            padding: 11px;
            transition: all .18s ease;
        }

        .demo-item:hover {
            border-color: #bbcee4;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
            transform: translateY(-1px);
        }

        .demo-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .demo-role {
            font-size: 10px;
            font-weight: 800;
            color: #166534;
            background: #dcfce7;
            border: 1px solid #86efac;
            border-radius: 999px;
            padding: 2px 8px;
            white-space: nowrap;
        }

        .demo-meta {
            margin-top: 5px;
            color: var(--ink-500);
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .demo-meta span {
            min-width: 0;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .demo-actions {
            margin-top: 9px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .demo-btn {
            border-radius: 9px;
            padding: 8px 10px;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: all .16s ease;
        }

        .demo-btn-light {
            border: 1px solid #cbd5e1;
            color: var(--ink-700);
            background: #f8fafc;
        }

        .demo-btn-light:hover {
            border-color: #94a3b8;
            background: #f1f5f9;
        }

        .demo-btn-main {
            border: 1px solid var(--brand);
            color: #fff;
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
            box-shadow: 0 5px 14px rgba(31, 122, 83, 0.25);
        }

        .demo-btn-main:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(31, 122, 83, 0.34);
        }

        @media (max-width: 640px) {
            .demo-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="auth-split-layout">

    <div class="auth-brand-panel" style="background:linear-gradient(145deg,#0f2234 0%,#12314d 42%,#1f7a53 78%,#166241 100%);position:relative;overflow:hidden;display:flex;flex-direction:column;justify-content:space-between;padding:48px;">
        <div style="position:absolute;top:-20%;right:-10%;width:500px;height:500px;background:radial-gradient(circle,rgba(98,190,151,.24) 0%,transparent 60%);border-radius:50%;pointer-events:none;"></div>
        <div style="position:absolute;bottom:-20%;left:-10%;width:400px;height:400px;background:radial-gradient(circle,rgba(255,255,255,.15) 0%,transparent 60%);border-radius:50%;pointer-events:none;"></div>

        <a href="<?= BASE_URL ?>" style="display:flex;align-items:center;gap:10px;text-decoration:none;position:relative;z-index:1;">
            <div style="width:36px;height:36px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:16px;color:#fff;">K</div>
            <span style="font-size:20px;font-weight:800;color:#fff;letter-spacing:-0.4px;">Kyros Commerce</span>
        </a>

        <div style="position:relative;z-index:1;">
            <div style="font-size:clamp(28px,3vw,40px);font-weight:900;color:#fff;line-height:1.15;letter-spacing:-1px;margin-bottom:16px;">
                Vende online con
                <span style="color:#c9f7e1;">control total</span>
            </div>
            <p style="font-size:16px;color:rgba(255,255,255,0.78);line-height:1.7;max-width:360px;">
                Plataforma SaaS para crear, gestionar y escalar tu tienda sin friccion.
            </p>
        </div>

        <div style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);border-radius:14px;padding:18px;position:relative;z-index:1;">
            <p style="font-size:13px;color:rgba(255,255,255,0.82);line-height:1.55;margin-bottom:10px;">
                "Con Kyros lanzamos en dias y ahora operamos con procesos claros y reportes en tiempo real."
            </p>
            <div style="font-size:12px;color:rgba(255,255,255,.6);font-weight:700;">Equipo Operativo - Cliente Kyros</div>
        </div>
    </div>

    <div class="auth-form-panel" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px 24px;background:#fff;min-height:100vh;">

        <a href="<?= BASE_URL ?>" class="auth-mobile-logo" style="display:flex;align-items:center;gap:9px;text-decoration:none;margin-bottom:38px;">
            <div style="width:32px;height:32px;background:linear-gradient(135deg,#1f7a53,#12314d);border-radius:9px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:14px;color:#fff;">K</div>
            <span style="font-size:17px;font-weight:800;color:#1e293b;">Kyros Commerce</span>
        </a>

        <div class="auth-shell">
            <div style="margin-bottom:28px;">
                <h1 style="font-size:30px;font-weight:900;color:var(--ink-900);letter-spacing:-0.7px;margin-bottom:7px;">Bienvenido de vuelta</h1>
                <p style="font-size:14px;color:var(--ink-500);">Inicia sesion en tu cuenta de Kyros Commerce.</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
            <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
                <i class="fas fa-exclamation-circle" style="color:#dc2626;font-size:14px;flex-shrink:0;"></i>
                <p style="font-size:13px;color:#b91c1c;font-weight:600;"><?= htmlspecialchars($_GET['error']) ?></p>
            </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
                <i class="fas fa-check-circle" style="color:#16a34a;font-size:14px;flex-shrink:0;"></i>
                <p style="font-size:13px;color:#166534;font-weight:600;"><?= htmlspecialchars($_GET['success']) ?></p>
            </div>
            <?php endif; ?>

            <form method="POST" id="login-form" style="display:flex;flex-direction:column;gap:16px;">
                <input type="hidden" name="demo_login_key" id="demo_login_key" value="">

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" for="email">Correo electronico</label>
                    <input type="email" id="email" name="email" required class="form-input" placeholder="tu@email.com" autocomplete="email">
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;gap:10px;">
                        <label class="form-label" for="password" style="margin-bottom:0;">Contrasena</label>
                        <a href="<?= BASE_URL ?>auth/forgot-password" style="font-size:12px;color:#2a7a52;font-weight:700;text-decoration:none;">Olvidaste tu contrasena?</a>
                    </div>
                    <div style="position:relative;">
                        <input type="password" id="password" name="password" required class="form-input" placeholder="********" autocomplete="current-password" style="padding-right:44px;">
                        <button type="button" onclick="togglePasswordVisibility('password', this)" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:#94a3b8;cursor:pointer;padding:4px;">
                            <i class="fas fa-eye text-sm" id="password-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" style="width:100%;padding:13px;border-radius:10px;background:linear-gradient(135deg,#1f7a53,#166241);color:#fff;font-size:15px;font-weight:800;border:none;cursor:pointer;box-shadow:0 6px 18px rgba(31,122,83,0.26);transition:all .2s;" onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 9px 24px rgba(31,122,83,0.34)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 6px 18px rgba(31,122,83,0.26)'">
                    Iniciar Sesion
                </button>
            </form>

            <?php if (!empty($showDemoBlock) && !empty($demoAccounts) && is_array($demoAccounts)): ?>
            <div class="demo-panel">
                <div class="demo-panel-head">
                    <p style="font-size:12px;font-weight:800;letter-spacing:.45px;text-transform:uppercase;color:#e2e8f0;">Accesos Demo</p>
                    <span style="font-size:11px;color:#e2e8f0;background:rgba(255,255,255,0.14);padding:3px 8px;border-radius:999px;font-weight:700;border:1px solid rgba(255,255,255,0.2);">
                        <?= count($demoAccounts) ?> cuentas
                    </span>
                </div>
                <div class="demo-panel-body">
                    <p style="font-size:12px;color:var(--ink-500);line-height:1.45;">Usa cuentas de prueba para entrar rapido y validar el flujo.</p>

                    <div class="demo-list">
                    <?php foreach ($demoAccounts as $account): ?>
                    <?php
                        $roleText = ($account['role'] ?? '') === ROLE_STORE_OWNER ? 'Propietario de tienda' : ucfirst(str_replace('_', ' ', strval($account['role'] ?? '')));
                    ?>
                        <div class="demo-item">
                            <div class="demo-row">
                                <span style="font-size:13px;font-weight:800;color:var(--ink-900);"><?= htmlspecialchars($account['name']) ?></span>
                                <span class="demo-role"><?= htmlspecialchars($roleText) ?></span>
                            </div>

                            <div class="demo-meta">
                                <i class="fas fa-envelope" style="font-size:10px;color:#94a3b8;"></i>
                                <span><?= htmlspecialchars($account['email']) ?></span>
                            </div>

                            <?php if (!empty($showDemoPasswords)): ?>
                            <div class="demo-meta">
                                <i class="fas fa-key" style="font-size:10px;color:#94a3b8;"></i>
                                <span><?= htmlspecialchars($account['password']) ?></span>
                            </div>
                            <?php endif; ?>

                            <div class="demo-actions">
                                <button type="button" class="demo-btn demo-btn-light" onclick="fillDemoCredentials('<?= htmlspecialchars($account['email']) ?>', '<?= htmlspecialchars($account['password']) ?>')">
                                    Autocompletar
                                </button>
                                <button type="button" class="demo-btn demo-btn-main" onclick="demoDirectLogin('<?= htmlspecialchars($account['key']) ?>')">
                                    Entrar como demo
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>

                    <div style="margin-top:10px;font-size:11px;color:var(--ink-500);display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-shield-alt" style="font-size:10px;color:#94a3b8;"></i>
                        <span>Cuentas temporales para pruebas, sujetas a reinicio.</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div style="display:flex;align-items:center;gap:12px;margin:24px 0;">
                <div style="flex:1;height:1px;background:#e8eef5;"></div>
                <span style="font-size:12px;color:#94a3b8;font-weight:600;">o continua con</span>
                <div style="flex:1;height:1px;background:#e8eef5;"></div>
            </div>

            <p style="text-align:center;font-size:14px;color:var(--ink-500);">
                No tienes una cuenta?
                <a href="<?= BASE_URL ?>auth/register" style="color:#1f7a53;font-weight:800;text-decoration:none;margin-left:4px;">Registrate gratis</a>
            </p>
        </div>

        <div style="margin-top:34px;text-align:center;">
            <p style="font-size:12px;color:#94a3b8;">
                &copy; <?= date('Y') ?> Kyros Commerce |
                <a href="<?= BASE_URL ?>terms" style="color:#94a3b8;text-decoration:none;">Terminos</a> |
                <a href="<?= BASE_URL ?>privacy" style="color:#94a3b8;text-decoration:none;">Privacidad</a>
            </p>
        </div>
    </div>

</div>

<script>
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
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
