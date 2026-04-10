<div style="max-width:760px;margin:28px auto 70px;padding:0 16px;">
    <?php if (isset($_GET['error'])): ?>
    <div style="background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;padding:12px 14px;border-radius:10px;margin-bottom:14px;font-size:13px;">
        <?= htmlspecialchars($_GET['error']) ?>
    </div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:12px 14px;border-radius:10px;margin-bottom:14px;font-size:13px;">
        <?= htmlspecialchars($_GET['success']) ?>
    </div>
    <?php endif; ?>

    <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:14px;">
        <h1 style="font-size:24px;font-weight:800;color:#0f172a;">Mi perfil</h1>
        <a href="<?= BASE_URL ?>customer/panel" style="font-size:13px;color:#2a7a52;font-weight:700;text-decoration:none;">Volver al panel</a>
    </div>

    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;">
        <form method="POST" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div style="grid-column:1 / -1;">
                <label style="display:block;font-size:12px;font-weight:700;color:#334155;margin-bottom:5px;">Nombre</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($customer['name'] ?? '') ?>" style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;">
            </div>
            <div>
                <label style="display:block;font-size:12px;font-weight:700;color:#334155;margin-bottom:5px;">Email</label>
                <input type="email" name="email" required value="<?= htmlspecialchars($customer['email'] ?? '') ?>" style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;">
            </div>
            <div>
                <label style="display:block;font-size:12px;font-weight:700;color:#334155;margin-bottom:5px;">Teléfono</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone'] ?? '') ?>" style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;">
            </div>
            <div style="grid-column:1 / -1;">
                <label style="display:block;font-size:12px;font-weight:700;color:#334155;margin-bottom:5px;">Nueva contraseña (opcional)</label>
                <input type="password" name="new_password" placeholder="Dejar vacío para mantener la actual" style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;">
            </div>
            <div style="grid-column:1 / -1;">
                <button type="submit" style="width:100%;padding:12px;border:none;border-radius:10px;background:linear-gradient(135deg,#2a7a52,#1f5c3d);color:#fff;font-weight:800;font-size:14px;cursor:pointer;">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
