<div style="display:flex;flex-direction:column;gap:20px;max-width:760px;">

    <?php if (isset($_GET['success'])): ?>
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-check-circle" style="color:#16a34a;font-size:14px;flex-shrink:0;"></i>
        <p style="font-size:13.5px;color:#166534;font-weight:500;"><?= htmlspecialchars($_GET['success']) ?></p>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-exclamation-circle" style="color:#dc2626;font-size:14px;flex-shrink:0;"></i>
        <p style="font-size:13.5px;color:#b91c1c;font-weight:500;"><?= htmlspecialchars($_GET['error']) ?></p>
    </div>
    <?php endif; ?>

    <div class="page-header" style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;">
        <div>
            <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Crear Usuario SuperAdmin</h2>
            <p style="font-size:13.5px;color:#64748b;margin-top:3px;">Crea cuentas administrativas globales para operar toda la plataforma.</p>
        </div>
        <a href="<?= BASE_URL ?>superadmin/users" class="btn btn-ghost">
            <i class="fas fa-arrow-left"></i> Volver a usuarios
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-user-shield" style="color:#2a7a52;margin-right:7px;"></i>Datos del nuevo superadmin</h3>
        </div>
        <div class="card-body">
            <form action="<?= BASE_URL ?>superadmin/users/create-superadmin" method="POST" class="form-grid-2" style="gap:14px;">
                <div>
                    <label class="form-label">Nombre completo *</label>
                    <input type="text" name="name" required class="form-input" placeholder="Ej: Ana Martínez">
                </div>
                <div>
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" required class="form-input" placeholder="admin@dominio.com">
                </div>
                <div>
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-input" placeholder="+1 809 000 0000">
                </div>
                <div>
                    <label class="form-label">Contraseña *</label>
                    <input type="password" name="password" required minlength="8" class="form-input" placeholder="Mínimo 8 caracteres">
                </div>
                <div>
                    <label class="form-label">Confirmar contraseña *</label>
                    <input type="password" name="password_confirm" required minlength="8" class="form-input" placeholder="Repite la contraseña">
                </div>

                <div style="grid-column:1 / -1;display:flex;align-items:center;justify-content:flex-end;gap:10px;padding-top:6px;">
                    <a href="<?= BASE_URL ?>superadmin/users" class="btn btn-ghost">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Crear SuperAdmin
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
