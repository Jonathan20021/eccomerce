<div style="max-width:1100px;margin:28px auto 70px;padding:0 16px;">
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
        <h1 style="font-size:24px;font-weight:800;color:#0f172a;">Mis direcciones</h1>
        <a href="<?= BASE_URL ?>customer/panel" style="font-size:13px;color:#2a7a52;font-weight:700;text-decoration:none;">Volver al panel</a>
    </div>

    <div style="display:grid;grid-template-columns:minmax(280px,420px) 1fr;gap:14px;align-items:start;">
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:16px;">
            <h2 style="font-size:15px;font-weight:800;color:#0f172a;margin-bottom:10px;">Agregar dirección</h2>
            <form method="POST" style="display:flex;flex-direction:column;gap:10px;">
                <input type="hidden" name="action" value="create">
                <input type="text" name="label" placeholder="Etiqueta (Casa, Oficina)" style="padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;">
                <input type="text" name="recipient_name" required placeholder="Nombre del destinatario" style="padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;">
                <input type="text" name="phone" placeholder="Teléfono" style="padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;">
                <textarea name="address_line" rows="3" required placeholder="Dirección" style="padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;"></textarea>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <input type="text" name="city" placeholder="Ciudad" style="padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;">
                    <input type="text" name="state" placeholder="Estado/Provincia" style="padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <input type="text" name="country" placeholder="País" style="padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;">
                    <input type="text" name="postal_code" placeholder="Código postal" style="padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;">
                </div>
                <label style="display:flex;align-items:center;gap:8px;font-size:12px;color:#475569;">
                    <input type="checkbox" name="is_default" value="1"> Usar como predeterminada
                </label>
                <button type="submit" style="padding:11px;border:none;border-radius:9px;background:linear-gradient(135deg,#2a7a52,#1f5c3d);color:#fff;font-weight:800;font-size:13px;cursor:pointer;">Guardar dirección</button>
            </form>
        </div>

        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">
            <div style="padding:14px 16px;border-bottom:1px solid #f1f5f9;">
                <h2 style="font-size:15px;font-weight:800;color:#0f172a;">Direcciones registradas</h2>
            </div>

            <?php if (empty($addresses)): ?>
            <div style="padding:20px 16px;color:#64748b;font-size:13px;">Aún no has registrado direcciones.</div>
            <?php else: ?>
            <div style="display:flex;flex-direction:column;">
                <?php foreach ($addresses as $address): ?>
                <div style="padding:14px 16px;border-top:1px solid #f8fafc;display:flex;justify-content:space-between;gap:10px;align-items:flex-start;">
                    <div>
                        <div style="font-size:13px;font-weight:800;color:#0f172a;">
                            <?= htmlspecialchars($address['label'] ?: 'Dirección') ?>
                            <?php if (!empty($address['is_default'])): ?>
                            <span style="font-size:11px;background:#ecfdf5;color:#166534;border:1px solid #bbf7d0;padding:2px 6px;border-radius:999px;margin-left:6px;">Predeterminada</span>
                            <?php endif; ?>
                        </div>
                        <div style="font-size:12px;color:#475569;margin-top:4px;"><?= htmlspecialchars($address['recipient_name'] ?? '') ?></div>
                        <div style="font-size:12px;color:#64748b;"><?= htmlspecialchars($address['address_line'] ?? '') ?></div>
                        <div style="font-size:12px;color:#94a3b8;"><?= htmlspecialchars(trim(($address['city'] ?? '') . ' ' . ($address['state'] ?? '') . ' ' . ($address['country'] ?? ''))) ?></div>
                    </div>
                    <form method="POST" onsubmit="return confirm('¿Eliminar esta dirección?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="address_id" value="<?= intval($address['id']) ?>">
                        <button type="submit" style="border:1px solid #fee2e2;background:#fff;color:#dc2626;border-radius:8px;padding:7px 10px;font-size:12px;font-weight:700;cursor:pointer;">Eliminar</button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
