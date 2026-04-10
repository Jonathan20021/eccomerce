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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    /* ═══════════════════════════════════════════════
       BASE
    ═══════════════════════════════════════════════ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { height: 100%; }
    body {
        min-height: 100%;
        font-family: 'Inter', sans-serif;
        -webkit-font-smoothing: antialiased;
        background: #fff;
        color: #0f172a;
    }

    /* ═══════════════════════════════════════════════
       PAGE GRID
    ═══════════════════════════════════════════════ */
    .pg {
        display: grid;
        grid-template-columns: 480px 1fr;
        min-height: 100vh;
    }

    /* ═══════════════════════════════════════════════
       LEFT — BRAND PANEL
    ═══════════════════════════════════════════════ */
    .bp {
        position: relative; overflow: hidden;
        background: #071810;
        display: flex; flex-direction: column;
        padding: 36px 44px 40px;
    }
    .bp::before {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(155deg, transparent 0%, rgba(42,122,82,.55) 50%, rgba(31,92,61,.7) 100%);
        pointer-events: none;
    }
    .bp::after {
        content: ''; position: absolute; top: -120px; right: -120px;
        width: 520px; height: 520px; border-radius: 50%;
        background: radial-gradient(circle, rgba(212,151,58,.18) 0%, transparent 65%);
        pointer-events: none;
    }
    .bp-orb2 {
        position: absolute; bottom: -140px; left: -100px;
        width: 440px; height: 440px; border-radius: 50%;
        background: radial-gradient(circle, rgba(42,122,82,.32) 0%, transparent 65%);
        pointer-events: none;
    }
    .bp-grid {
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
        background-size: 44px 44px;
        pointer-events: none;
    }
    .bp-inner {
        position: relative; z-index: 2;
        display: flex; flex-direction: column; height: 100%;
    }
    .bp-logo {
        display: inline-flex; align-items: center; gap: 10px; text-decoration: none;
    }
    .bp-logo-mark {
        width: 38px; height: 38px; border-radius: 11px;
        background: rgba(255,255,255,.1); border: 1.5px solid rgba(255,255,255,.18);
        backdrop-filter: blur(8px);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; font-weight: 900; color: #fff;
    }
    .bp-logo-name { font-size: 18px; font-weight: 800; color: #fff; letter-spacing: -.3px; }

    .bp-hero {
        flex: 1; display: flex; flex-direction: column;
        justify-content: center; padding: 36px 0;
    }
    .bp-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(134,239,172,.1); border: 1px solid rgba(134,239,172,.2);
        color: #86efac; font-size: 10.5px; font-weight: 700;
        letter-spacing: .7px; text-transform: uppercase;
        padding: 4px 11px; border-radius: 9999px;
        margin-bottom: 20px; width: fit-content;
    }
    .bp-h1 {
        font-size: clamp(28px, 2.6vw, 40px);
        font-weight: 900; color: #fff;
        line-height: 1.08; letter-spacing: -1.2px;
        margin-bottom: 14px;
    }
    .bp-h1 span {
        background: linear-gradient(120deg, #86efac 0%, #fde68a 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }
    .bp-desc {
        font-size: 14.5px; color: rgba(255,255,255,.55);
        line-height: 1.7; max-width: 300px; margin-bottom: 28px;
    }
    .bp-list { display: flex; flex-direction: column; gap: 10px; }
    .bp-item {
        display: flex; align-items: center; gap: 10px;
        font-size: 13.5px; color: rgba(255,255,255,.72);
    }
    .bp-check {
        width: 20px; height: 20px; border-radius: 50%;
        background: rgba(134,239,172,.12); border: 1px solid rgba(134,239,172,.24);
        display: flex; align-items: center; justify-content: center;
        font-size: 8px; color: #86efac; flex-shrink: 0;
    }

    .bp-rating {
        border-top: 1px solid rgba(255,255,255,.08);
        padding-top: 20px; flex-shrink: 0;
    }
    .bp-stars { display: flex; align-items: center; gap: 2px; margin-bottom: 8px; }
    .bp-stars span { font-size: 13px; font-weight: 700; color: #fff; margin-left: 8px; }
    .bp-rating p { font-size: 12.5px; color: rgba(255,255,255,.45); line-height: 1.5; }

    /* ═══════════════════════════════════════════════
       RIGHT — FORM PANEL
    ═══════════════════════════════════════════════ */
    .fp {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 36px 32px;
        background: #fff;
        overflow-y: auto;
    }
    .fw {
        width: 100%;
        max-width: 480px;
        display: flex;
        flex-direction: column;
    }

    /* mobile logo */
    .mob-logo {
        display: none; align-items: center; gap: 9px;
        text-decoration: none; margin-bottom: 24px;
    }
    .mob-logo-mark {
        width: 34px; height: 34px; border-radius: 10px;
        background: linear-gradient(135deg, #2a7a52, #071810);
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; font-weight: 900; color: #fff;
    }
    .mob-logo-name { font-size: 17px; font-weight: 800; color: #0f172a; }

    /* heading */
    .fh { margin-bottom: 20px; }
    .fh-title { font-size: 23px; font-weight: 800; color: #0f172a; letter-spacing: -.5px; margin-bottom: 4px; }
    .fh-sub   { font-size: 14px; color: #64748b; }

    /* alert */
    .al {
        display: flex; align-items: flex-start; gap: 8px;
        padding: 11px 13px; border-radius: 10px;
        font-size: 13px; line-height: 1.5; margin-bottom: 16px;
    }
    .al-e { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    .al i  { flex-shrink: 0; margin-top: 1px; }

    /* section separator */
    .sec-sep {
        display: flex; align-items: center; gap: 10px;
        font-size: 10.5px; font-weight: 700; color: #9ca3af;
        text-transform: uppercase; letter-spacing: .7px;
        margin: 16px 0 12px;
    }
    .sec-sep:first-child { margin-top: 0; }
    .sec-sep::after { content: ''; flex: 1; height: 1px; background: #f0f4f8; }

    /* 2-col grid */
    .g2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .g2 .s2 { grid-column: 1 / -1; }

    /* field */
    .field {}
    .field > label {
        display: block; font-size: 13px; font-weight: 600;
        color: #374151; margin-bottom: 6px;
    }
    .field .opt { font-weight: 400; font-size: 11px; color: #9ca3af; margin-left: 3px; }
    .req { color: #ef4444; }

    /* input wrapper */
    .iw { position: relative; }
    .iw-icon {
        position: absolute; left: 13px; top: 50%;
        transform: translateY(-50%);
        font-size: 13px; color: #9ca3af; pointer-events: none;
    }
    .iw-inp {
        display: block; width: 100%;
        height: 44px; padding: 0 14px 0 38px;
        border: 1.5px solid #e5eaf2;
        border-radius: 10px;
        font-size: 14px; font-family: 'Inter', sans-serif;
        color: #0f172a; background: #fff;
        outline: none;
        transition: border-color .15s, box-shadow .15s, background .15s;
        appearance: none; -webkit-appearance: none;
    }
    .iw-inp::placeholder { color: #c4cdd8; }
    .iw-inp:hover  { border-color: #c8d4e3; }
    .iw-inp:focus  {
        border-color: #2a7a52;
        box-shadow: 0 0 0 3px rgba(42,122,82,.12);
        background: #fafffe;
    }
    .iw-inp.pr { padding-right: 42px; }
    .iw-inp.sel {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 13px center;
        padding-right: 36px;
    }
    .iw-eye {
        position: absolute; right: 13px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #9ca3af; padding: 2px;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; transition: color .15s;
    }
    .iw-eye:hover { color: #4b5563; }
    .hint { font-size: 11.5px; color: #9ca3af; margin-top: 4px; }

    /* plan cards */
    .plan-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-top: 0;
    }
    .plan-opt { display: none; }
    .plan-card {
        border: 1.5px solid #e5eaf2; border-radius: 10px;
        padding: 12px 10px; cursor: pointer;
        transition: border-color .15s, background .15s, box-shadow .15s;
        text-align: center; position: relative;
    }
    .plan-card:hover { border-color: #b0c4d8; }
    .plan-opt:checked + .plan-card {
        border-color: #2a7a52;
        background: #f0fdf4;
        box-shadow: 0 0 0 2px rgba(42,122,82,.15);
    }
    .plan-opt:checked + .plan-card .plan-check {
        opacity: 1;
        background: #2a7a52;
        border-color: #2a7a52;
    }
    .plan-opt:checked + .plan-card .plan-check i { color: #fff; }
    .plan-check {
        width: 18px; height: 18px; border-radius: 50%;
        border: 1.5px solid #d1d9e4; background: #fff;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 8px; opacity: .5;
        transition: all .15s; font-size: 9px;
    }
    .plan-name { font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 2px; }
    .plan-price { font-size: 11px; color: #64748b; font-weight: 500; }
    .plan-price strong { color: #0f172a; font-weight: 700; }
    .plan-badge {
        position: absolute; top: -8px; left: 50%; transform: translateX(-50%);
        background: linear-gradient(135deg, #2a7a52, #1c5438);
        color: #fff; font-size: 9px; font-weight: 800;
        letter-spacing: .4px; text-transform: uppercase;
        padding: 2px 8px; border-radius: 9999px; white-space: nowrap;
    }

    /* trial notice */
    .trial {
        display: flex; align-items: flex-start; gap: 9px;
        background: #f0fdf4; border: 1.5px solid #bbf7d0;
        border-radius: 10px; padding: 11px 13px;
        font-size: 13px; color: #166534; line-height: 1.5;
        margin-top: 14px;
    }
    .trial i { color: #2a7a52; flex-shrink: 0; font-size: 14px; margin-top: 1px; }

    /* terms */
    .terms-row {
        display: flex; align-items: flex-start; gap: 9px;
        font-size: 13px; color: #64748b; line-height: 1.55;
        margin-top: 12px; cursor: pointer;
    }
    .terms-row input {
        width: 15px; height: 15px; margin-top: 2px;
        accent-color: #2a7a52; cursor: pointer; flex-shrink: 0;
        border-radius: 4px;
    }
    .terms-row a { color: #2a7a52; font-weight: 600; text-decoration: none; }
    .terms-row a:hover { text-decoration: underline; }

    /* submit */
    .btn-go {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; height: 44px;
        border: none; border-radius: 10px;
        background: linear-gradient(135deg, #2a7a52 0%, #1c5438 100%);
        color: #fff; font-size: 15px; font-weight: 700;
        font-family: 'Inter', sans-serif; cursor: pointer;
        box-shadow: 0 2px 12px rgba(42,122,82,.3), 0 1px 2px rgba(42,122,82,.15);
        transition: transform .15s, box-shadow .15s;
        margin-top: 16px; letter-spacing: -.1px;
    }
    .btn-go:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(42,122,82,.38), 0 2px 6px rgba(42,122,82,.15);
    }
    .btn-go:active { transform: translateY(0); }

    /* footer */
    .ff { margin-top: 18px; text-align: center; font-size: 13.5px; color: #64748b; }
    .ff a { color: #2a7a52; font-weight: 700; text-decoration: none; margin-left: 4px; }
    .ff a:hover { text-decoration: underline; }
    .fc { margin-top: 12px; text-align: center; font-size: 11.5px; color: #b4bfcc; }
    .fc a { color: inherit; text-decoration: none; }
    .fc a:hover { color: #64748b; }

    /* ═══════════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════════ */
    @media (max-width: 1100px) {
        .pg { grid-template-columns: 400px 1fr; }
        .bp { padding: 32px 36px; }
    }
    @media (max-width: 860px) {
        .pg { grid-template-columns: 1fr; min-height: 100vh; }
        .bp { display: none; }
        .fp { padding: 32px 24px; align-items: flex-start; padding-top: 40px; }
        .mob-logo { display: flex; }
        .fw { max-width: 500px; margin: 0 auto; }
        .plan-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 580px) {
        .fp { padding: 24px 16px 36px; }
        .g2 { grid-template-columns: 1fr; }
        .g2 .s2 { grid-column: 1; }
        .plan-grid { grid-template-columns: 1fr; gap: 7px; }
        .plan-card { text-align: left; padding: 11px 14px; display: flex; align-items: center; gap: 10px; }
        .plan-check { margin: 0; flex-shrink: 0; }
        .plan-text { display: flex; flex-direction: column; }
        .plan-badge { position: static; transform: none; order: -1; }
    }
    @media (max-width: 360px) {
        .fh-title { font-size: 20px; }
    }
    </style>
</head>
<body>
<div class="pg">

    <!-- ████ LEFT ████ -->
    <aside class="bp" aria-hidden="true">
        <div class="bp-orb2"></div>
        <div class="bp-grid"></div>
        <div class="bp-inner">

            <a href="<?= BASE_URL ?>" class="bp-logo">
                <div class="bp-logo-mark">K</div>
                <span class="bp-logo-name">Kyros Commerce</span>
            </a>

            <div class="bp-hero">
                <div class="bp-badge"><i class="fa-solid fa-rocket fa-xs"></i> Empieza gratis</div>
                <h1 class="bp-h1">Empieza a vender<br><span>hoy mismo</span></h1>
                <p class="bp-desc">Crea tu tienda online en minutos. Sin tarjeta de crédito, sin complicaciones técnicas.</p>
                <div class="bp-list">
                    <div class="bp-item"><span class="bp-check"><i class="fa-solid fa-check"></i></span>15 días de prueba gratis en todos los planes</div>
                    <div class="bp-item"><span class="bp-check"><i class="fa-solid fa-check"></i></span>Sin tarjeta de crédito requerida</div>
                    <div class="bp-item"><span class="bp-check"><i class="fa-solid fa-check"></i></span>Cancela cuando quieras, sin penalizaciones</div>
                    <div class="bp-item"><span class="bp-check"><i class="fa-solid fa-check"></i></span>Soporte incluido desde el primer día</div>
                </div>
            </div>

            <div class="bp-rating">
                <div class="bp-stars">
                    <i class="fa-solid fa-star" style="color:#fbbf24;font-size:12px;"></i>
                    <i class="fa-solid fa-star" style="color:#fbbf24;font-size:12px;"></i>
                    <i class="fa-solid fa-star" style="color:#fbbf24;font-size:12px;"></i>
                    <i class="fa-solid fa-star" style="color:#fbbf24;font-size:12px;"></i>
                    <i class="fa-solid fa-star" style="color:#fbbf24;font-size:12px;"></i>
                    <span>4.9 / 5</span>
                </div>
                <p>Más de 500 reseñas de 5 estrellas en plataformas de tecnología.</p>
            </div>

        </div>
    </aside>

    <!-- ████ RIGHT ████ -->
    <main class="fp">
        <div class="fw">

            <a href="<?= BASE_URL ?>" class="mob-logo">
                <div class="mob-logo-mark">K</div>
                <span class="mob-logo-name">Kyros Commerce</span>
            </a>

            <div class="fh">
                <h2 class="fh-title">Crea tu cuenta gratis</h2>
                <p class="fh-sub">Únete a Kyros Commerce y comienza a vender en línea hoy.</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
            <div class="al al-e"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>

            <form method="POST" novalidate>

                <!-- PERSONAL INFO -->
                <div class="sec-sep">Información personal</div>
                <div class="g2">
                    <div class="field">
                        <label>Nombre completo <span class="req">*</span></label>
                        <div class="iw">
                            <i class="fa-regular fa-user iw-icon"></i>
                            <input class="iw-inp" type="text" name="name" placeholder="Juan Pérez" autocomplete="name" required>
                        </div>
                    </div>
                    <div class="field">
                        <label>Teléfono <span class="opt">(opcional)</span></label>
                        <div class="iw">
                            <i class="fa-solid fa-phone iw-icon"></i>
                            <input class="iw-inp" type="tel" name="phone" placeholder="+52 000 000 0000" autocomplete="tel">
                        </div>
                    </div>
                    <div class="field s2">
                        <label>Correo electrónico <span class="req">*</span></label>
                        <div class="iw">
                            <i class="fa-regular fa-envelope iw-icon"></i>
                            <input class="iw-inp" type="email" name="email" placeholder="tu@email.com" autocomplete="email" required>
                        </div>
                    </div>
                </div>

                <!-- PASSWORD -->
                <div class="sec-sep">Contraseña</div>
                <div class="g2">
                    <div class="field">
                        <label>Contraseña <span class="req">*</span></label>
                        <div class="iw">
                            <i class="fa-solid fa-lock iw-icon"></i>
                            <input class="iw-inp pr" type="password" id="pw1" name="password" placeholder="••••••••" autocomplete="new-password" required>
                            <button type="button" class="iw-eye" onclick="tpw('pw1',this)" aria-label="Mostrar"><i class="fa-regular fa-eye"></i></button>
                        </div>
                        <p class="hint">Mínimo 6 caracteres</p>
                    </div>
                    <div class="field">
                        <label>Confirmar <span class="req">*</span></label>
                        <div class="iw">
                            <i class="fa-solid fa-lock iw-icon"></i>
                            <input class="iw-inp pr" type="password" id="pw2" name="password_confirm" placeholder="••••••••" autocomplete="new-password" required>
                            <button type="button" class="iw-eye" onclick="tpw('pw2',this)" aria-label="Mostrar"><i class="fa-regular fa-eye"></i></button>
                        </div>
                    </div>
                </div>

                <!-- PLAN -->
                <div class="sec-sep">Plan de inicio</div>
                <div class="plan-grid">
                    <label>
                        <input class="plan-opt" type="radio" name="plan_id" value="1" <?= $plan !== 'professional' && $plan !== 'enterprise' ? 'checked' : '' ?>>
                        <div class="plan-card">
                            <div class="plan-check"><i class="fa-solid fa-check"></i></div>
                            <div class="plan-text">
                                <div class="plan-name">Starter</div>
                                <div class="plan-price"><strong>Gratis</strong> · 50 prod.</div>
                            </div>
                        </div>
                    </label>
                    <label>
                        <input class="plan-opt" type="radio" name="plan_id" value="2" <?= $plan === 'professional' ? 'checked' : '' ?>>
                        <div class="plan-card">
                            <div class="plan-badge">Popular</div>
                            <div class="plan-check"><i class="fa-solid fa-check"></i></div>
                            <div class="plan-text">
                                <div class="plan-name">Professional</div>
                                <div class="plan-price"><strong>$99</strong>/mes · 500 prod.</div>
                            </div>
                        </div>
                    </label>
                    <label>
                        <input class="plan-opt" type="radio" name="plan_id" value="3" <?= $plan === 'enterprise' ? 'checked' : '' ?>>
                        <div class="plan-card">
                            <div class="plan-check"><i class="fa-solid fa-check"></i></div>
                            <div class="plan-text">
                                <div class="plan-name">Enterprise</div>
                                <div class="plan-price"><strong>$299</strong>/mes · ∞</div>
                            </div>
                        </div>
                    </label>
                </div>

                <div class="trial">
                    <i class="fa-solid fa-gift"></i>
                    <span><strong>15 días de prueba gratis</strong> con todas las características del plan elegido. Sin tarjeta de crédito requerida.</span>
                </div>

                <label class="terms-row">
                    <input type="checkbox" name="terms" required>
                    Acepto los <a href="<?= BASE_URL ?>terms">Términos de Servicio</a> y la <a href="<?= BASE_URL ?>privacy">Política de Privacidad</a>
                </label>

                <button type="submit" class="btn-go">
                    <i class="fa-solid fa-rocket"></i> Crear Tienda Gratis
                </button>

            </form>

            <p class="ff">¿Ya tienes cuenta?<a href="<?= BASE_URL ?>auth/login">Inicia sesión aquí</a></p>
            <p class="fc">&copy; <?= date('Y') ?> Kyros Commerce &nbsp;·&nbsp; <a href="<?= BASE_URL ?>terms">Términos</a> &nbsp;·&nbsp; <a href="<?= BASE_URL ?>privacy">Privacidad</a></p>

        </div>
    </main>

</div>
<script>
function tpw(id, btn) {
    const el = document.getElementById(id), ic = btn.querySelector('i');
    if (!el || !ic) return;
    el.type = el.type === 'password' ? 'text' : 'password';
    ic.classList.toggle('fa-eye');
    ic.classList.toggle('fa-eye-slash');
}
</script>
</body>
</html>
