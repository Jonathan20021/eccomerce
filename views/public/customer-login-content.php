<style>
    /* ── Auth page reset ── */
    #mainContent { padding: 0 !important; }

    .auth-split {
        display: flex;
        min-height: calc(100vh - 68px);
    }

    /* ── LEFT PANEL ── */
    .auth-panel-left {
        flex: 0 0 48%;
        background: linear-gradient(145deg, #0c1f12 0%, #1a4a2e 45%, #2a7a52 100%);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 48px;
    }
    .auth-panel-left::before {
        content: '';
        position: absolute;
        top: -15%; right: -15%;
        width: 480px; height: 480px;
        background: radial-gradient(circle, rgba(212,151,58,.18) 0%, transparent 65%);
        border-radius: 50%;
        pointer-events: none;
    }
    .auth-panel-left::after {
        content: '';
        position: absolute;
        bottom: -20%; left: -15%;
        width: 380px; height: 380px;
        background: radial-gradient(circle, rgba(42,122,82,.45) 0%, transparent 65%);
        border-radius: 50%;
        pointer-events: none;
    }
    .auth-left-inner {
        position: relative; z-index: 2;
        max-width: 400px;
    }
    .auth-store-badge {
        display: inline-flex; align-items: center; gap: 10px;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.14);
        backdrop-filter: blur(8px);
        padding: 8px 16px; border-radius: 9999px;
        margin-bottom: 32px;
    }
    .auth-store-badge-icon {
        width: 32px; height: 32px; border-radius: 9px;
        background: linear-gradient(135deg, #2a7a52, #1f5c3d);
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 900; color: #fff;
        box-shadow: 0 4px 12px rgba(42,122,82,.4);
        flex-shrink: 0;
        overflow: hidden;
    }
    .auth-store-badge-icon img { width: 100%; height: 100%; object-fit: cover; border-radius: 9px; }
    .auth-store-badge-name { font-size: 13px; font-weight: 700; color: rgba(255,255,255,.9); }

    .auth-left-heading {
        font-size: clamp(26px, 2.8vw, 38px);
        font-weight: 900;
        color: #fff;
        line-height: 1.15;
        letter-spacing: -.8px;
        margin-bottom: 14px;
    }
    .auth-left-heading span {
        background: linear-gradient(135deg, #86efac, #fde68a);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .auth-left-sub {
        font-size: 15px;
        color: rgba(255,255,255,.58);
        line-height: 1.6;
        margin-bottom: 36px;
    }
    .auth-left-features { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 14px; }
    .auth-left-features li {
        display: flex; align-items: center; gap: 12px;
        font-size: 13.5px; color: rgba(255,255,255,.75); font-weight: 500;
    }
    .auth-feat-icon {
        width: 30px; height: 30px; border-radius: 8px;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.12);
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; color: #86efac; flex-shrink: 0;
    }

    /* ── RIGHT PANEL ── */
    .auth-panel-right {
        flex: 1;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 40px;
    }
    .auth-form-wrap {
        width: 100%;
        max-width: 420px;
    }
    .auth-form-header { margin-bottom: 32px; }
    .auth-form-title {
        font-size: 26px; font-weight: 800;
        color: #0f172a; letter-spacing: -.5px;
        margin-bottom: 6px;
    }
    .auth-form-sub { font-size: 14px; color: #64748b; line-height: 1.5; }

    .auth-alert {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 14px; border-radius: 10px;
        font-size: 13px; line-height: 1.5;
        margin-bottom: 20px;
    }
    .auth-alert.error  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    .auth-alert.success{ background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .auth-alert i { margin-top: 1px; flex-shrink: 0; }

    .auth-card {
        background: #fff;
        border: 1.5px solid #e8f0f7;
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 4px 24px rgba(15,23,42,.06);
    }
    .auth-field { margin-bottom: 18px; }
    .auth-label {
        display: flex; align-items: center; gap: 6px;
        font-size: 12.5px; font-weight: 700;
        color: #334155; margin-bottom: 7px;
        text-transform: uppercase; letter-spacing: .4px;
    }
    .auth-label i { color: #94a3b8; font-size: 11px; }
    .auth-input {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 11px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        color: #0f172a;
        background: #fff;
        transition: border-color .15s, box-shadow .15s;
        outline: none;
    }
    .auth-input:focus {
        border-color: #2a7a52;
        box-shadow: 0 0 0 3px rgba(42,122,82,.12);
    }
    .auth-input::placeholder { color: #c0ccda; }

    .auth-submit {
        width: 100%; padding: 13px;
        border: none; border-radius: 12px;
        background: linear-gradient(135deg, #2a7a52, #1f5c3d);
        color: #fff; font-weight: 800; font-size: 15px;
        font-family: 'Inter', sans-serif;
        cursor: pointer; margin-top: 6px;
        box-shadow: 0 6px 20px rgba(42,122,82,.35);
        transition: transform .15s, box-shadow .15s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .auth-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(42,122,82,.45);
    }
    .auth-submit:active { transform: translateY(0); }

    .auth-divider {
        display: flex; align-items: center; gap: 12px;
        margin: 20px 0; color: #cbd5e1; font-size: 12px;
    }
    .auth-divider::before, .auth-divider::after {
        content: ''; flex: 1; height: 1px; background: #e8f0f7;
    }

    .auth-footer {
        margin-top: 20px; text-align: center;
        font-size: 13.5px; color: #64748b;
    }
    .auth-footer a {
        color: #2a7a52; font-weight: 700; text-decoration: none;
    }
    .auth-footer a:hover { text-decoration: underline; }

    /* ── Responsive ── */
    @media (max-width: 900px) {
        .auth-split { flex-direction: column; min-height: unset; }
        .auth-panel-left {
            flex: none;
            padding: 36px 24px;
            min-height: 220px;
        }
        .auth-left-features { display: none; }
        .auth-left-heading { font-size: 22px; }
        .auth-left-sub { display: none; }
        .auth-panel-right { padding: 32px 20px 48px; }
    }
</style>

<div class="auth-split">

    <!-- LEFT: Decorative panel -->
    <div class="auth-panel-left">
        <div class="auth-left-inner">

            <div class="auth-store-badge">
                <div class="auth-store-badge-icon">
                    <?php if (!empty($storeData['logo'])): ?>
                        <img src="<?= ASSETS_PATH ?>uploads/logos/<?= htmlspecialchars($storeData['logo']) ?>" alt="">
                    <?php else: ?>
                        <?= strtoupper(substr($storeData['name'] ?? 'T', 0, 1)) ?>
                    <?php endif; ?>
                </div>
                <span class="auth-store-badge-name"><?= htmlspecialchars($storeData['name'] ?? 'La Tienda') ?></span>
            </div>

            <h2 class="auth-left-heading">
                Tu cuenta,<br><span>todo en un lugar</span>
            </h2>
            <p class="auth-left-sub">
                Accede a tu historial de pedidos, gestiona tus direcciones y sigue tus compras en tiempo real.
            </p>

            <ul class="auth-left-features">
                <li>
                    <div class="auth-feat-icon"><i class="fa-solid fa-bag-shopping"></i></div>
                    Historial completo de pedidos
                </li>
                <li>
                    <div class="auth-feat-icon"><i class="fa-solid fa-location-dot"></i></div>
                    Guarda tus direcciones de entrega
                </li>
                <li>
                    <div class="auth-feat-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    Acceso seguro y privado
                </li>
            </ul>
        </div>
    </div>

    <!-- RIGHT: Form -->
    <div class="auth-panel-right">
        <div class="auth-form-wrap">

            <?php if (isset($_GET['error'])): ?>
            <div class="auth-alert error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
            <div class="auth-alert success">
                <i class="fa-solid fa-circle-check"></i>
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
            <?php endif; ?>

            <div class="auth-form-header">
                <h1 class="auth-form-title">Iniciar sesión</h1>
                <p class="auth-form-sub">Bienvenido de vuelta a <?= htmlspecialchars($storeData['name'] ?? 'la tienda') ?>.</p>
            </div>

            <div class="auth-card">
                <form method="POST" action="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>/customer/login">

                    <div class="auth-field">
                        <label class="auth-label">
                            <i class="fa-regular fa-envelope"></i> Correo electrónico
                        </label>
                        <input
                            class="auth-input"
                            type="email" name="email"
                            placeholder="tu@correo.com"
                            autocomplete="email"
                            required>
                    </div>

                    <div class="auth-field">
                        <label class="auth-label">
                            <i class="fa-solid fa-lock"></i> Contraseña
                        </label>
                        <input
                            class="auth-input"
                            type="password" name="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required>
                    </div>

                    <button type="submit" class="auth-submit">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        Entrar a mi cuenta
                    </button>
                </form>
            </div>

            <p class="auth-footer">
                ¿No tienes cuenta?
                <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>/customer/register">Crear cuenta gratis</a>
            </p>
        </div>
    </div>

</div>
