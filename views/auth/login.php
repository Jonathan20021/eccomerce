<?php $page_title = "Iniciar Sesión — Kyros Commerce"; ?>
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
        position: relative;
        overflow: hidden;
        background: #071810;
        display: flex;
        flex-direction: column;
        padding: 36px 44px 40px;
    }

    /* layered gradient */
    .bp::before {
        content: '';
        position: absolute; inset: 0;
        background:
            linear-gradient(155deg, transparent 0%, rgba(42,122,82,.55) 50%, rgba(31,92,61,.7) 100%);
        pointer-events: none;
    }
    /* gold orb top-right */
    .bp::after {
        content: '';
        position: absolute; top: -120px; right: -120px;
        width: 520px; height: 520px; border-radius: 50%;
        background: radial-gradient(circle, rgba(212,151,58,.18) 0%, transparent 65%);
        pointer-events: none;
    }
    /* green orb bottom-left */
    .bp-orb2 {
        position: absolute; bottom: -140px; left: -100px;
        width: 440px; height: 440px; border-radius: 50%;
        background: radial-gradient(circle, rgba(42,122,82,.32) 0%, transparent 65%);
        pointer-events: none;
    }
    /* subtle grid texture */
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
        display: flex; flex-direction: column;
        height: 100%;
    }

    /* logo */
    .bp-logo {
        display: inline-flex; align-items: center; gap: 10px;
        text-decoration: none; flex-shrink: 0;
    }
    .bp-logo-mark {
        width: 38px; height: 38px; border-radius: 11px;
        background: rgba(255,255,255,.1);
        border: 1.5px solid rgba(255,255,255,.18);
        backdrop-filter: blur(8px);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; font-weight: 900; color: #fff;
    }
    .bp-logo-name {
        font-size: 18px; font-weight: 800; color: #fff; letter-spacing: -.3px;
    }

    /* center hero copy */
    .bp-hero {
        flex: 1; display: flex; flex-direction: column;
        justify-content: center; padding: 40px 0;
    }
    .bp-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(134,239,172,.1);
        border: 1px solid rgba(134,239,172,.2);
        color: #86efac; font-size: 10.5px; font-weight: 700;
        letter-spacing: .7px; text-transform: uppercase;
        padding: 4px 11px; border-radius: 9999px;
        margin-bottom: 20px; width: fit-content;
    }
    .bp-h1 {
        font-size: clamp(30px, 2.8vw, 42px);
        font-weight: 900; color: #fff;
        line-height: 1.08; letter-spacing: -1.2px;
        margin-bottom: 14px;
    }
    .bp-h1 span {
        background: linear-gradient(120deg, #86efac 0%, #fde68a 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .bp-desc {
        font-size: 15px; color: rgba(255,255,255,.55);
        line-height: 1.7; max-width: 300px; margin-bottom: 32px;
    }
    .bp-list { display: flex; flex-direction: column; gap: 11px; }
    .bp-item {
        display: flex; align-items: center; gap: 10px;
        font-size: 13.5px; color: rgba(255,255,255,.72);
    }
    .bp-check {
        width: 20px; height: 20px; border-radius: 50%;
        background: rgba(134,239,172,.12);
        border: 1px solid rgba(134,239,172,.24);
        display: flex; align-items: center; justify-content: center;
        font-size: 8px; color: #86efac; flex-shrink: 0;
    }

    /* testimonial bottom */
    .bp-quote {
        border-top: 1px solid rgba(255,255,255,.08);
        padding-top: 20px; flex-shrink: 0;
    }
    .bp-quote-stars {
        display: flex; gap: 2px; margin-bottom: 10px;
    }
    .bp-quote-text {
        font-size: 13px; color: rgba(255,255,255,.65);
        line-height: 1.65; font-style: italic; margin-bottom: 10px;
    }
    .bp-quote-author {
        display: flex; align-items: center; gap: 8px;
    }
    .bp-quote-avatar {
        width: 30px; height: 30px; border-radius: 50%;
        background: linear-gradient(135deg, #2a7a52, #fde68a);
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 800; color: #fff; flex-shrink: 0;
    }
    .bp-quote-name { font-size: 12px; font-weight: 700; color: rgba(255,255,255,.5); }

    /* ═══════════════════════════════════════════════
       RIGHT — FORM PANEL
    ═══════════════════════════════════════════════ */
    .fp {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 32px;
        background: #fff;
        overflow-y: auto;
    }
    .fw {
        width: 100%;
        max-width: 400px;
        display: flex;
        flex-direction: column;
    }

    /* mobile logo */
    .mob-logo {
        display: none;
        align-items: center; gap: 9px;
        text-decoration: none; margin-bottom: 28px;
    }
    .mob-logo-mark {
        width: 34px; height: 34px; border-radius: 10px;
        background: linear-gradient(135deg, #2a7a52, #071810);
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; font-weight: 900; color: #fff;
    }
    .mob-logo-name { font-size: 17px; font-weight: 800; color: #0f172a; }

    /* heading */
    .fh { margin-bottom: 22px; }
    .fh-title {
        font-size: 24px; font-weight: 800; color: #0f172a;
        letter-spacing: -.6px; margin-bottom: 5px;
    }
    .fh-sub { font-size: 14px; color: #64748b; line-height: 1.5; }

    /* alert */
    .al {
        display: flex; align-items: flex-start; gap: 9px;
        padding: 11px 13px; border-radius: 10px;
        font-size: 13px; line-height: 1.5;
        margin-bottom: 18px;
    }
    .al-e { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    .al-s { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .al i  { flex-shrink: 0; margin-top: 1px; }

    /* form fields stack */
    .stack { display: flex; flex-direction: column; gap: 14px; }

    /* single field */
    .field {}
    .field-lrow {
        display: flex; align-items: center;
        justify-content: space-between; gap: 8px;
        margin-bottom: 6px;
    }
    .field-label {
        font-size: 13px; font-weight: 600; color: #374151;
    }
    .field-link {
        font-size: 12px; font-weight: 600; color: #2a7a52;
        text-decoration: none; white-space: nowrap;
    }
    .field-link:hover { text-decoration: underline; }

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
    }
    .iw-inp::placeholder { color: #c4cdd8; }
    .iw-inp:hover  { border-color: #c8d4e3; }
    .iw-inp:focus  {
        border-color: #2a7a52;
        box-shadow: 0 0 0 3px rgba(42,122,82,.12);
        background: #fafffe;
    }
    .iw-inp.pr { padding-right: 42px; }
    .iw-eye {
        position: absolute; right: 13px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #9ca3af; padding: 2px;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; transition: color .15s;
    }
    .iw-eye:hover { color: #4b5563; }

    /* primary button */
    .btn-go {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; height: 44px;
        border: none; border-radius: 10px;
        background: linear-gradient(135deg, #2a7a52 0%, #1c5438 100%);
        color: #fff; font-size: 15px; font-weight: 700;
        font-family: 'Inter', sans-serif; cursor: pointer;
        box-shadow: 0 2px 12px rgba(42,122,82,.3), 0 1px 2px rgba(42,122,82,.15);
        transition: transform .15s, box-shadow .15s;
        letter-spacing: -.1px;
    }
    .btn-go:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(42,122,82,.38), 0 2px 6px rgba(42,122,82,.15);
    }
    .btn-go:active { transform: translateY(0); }

    /* demo accounts */
    .demo {
        margin-top: 18px;
        border-radius: 12px;
        overflow: hidden;
        border: 1.5px solid #dae5f0;
    }
    .demo-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 14px;
        background: linear-gradient(135deg, #0d2035 0%, #1b3d5c 100%);
    }
    .demo-head-lbl {
        font-size: 10.5px; font-weight: 800;
        letter-spacing: .6px; text-transform: uppercase; color: #cbd5e1;
    }
    .demo-head-cnt {
        font-size: 11px; font-weight: 700; color: #e2e8f0;
        background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.16);
        padding: 2px 8px; border-radius: 9999px;
    }
    .demo-body { background: #f5f9fd; padding: 12px; }
    .demo-hint { font-size: 12px; color: #64748b; margin-bottom: 10px; line-height: 1.5; }
    .demo-list { display: flex; flex-direction: column; gap: 8px; }
    .demo-card {
        background: #fff; border: 1.5px solid #dce7f3;
        border-radius: 10px; padding: 11px 12px;
        transition: border-color .18s, box-shadow .18s, transform .18s;
    }
    .demo-card:hover {
        border-color: #a8c8e8;
        box-shadow: 0 4px 14px rgba(15,23,42,.07);
        transform: translateY(-1px);
    }
    .demo-card-top {
        display: flex; align-items: center;
        justify-content: space-between; gap: 8px;
        margin-bottom: 4px;
    }
    .demo-card-name { font-size: 13px; font-weight: 700; color: #0f172a; }
    .demo-card-role {
        font-size: 10px; font-weight: 700; color: #166534;
        background: #dcfce7; border: 1px solid #86efac;
        padding: 2px 7px; border-radius: 9999px; white-space: nowrap;
    }
    .demo-card-email {
        font-size: 12px; color: #64748b;
        display: flex; align-items: center; gap: 5px;
        margin-bottom: 9px;
    }
    .demo-card-email i { font-size: 10px; color: #9ca3af; }
    .demo-card-pw {
        font-size: 12px; color: #64748b;
        display: flex; align-items: center; gap: 5px;
        margin-bottom: 9px;
    }
    .demo-card-pw i { font-size: 10px; color: #9ca3af; }
    .demo-card-btns { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; }
    .db {
        height: 32px; border-radius: 8px;
        font-size: 12px; font-weight: 700;
        font-family: 'Inter', sans-serif;
        cursor: pointer; transition: all .15s;
        display: flex; align-items: center; justify-content: center;
    }
    .db-o {
        background: #f8fafc; border: 1.5px solid #d1d9e4; color: #374151;
    }
    .db-o:hover { background: #f1f5f9; border-color: #94a3b8; }
    .db-f {
        background: linear-gradient(135deg, #2a7a52, #1c5438);
        border: none; color: #fff;
        box-shadow: 0 2px 8px rgba(42,122,82,.22);
    }
    .db-f:hover { box-shadow: 0 4px 14px rgba(42,122,82,.36); transform: translateY(-1px); }
    .demo-note {
        margin-top: 9px; font-size: 11px; color: #9ca3af;
        display: flex; align-items: center; gap: 5px;
    }

    /* divider */
    .divider {
        display: flex; align-items: center; gap: 12px;
        margin: 20px 0 0;
    }
    .divider::before, .divider::after {
        content: ''; flex: 1; height: 1px; background: #f0f4f8;
    }
    .divider span { font-size: 12px; color: #94a3b8; white-space: nowrap; }

    /* footer */
    .ff { margin-top: 20px; text-align: center; font-size: 13.5px; color: #64748b; }
    .ff a { color: #2a7a52; font-weight: 700; text-decoration: none; margin-left: 4px; }
    .ff a:hover { text-decoration: underline; }
    .fc { margin-top: 14px; text-align: center; font-size: 11.5px; color: #b4bfcc; }
    .fc a { color: inherit; text-decoration: none; }
    .fc a:hover { color: #64748b; }

    /* ═══════════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════════ */

    /* tablet landscape → hide brand panel */
    @media (max-width: 1100px) {
        .pg { grid-template-columns: 400px 1fr; }
        .bp { padding: 32px 36px; }
        .bp-desc { font-size: 14px; }
    }
    @media (max-width: 860px) {
        .pg { grid-template-columns: 1fr; min-height: 100vh; }
        .bp { display: none; }
        .fp { padding: 32px 24px; align-items: flex-start; padding-top: 40px; }
        .mob-logo { display: flex; }
        .fw { max-width: 440px; margin: 0 auto; }
    }
    @media (max-width: 520px) {
        .fp { padding: 24px 16px 32px; }
        .demo-card-btns { grid-template-columns: 1fr; }
    }
    @media (max-width: 360px) {
        .fh-title { font-size: 21px; }
        .iw-inp  { font-size: 13.5px; }
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
                <div class="bp-badge"><i class="fa-solid fa-bolt fa-xs"></i> Plataforma SaaS</div>
                <h1 class="bp-h1">Vende online<br>con <span>control total</span></h1>
                <p class="bp-desc">Plataforma SaaS para crear, gestionar y escalar tu tienda sin fricción.</p>
                <div class="bp-list">
                    <div class="bp-item"><span class="bp-check"><i class="fa-solid fa-check"></i></span>Panel de ventas en tiempo real</div>
                    <div class="bp-item"><span class="bp-check"><i class="fa-solid fa-check"></i></span>Gestión de pedidos y catálogo</div>
                    <div class="bp-item"><span class="bp-check"><i class="fa-solid fa-check"></i></span>Reportes, métricas y analíticas</div>
                </div>
            </div>

            <div class="bp-quote">
                <div class="bp-quote-stars">
                    <i class="fa-solid fa-star" style="color:#fbbf24;font-size:12px;"></i>
                    <i class="fa-solid fa-star" style="color:#fbbf24;font-size:12px;"></i>
                    <i class="fa-solid fa-star" style="color:#fbbf24;font-size:12px;"></i>
                    <i class="fa-solid fa-star" style="color:#fbbf24;font-size:12px;"></i>
                    <i class="fa-solid fa-star" style="color:#fbbf24;font-size:12px;"></i>
                </div>
                <p class="bp-quote-text">"Con Kyros lanzamos en días y ahora operamos con procesos claros y reportes en tiempo real."</p>
                <div class="bp-quote-author">
                    <div class="bp-quote-avatar">E</div>
                    <span class="bp-quote-name">Equipo Operativo — Cliente Kyros</span>
                </div>
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
                <h2 class="fh-title">Bienvenido de vuelta</h2>
                <p class="fh-sub">Inicia sesión en tu cuenta de Kyros Commerce.</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
            <div class="al al-e"><i class="fa-solid fa-circle-exclamation"></i><?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['success'])): ?>
            <div class="al al-s"><i class="fa-solid fa-circle-check"></i><?= htmlspecialchars($_GET['success']) ?></div>
            <?php endif; ?>

            <form method="POST" id="lf" novalidate>
                <input type="hidden" name="demo_login_key" id="dlk" value="">
                <div class="stack">

                    <div class="field">
                        <div class="field-lrow">
                            <label class="field-label" for="email">Correo electrónico</label>
                        </div>
                        <div class="iw">
                            <i class="fa-regular fa-envelope iw-icon"></i>
                            <input class="iw-inp" type="email" id="email" name="email"
                                   placeholder="tu@email.com" autocomplete="email" required>
                        </div>
                    </div>

                    <div class="field">
                        <div class="field-lrow">
                            <label class="field-label" for="pwd">Contraseña</label>
                            <a class="field-link" href="<?= BASE_URL ?>auth/forgot-password">¿Olvidaste tu contraseña?</a>
                        </div>
                        <div class="iw">
                            <i class="fa-solid fa-lock iw-icon"></i>
                            <input class="iw-inp pr" type="password" id="pwd" name="password"
                                   placeholder="••••••••" autocomplete="current-password" required>
                            <button type="button" class="iw-eye" onclick="tpw('pwd',this)" aria-label="Mostrar contraseña">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-go">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Iniciar Sesión
                    </button>

                </div>
            </form>

            <?php if (!empty($showDemoBlock) && !empty($demoAccounts) && is_array($demoAccounts)): ?>
            <div class="demo">
                <div class="demo-head">
                    <span class="demo-head-lbl">Accesos Demo</span>
                    <span class="demo-head-cnt"><?= count($demoAccounts) ?> cuentas</span>
                </div>
                <div class="demo-body">
                    <p class="demo-hint">Usa cuentas de prueba para entrar rápido y validar el flujo.</p>
                    <div class="demo-list">
                    <?php foreach ($demoAccounts as $a):
                        $rl = ($a['role'] ?? '') === ROLE_STORE_OWNER ? 'Propietario de tienda'
                            : ucfirst(str_replace('_',' ',strval($a['role'] ?? '')));
                    ?>
                        <div class="demo-card">
                            <div class="demo-card-top">
                                <span class="demo-card-name"><?= htmlspecialchars($a['name']) ?></span>
                                <span class="demo-card-role"><?= htmlspecialchars($rl) ?></span>
                            </div>
                            <div class="demo-card-email">
                                <i class="fa-regular fa-envelope"></i><?= htmlspecialchars($a['email']) ?>
                            </div>
                            <?php if (!empty($showDemoPasswords)): ?>
                            <div class="demo-card-pw">
                                <i class="fa-solid fa-key"></i><?= htmlspecialchars($a['password']) ?>
                            </div>
                            <?php endif; ?>
                            <div class="demo-card-btns">
                                <button class="db db-o" onclick="fd('<?= htmlspecialchars($a['email']) ?>','<?= htmlspecialchars($a['password']) ?>')">Autocompletar</button>
                                <button class="db db-f" onclick="ld('<?= htmlspecialchars($a['key']) ?>')">Entrar como demo</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <p class="demo-note"><i class="fa-solid fa-shield-halved"></i> Cuentas temporales, sujetas a reinicio.</p>
                </div>
            </div>
            <?php endif; ?>

            <p class="ff">¿No tienes cuenta?<a href="<?= BASE_URL ?>auth/register">Regístrate gratis</a></p>
            <p class="fc">&copy; <?= date('Y') ?> Kyros Commerce &nbsp;·&nbsp; <a href="<?= BASE_URL ?>terms">Términos</a> &nbsp;·&nbsp; <a href="<?= BASE_URL ?>privacy">Privacidad</a></p>

        </div>
    </main>

</div>
<script>
function tpw(id, btn) {
    const el = document.getElementById(id), ic = btn.querySelector('i');
    el.type = el.type === 'password' ? 'text' : 'password';
    ic.classList.toggle('fa-eye');
    ic.classList.toggle('fa-eye-slash');
}
function fd(e, p) {
    document.getElementById('email').value = e;
    document.getElementById('pwd').value   = p;
    document.getElementById('dlk').value   = '';
    document.getElementById('email').focus();
}
function ld(k) {
    document.getElementById('dlk').value = k;
    document.getElementById('lf').submit();
}
</script>
</body>
</html>
