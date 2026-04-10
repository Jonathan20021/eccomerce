<div style="display:flex;flex-direction:column;gap:20px;max-width:760px;">

    <div class="card">
        <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
            <h3><i class="fas fa-cog" style="color:#2a7a52;margin-right:7px;"></i>Configuración de Plataforma</h3>
            <span class="badge badge-indigo">Super Admin</span>
        </div>
        <div class="card-body">
            <p style="font-size:13px;color:#64748b;line-height:1.6;margin:0;">
                Ajustes globales de la plataforma Kyros Commerce. Para configurar el servidor de correos,
                <a href="<?= BASE_URL ?>superadmin/emails" style="color:#2a7a52;font-weight:600;">ve al módulo de Correos</a>.
            </p>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 14px;color:#15803d;font-size:13px;font-weight:600;">
        <i class="fas fa-check-circle" style="margin-right:6px;"></i>
        <?= htmlspecialchars($_GET['success']) ?>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 14px;color:#b91c1c;font-size:13px;font-weight:600;">
        <i class="fas fa-exclamation-circle" style="margin-right:6px;"></i>
        <?= htmlspecialchars($_GET['error']) ?>
    </div>
    <?php endif; ?>

    <?php
    $demoEnabled       = (($platformSettings['demo_accounts_enabled']   ?? '0') === '1');
    $showDemoPasswords = (($platformSettings['demo_passwords_visible']  ?? '0') === '1');
    $showDemoBlock     = (($platformSettings['demo_block_visible']      ?? '0') === '1');
    ?>

    <form method="POST" class="card">
        <div class="card-header">
            <h3><i class="fas fa-user-shield" style="color:#0ea5e9;margin-right:7px;"></i>Acceso Demo</h3>
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:14px;">
            <label style="display:flex;align-items:flex-start;gap:10px;padding:12px;border:1px solid #e2e8f0;border-radius:10px;background:#fff;cursor:pointer;">
                <input type="checkbox" name="demo_accounts_enabled" value="1" <?= $demoEnabled ? 'checked' : '' ?> style="margin-top:2px;">
                <span>
                    <span style="display:block;font-size:13.5px;font-weight:700;color:#1e293b;">Habilitar cuentas demo</span>
                    <span style="display:block;font-size:12.5px;color:#64748b;margin-top:2px;">Permite mostrar cuentas de prueba y usar el botón Entrar como demo en login.</span>
                </span>
            </label>

            <label style="display:flex;align-items:flex-start;gap:10px;padding:12px;border:1px solid #e2e8f0;border-radius:10px;background:#fff;cursor:pointer;">
                <input type="checkbox" name="demo_passwords_visible" value="1" <?= $showDemoPasswords ? 'checked' : '' ?> style="margin-top:2px;">
                <span>
                    <span style="display:block;font-size:13.5px;font-weight:700;color:#1e293b;">Mostrar passwords demo en login</span>
                    <span style="display:block;font-size:12.5px;color:#64748b;margin-top:2px;">Si está desactivado, los usuarios solo verán el acceso directo demo.</span>
                </span>
            </label>

            <label style="display:flex;align-items:flex-start;gap:10px;padding:12px;border:1px solid #e2e8f0;border-radius:10px;background:#fff;cursor:pointer;">
                <input type="checkbox" name="demo_block_visible" value="1" <?= $showDemoBlock ? 'checked' : '' ?> style="margin-top:2px;">
                <span>
                    <span style="display:block;font-size:13.5px;font-weight:700;color:#1e293b;">Mostrar bloque demo en login</span>
                    <span style="display:block;font-size:12.5px;color:#64748b;margin-top:2px;">Oculta o muestra la sección visual de cuentas demo.</span>
                </span>
            </label>

            <div style="display:flex;justify-content:flex-end;gap:8px;padding-top:4px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Configuración
                </button>
            </div>
        </div>
    </form>

    <!-- Quick link to emails module -->
    <a href="<?= BASE_URL ?>superadmin/emails" style="text-decoration:none;">
        <div class="card" style="border:1.5px dashed #bbf7d0;background:#f0fdf4;cursor:pointer;transition:border-color .15s;">
            <div class="card-body" style="display:flex;align-items:center;gap:16px;padding:18px 24px;">
                <div style="width:44px;height:44px;background:linear-gradient(135deg,#2a7a52,#d4973a);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff;flex-shrink:0;">📧</div>
                <div>
                    <div style="font-size:14px;font-weight:700;color:#2a7a52;">Administración de Correos</div>
                    <div style="font-size:12px;color:#64748b;margin-top:2px;">Configura SMTP, destinatarios por evento, plantillas profesionales y pruebas.</div>
                </div>
                <i class="fas fa-arrow-right" style="margin-left:auto;color:#2a7a52;"></i>
            </div>
        </div>
    </a>

</div>
