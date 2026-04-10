<?php
/* ─────────────────────────────────────────────────────────
   views/superadmin/emails-content.php
   Módulo de administración de correos – Kyros Commerce
   ───────────────────────────────────────────────────────── */

$success = htmlspecialchars($_GET['success'] ?? '');
$error   = htmlspecialchars($_GET['error']   ?? '');

$es = $emailSettings ?? [];

$smtpEnabled = ($es['notifications_enabled'] ?? '0') === '1';

$emailTypes = [
    'test'                  => ['icon' => '🚀', 'label' => 'Prueba SMTP',            'desc'  => 'Verifica que la conexión SMTP funciona.'],
    'welcome'               => ['icon' => '🎉', 'label' => 'Bienvenida (usuario)',    'desc'  => 'Enviado al nuevo usuario al registrarse.'],
    'new_registration_admin'=> ['icon' => '👤', 'label' => 'Nuevo registro (admin)',  'desc'  => 'Notifica al administrador de un nuevo registro.'],
    'new_order_admin'       => ['icon' => '🛒', 'label' => 'Nueva orden (admin)',     'desc'  => 'Notifica al administrador de una nueva orden.'],
    'order_confirmation'    => ['icon' => '✅', 'label' => 'Confirmación de orden',   'desc'  => 'Enviado al cliente al completar su compra.'],
    'forgot_password'       => ['icon' => '🔐', 'label' => 'Recuperación de acceso', 'desc'  => 'Enviado cuando alguien solicita recuperar su cuenta.'],
];
?>

<style>
.emails-page { max-width: 960px; }

/* ── Page header ── */
.emails-header {
    background: linear-gradient(135deg, #0c1f12 0%, #1a4a2e 60%, #2a7a52 100%);
    border-radius: 20px;
    padding: 32px 36px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 20px;
}
.emails-header-icon {
    width: 60px; height: 60px;
    background: rgba(255,255,255,0.12);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; flex-shrink: 0;
}
.emails-header h1 { margin: 0; font-size: 22px; font-weight: 800; color: #fff; }
.emails-header p  { margin: 4px 0 0; font-size: 13px; color: rgba(255,255,255,0.65); }

/* ── Section cards ── */
.email-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    margin-bottom: 24px;
    overflow: hidden;
}
.email-card-head {
    padding: 20px 28px 16px;
    border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; gap: 12px;
}
.email-card-head-icon {
    width: 40px; height: 40px;
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border: 1.5px solid #bbf7d0;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.email-card-head h2 { margin: 0; font-size: 15px; font-weight: 700; color: #1e293b; }
.email-card-head p  { margin: 2px 0 0; font-size: 12px; color: #64748b; }
.email-card-body { padding: 24px 28px; }

/* ── Status badge ── */
.status-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 12px; border-radius: 20px;
    font-size: 12px; font-weight: 700;
    background: #ecfdf5; color: #2a7a52; border: 1px solid #bbf7d0;
}
.status-pill.off { background: #fef2f2; color: #dc2626; border-color: #fecaca; }

/* ── Form elements ── */
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
.form-row-3 { grid-template-columns: repeat(3,1fr); }
.form-row-full { grid-template-columns: 1fr; }
@media (max-width: 640px) { .form-row, .form-row-3 { grid-template-columns: 1fr; } }

.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group label {
    font-size: 12px; font-weight: 700;
    color: #475569; text-transform: uppercase; letter-spacing: 0.4px;
}
.form-group input,
.form-group select {
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
    color: #1e293b;
    background: #fff;
    transition: border-color .15s;
    outline: none; width: 100%; box-sizing: border-box;
}
.form-group input:focus,
.form-group select:focus { border-color: #2a7a52; box-shadow: 0 0 0 3px rgba(42,122,82,.1); }
.form-group .hint { font-size: 11px; color: #94a3b8; }

.pw-wrap { position: relative; }
.pw-wrap input  { padding-right: 40px; }
.pw-toggle {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer; color: #94a3b8; font-size: 14px;
    padding: 2px;
}
.pw-toggle:hover { color: #2a7a52; }

/* ── Toggle switch ── */
.toggle-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 0; border-bottom: 1px solid #f1f5f9;
}
.toggle-row:last-child { border-bottom: none; }
.toggle-info strong { font-size: 13px; font-weight: 700; color: #1e293b; display: block; }
.toggle-info span   { font-size: 11px; color: #64748b; display: block; margin-top: 2px; }
.toggle-switch { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
.toggle-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
.toggle-slider {
    position: absolute; inset: 0; background: #e2e8f0;
    border-radius: 12px; cursor: pointer; transition: background .2s;
}
.toggle-slider::before {
    content: '';
    position: absolute; width: 18px; height: 18px; left: 3px; bottom: 3px;
    background: #fff; border-radius: 50%; transition: transform .2s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.toggle-switch input:checked + .toggle-slider { background: #2a7a52; }
.toggle-switch input:checked + .toggle-slider::before { transform: translateX(20px); }

/* ── Buttons ── */
.btn-save {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 24px; border-radius: 10px;
    font-size: 14px; font-weight: 700; cursor: pointer;
    border: none; transition: opacity .15s;
}
.btn-save:hover { opacity: .88; }
.btn-primary { background: linear-gradient(135deg, #2a7a52, #1f5c3d); color: #fff; }
.btn-gold    { background: linear-gradient(135deg, #d4973a, #b57d2f); color: #fff; }
.btn-ghost {
    background: #f8fafc; border: 1.5px solid #e2e8f0; color: #475569;
}
.btn-ghost:hover { border-color: #2a7a52; color: #2a7a52; }

/* ── Template preview grid ── */
.preview-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; }
@media (max-width: 700px) { .preview-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 480px) { .preview-grid { grid-template-columns: 1fr; } }

.preview-card {
    border: 1.5px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; text-decoration: none; transition: border-color .15s, box-shadow .15s;
    display: block;
}
.preview-card:hover { border-color: #2a7a52; box-shadow: 0 4px 20px rgba(42,122,82,.12); }
.preview-card-top {
    padding: 20px 16px;
    background: linear-gradient(135deg, #0c1f12, #1a4a2e);
    text-align: center;
}
.preview-card-icon { font-size: 28px; display: block; margin-bottom: 6px; }
.preview-card-label { font-size: 12px; font-weight: 700; color: rgba(255,255,255,.9); }
.preview-card-bottom { padding: 12px 16px; background: #fff; }
.preview-card-desc { font-size: 11px; color: #64748b; line-height: 1.4; }
.preview-card-cta {
    margin-top: 8px; font-size: 11px; font-weight: 700; color: #2a7a52;
    display: flex; align-items: center; gap: 4px;
}

/* ── Alert ── */
.alert { padding: 14px 20px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; font-weight: 500; }
.alert-success { background: #ecfdf5; border: 1px solid #bbf7d0; color: #2a7a52; }
.alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

/* ── Test form ── */
.test-row { display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end; }
.test-row .form-group { flex: 1; min-width: 160px; }
.test-row .btn-save { margin-top: 22px; white-space: nowrap; }
</style>

<div class="emails-page">

<!-- ── Header ── -->
<div class="emails-header">
    <div class="emails-header-icon">📧</div>
    <div>
        <h1>Administración de Correos</h1>
        <p>Configura el servidor SMTP, gestiona destinatarios y prueba cada plantilla de notificación.</p>
    </div>
    <div style="margin-left:auto;flex-shrink:0;">
        <?php if ($smtpEnabled): ?>
            <div class="status-pill">&#9679; Correos activos</div>
        <?php else: ?>
            <div class="status-pill off">&#9675; Correos inactivos</div>
        <?php endif; ?>
    </div>
</div>

<?php if ($success): ?>
    <div class="alert alert-success">✅ <?= $success ?></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="alert alert-error">❌ <?= $error ?></div>
<?php endif; ?>

<!-- ════════════════════════════════════════
     FORM: Configuración SMTP + Destinatarios + Eventos
     ═══════════════════════════════════════ -->
<form method="POST" action="<?= BASE_URL ?>superadmin/emails">

    <!-- ── 1. Configuración SMTP ── -->
    <div class="email-card">
        <div class="email-card-head">
            <div class="email-card-head-icon">⚙️</div>
            <div>
                <h2>Configuración SMTP</h2>
                <p>Servidor saliente de correo (cPanel, Gmail, Sendgrid…)</p>
            </div>
            <div style="margin-left:auto;">
                <label class="toggle-switch" style="display:inline-block;">
                    <input type="checkbox" name="notifications_enabled" value="1"
                           <?= $smtpEnabled ? 'checked' : '' ?>>
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>
        <div class="email-card-body">

            <div class="form-row">
                <div class="form-group">
                    <label>Nombre del remitente</label>
                    <input type="text" name="notifications_from_name"
                           value="<?= htmlspecialchars($es['notifications_from_name'] ?? 'Kyros Commerce') ?>"
                           placeholder="Kyros Commerce">
                </div>
                <div class="form-group">
                    <label>Email del remitente</label>
                    <input type="email" name="notifications_from_email"
                           value="<?= htmlspecialchars($es['notifications_from_email'] ?? '') ?>"
                           placeholder="notificaciones@tudominio.com">
                </div>
            </div>

            <div class="form-row form-row-3">
                <div class="form-group">
                    <label>Servidor SMTP</label>
                    <input type="text" name="notifications_smtp_host"
                           value="<?= htmlspecialchars($es['notifications_smtp_host'] ?? '') ?>"
                           placeholder="mail.tudominio.com">
                </div>
                <div class="form-group">
                    <label>Puerto</label>
                    <input type="number" name="notifications_smtp_port"
                           value="<?= htmlspecialchars($es['notifications_smtp_port'] ?? '465') ?>"
                           placeholder="465">
                </div>
                <div class="form-group">
                    <label>Seguridad</label>
                    <select name="notifications_smtp_security">
                        <?php foreach (['ssl' => 'SSL (465)', 'tls' => 'TLS/STARTTLS (587)', 'none' => 'Sin cifrado (25)'] as $val => $lbl): ?>
                            <option value="<?= $val ?>" <?= ($es['notifications_smtp_security'] ?? 'ssl') === $val ? 'selected' : '' ?>>
                                <?= $lbl ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Usuario SMTP</label>
                    <input type="text" name="notifications_smtp_username"
                           value="<?= htmlspecialchars($es['notifications_smtp_username'] ?? '') ?>"
                           placeholder="notificaciones@tudominio.com"
                           autocomplete="username">
                </div>
                <div class="form-group">
                    <label>Contraseña SMTP</label>
                    <div class="pw-wrap">
                        <input type="password" name="notifications_smtp_password"
                               id="smtp_password_field"
                               placeholder="Déjalo en blanco para conservar la actual"
                               autocomplete="current-password">
                        <button type="button" class="pw-toggle" onclick="togglePw()" title="Mostrar/ocultar">
                            <i class="fas fa-eye" id="pw-eye"></i>
                        </button>
                    </div>
                    <span class="hint">Si no escribes nada, la contraseña actual se conserva.</span>
                </div>
            </div>

        </div>
    </div>

    <!-- ── 2. Destinatario global + por evento ── -->
    <div class="email-card">
        <div class="email-card-head">
            <div class="email-card-head-icon">👤</div>
            <div>
                <h2>Destinatarios de Notificaciones</h2>
                <p>Define quién recibe cada tipo de alerta. Usa comas para múltiples correos.</p>
            </div>
        </div>
        <div class="email-card-body">

            <div class="form-row form-row-full" style="margin-bottom:20px;">
                <div class="form-group">
                    <label>Destinatario global (fallback)</label>
                    <input type="email" name="notifications_admin_recipient"
                           value="<?= htmlspecialchars($es['notifications_admin_recipient'] ?? '') ?>"
                           placeholder="admin@tudominio.com">
                    <span class="hint">Se usará cuando no haya destinatarios específicos configurados para un evento.</span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Avisos de nuevos registros</label>
                    <input type="text" name="registration_recipients"
                           value="<?= htmlspecialchars($es['registration_recipients'] ?? '') ?>"
                           placeholder="admin@ejemplo.com, ventas@ejemplo.com">
                    <span class="hint">Correos separados por coma. Se recomienda al menos uno.</span>
                </div>
                <div class="form-group">
                    <label>Avisos de nuevas órdenes</label>
                    <input type="text" name="order_recipients"
                           value="<?= htmlspecialchars($es['order_recipients'] ?? '') ?>"
                           placeholder="pedidos@ejemplo.com, admin@ejemplo.com">
                    <span class="hint">Correos que recibirán alerta cuando entre un pedido.</span>
                </div>
            </div>

        </div>
    </div>

    <!-- ── 3. Eventos activos ── -->
    <div class="email-card">
        <div class="email-card-head">
            <div class="email-card-head-icon">🔔</div>
            <div>
                <h2>Eventos Activos</h2>
                <p>Activa o desactiva cada tipo de notificación de forma independiente.</p>
            </div>
        </div>
        <div class="email-card-body" style="padding-top:4px;">

            <?php
            $toggles = [
                'notify_new_registration'   => ['Nuevo registro',              'Envía alerta al admin cuando alguien crea una cuenta.'],
                'notify_customer_welcome'   => ['Bienvenida al usuario',       'Envía un correo de bienvenida al nuevo usuario.'],
                'notify_new_order'          => ['Nueva orden (admin)',         'Notifica al admin cuando entra un pedido nuevo.'],
                'notify_customer_order_copy'=> ['Confirmación al cliente',     'Envía confirmación de compra al cliente.'],
                'notify_forgot_password'    => ['Solicitud de recuperación',   'Notifica cuando alguien intenta recuperar su cuenta.'],
            ];
            foreach ($toggles as $name => [$title, $desc]):
                $checked = ($es[$name] ?? '0') === '1';
            ?>
            <div class="toggle-row">
                <div class="toggle-info">
                    <strong><?= htmlspecialchars($title) ?></strong>
                    <span><?= htmlspecialchars($desc) ?></span>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="<?= $name ?>" value="1" <?= $checked ? 'checked' : '' ?>>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <?php endforeach; ?>

        </div>
    </div>

    <div style="display:flex;justify-content:flex-end;margin-bottom:32px;">
        <button type="submit" class="btn-save btn-primary">
            <i class="fas fa-save"></i> Guardar configuración
        </button>
    </div>

</form>

<!-- ════════════════════════════════════════
     FORM: Envío de prueba
     ═══════════════════════════════════════ -->
<div class="email-card">
    <div class="email-card-head">
        <div class="email-card-head-icon">🧪</div>
        <div>
            <h2>Enviar Correo de Prueba</h2>
            <p>Elige el tipo de plantilla y el destinatario para verificar el diseño y la entrega.</p>
        </div>
    </div>
    <div class="email-card-body">
        <form method="POST" action="<?= BASE_URL ?>superadmin/emails">
            <div class="test-row">
                <div class="form-group">
                    <label>Tipo de correo</label>
                    <select name="test_type" id="test_type_select" onchange="updatePreviewBtn()">
                        <?php foreach ($emailTypes as $key => $info): ?>
                            <option value="<?= $key ?>"><?= $info['icon'] ?> <?= htmlspecialchars($info['label']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Email destinatario</label>
                    <input type="email" name="test_email"
                           placeholder="tu@correo.com"
                           value="<?= htmlspecialchars($es['notifications_admin_recipient'] ?? '') ?>"
                           required>
                </div>
                <button type="submit" name="send_test_email" class="btn-save btn-gold">
                    <i class="fas fa-paper-plane"></i> Enviar prueba
                </button>
                <a id="preview-btn" href="<?= BASE_URL ?>superadmin/emails/preview?type=test"
                   target="_blank" class="btn-save btn-ghost">
                    <i class="fas fa-eye"></i> Vista previa
                </a>
            </div>
        </form>
    </div>
</div>

<!-- ════════════════════════════════════════
     Grid de vista previa de plantillas
     ═══════════════════════════════════════ -->
<div class="email-card">
    <div class="email-card-head">
        <div class="email-card-head-icon">🎨</div>
        <div>
            <h2>Plantillas de Correo</h2>
            <p>Haz clic en cualquier tarjeta para ver la plantilla en el navegador.</p>
        </div>
    </div>
    <div class="email-card-body">
        <div class="preview-grid">
            <?php foreach ($emailTypes as $key => $info): ?>
            <a href="<?= BASE_URL ?>superadmin/emails/preview?type=<?= $key ?>"
               target="_blank" class="preview-card">
                <div class="preview-card-top">
                    <span class="preview-card-icon"><?= $info['icon'] ?></span>
                    <span class="preview-card-label"><?= htmlspecialchars($info['label']) ?></span>
                </div>
                <div class="preview-card-bottom">
                    <div class="preview-card-desc"><?= htmlspecialchars($info['desc']) ?></div>
                    <div class="preview-card-cta"><i class="fas fa-external-link-alt" style="font-size:9px;"></i> Abrir preview</div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

</div><!-- /emails-page -->

<script>
function togglePw() {
    var f = document.getElementById('smtp_password_field');
    var e = document.getElementById('pw-eye');
    if (f.type === 'password') {
        f.type = 'text';
        e.className = 'fas fa-eye-slash';
    } else {
        f.type = 'password';
        e.className = 'fas fa-eye';
    }
}

function updatePreviewBtn() {
    var type = document.getElementById('test_type_select').value;
    var btn  = document.getElementById('preview-btn');
    btn.href = '<?= BASE_URL ?>superadmin/emails/preview?type=' + type;
}
</script>
