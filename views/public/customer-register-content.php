<style>
    /* ── Auth page reset ── */
    #mainContent { padding: 0 !important; }

    .auth-split {
        display: flex;
        min-height: calc(100vh - 68px);
    }

    /* ── LEFT PANEL ── */
    .auth-panel-left {
        flex: 0 0 42%;
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
        max-width: 380px;
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
        font-size: clamp(24px, 2.6vw, 36px);
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
        font-size: 14.5px;
        color: rgba(255,255,255,.58);
        line-height: 1.6;
        margin-bottom: 36px;
    }
    .auth-left-steps { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 18px; }
    .auth-left-steps li {
        display: flex; align-items: flex-start; gap: 14px;
    }
    .auth-step-num {
        width: 28px; height: 28px; border-radius: 50%;
        background: linear-gradient(135deg, rgba(212,151,58,.35), rgba(212,151,58,.15));
        border: 1px solid rgba(212,151,58,.4);
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 800; color: #fde68a;
        flex-shrink: 0; margin-top: 1px;
    }
    .auth-step-text strong {
        display: block; font-size: 13px; font-weight: 700;
        color: rgba(255,255,255,.88); margin-bottom: 2px;
    }
    .auth-step-text span { font-size: 12px; color: rgba(255,255,255,.48); }

    /* ── RIGHT PANEL ── */
    .auth-panel-right {
        flex: 1;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 48px 40px;
    }
    .auth-form-wrap {
        width: 100%;
        max-width: 500px;
    }
    .auth-form-header { margin-bottom: 28px; }
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
    .auth-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px 18px; }
    .auth-grid .full { grid-column: 1 / -1; }

    .auth-field { }
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

    .auth-section-label {
        font-size: 11px; font-weight: 800; color: #94a3b8;
        text-transform: uppercase; letter-spacing: .8px;
        margin: 4px 0 14px; display: flex; align-items: center; gap: 8px;
    }
    .auth-section-label::after {
        content: ''; flex: 1; height: 1px; background: #f0f4f8;
    }

    .auth-submit {
        width: 100%; padding: 13px;
        border: none; border-radius: 12px;
        background: linear-gradient(135deg, #2a7a52, #1f5c3d);
        color: #fff; font-weight: 800; font-size: 15px;
        font-family: 'Inter', sans-serif;
        cursor: pointer; margin-top: 4px;
        box-shadow: 0 6px 20px rgba(42,122,82,.35);
        transition: transform .15s, box-shadow .15s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .auth-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(42,122,82,.45);
    }
    .auth-submit:active { transform: translateY(0); }

    .auth-footer {
        margin-top: 20px; text-align: center;
        font-size: 13.5px; color: #64748b;
    }
    .auth-footer a {
        color: #2a7a52; font-weight: 700; text-decoration: none;
    }
    .auth-footer a:hover { text-decoration: underline; }

    .auth-terms {
        font-size: 11.5px; color: #94a3b8;
        text-align: center; margin-top: 14px; line-height: 1.6;
    }

    /* ── Responsive ── */
    @media (max-width: 960px) {
        .auth-split { flex-direction: column; min-height: unset; }
        .auth-panel-left {
            flex: none; padding: 32px 24px;
            min-height: 200px;
        }
        .auth-left-steps { display: none; }
        .auth-left-heading { font-size: 20px; }
        .auth-left-sub { font-size: 13px; margin-bottom: 0; }
        .auth-panel-right { padding: 32px 20px 48px; }
        .auth-grid { grid-template-columns: 1fr; }
        .auth-grid .full { grid-column: 1; }
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
                Únete y empieza<br>a <span>comprar mejor</span>
            </h2>
            <p class="auth-left-sub">
                Crea tu cuenta en segundos y accede a todos los beneficios de cliente.
            </p>

            <ul class="auth-left-steps">
                <li>
                    <div class="auth-step-num">1</div>
                    <div class="auth-step-text">
                        <strong>Llena tus datos</strong>
                        <span>Solo toma un minuto</span>
                    </div>
                </li>
                <li>
                    <div class="auth-step-num">2</div>
                    <div class="auth-step-text">
                        <strong>Confirma tu cuenta</strong>
                        <span>Acceso inmediato</span>
                    </div>
                </li>
                <li>
                    <div class="auth-step-num">3</div>
                    <div class="auth-step-text">
                        <strong>Empieza a comprar</strong>
                        <span>Tus pedidos y direcciones, siempre a la mano</span>
                    </div>
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

            <div class="auth-form-header">
                <h1 class="auth-form-title">Crear cuenta</h1>
                <p class="auth-form-sub">Regístrate en <?= htmlspecialchars($storeData['name'] ?? 'la tienda') ?> para gestionar tus pedidos.</p>
            </div>

            <div class="auth-card">
                <form method="POST" action="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>/customer/register">

                    <div class="auth-section-label">Información personal</div>

                    <div class="auth-grid">
                        <div class="auth-field full">
                            <label class="auth-label">
                                <i class="fa-regular fa-user"></i> Nombre completo
                            </label>
                            <input
                                class="auth-input"
                                type="text" name="name"
                                placeholder="Tu nombre y apellido"
                                autocomplete="name"
                                required>
                        </div>

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
                                <i class="fa-solid fa-phone"></i> Teléfono <small style="font-weight:400;color:#94a3b8;text-transform:none;letter-spacing:0">(opcional)</small>
                            </label>
                            <input
                                class="auth-input"
                                type="tel" name="phone"
                                placeholder="+52 000 000 0000"
                                autocomplete="tel">
                        </div>
                    </div>

                    <div class="auth-section-label" style="margin-top:22px;">Seguridad</div>

                    <div class="auth-grid">
                        <div class="auth-field">
                            <label class="auth-label">
                                <i class="fa-solid fa-lock"></i> Contraseña
                            </label>
                            <input
                                class="auth-input"
                                type="password" name="password"
                                placeholder="Mínimo 8 caracteres"
                                autocomplete="new-password"
                                required>
                        </div>

                        <div class="auth-field">
                            <label class="auth-label">
                                <i class="fa-solid fa-lock"></i> Confirmar contraseña
                            </label>
                            <input
                                class="auth-input"
                                type="password" name="password_confirm"
                                placeholder="Repite la contraseña"
                                autocomplete="new-password"
                                required>
                        </div>

                        <div class="auth-field full">
                            <button type="submit" class="auth-submit">
                                <i class="fa-solid fa-user-plus"></i>
                                Crear mi cuenta
                            </button>
                        </div>
                    </div>

                </form>
            </div>

            <p class="auth-footer">
                ¿Ya tienes cuenta?
                <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>/customer/login">Iniciar sesión</a>
            </p>
            <p class="auth-terms">
                Al registrarte aceptas los términos y condiciones de <?= htmlspecialchars($storeData['name'] ?? 'la tienda') ?>.
            </p>
        </div>
    </div>

</div>
