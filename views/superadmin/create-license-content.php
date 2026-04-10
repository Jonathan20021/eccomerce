<!-- SuperAdmin Create License Content -->
<div style="max-width:560px;">

    <?php if (isset($_GET['error'])): ?>
    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:18px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-exclamation-circle" style="color:#dc2626;font-size:14px;flex-shrink:0;"></i>
        <p style="font-size:13.5px;color:#b91c1c;font-weight:500;"><?= htmlspecialchars($_GET['error']) ?></p>
    </div>
    <?php endif; ?>

    <div style="margin-bottom:24px;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
            <a href="<?= BASE_URL ?>superadmin/licenses"
               style="color:#94a3b8;font-size:13px;text-decoration:none;display:flex;align-items:center;gap:4px;"
               onmouseover="this.style.color='#64748b'" onmouseout="this.style.color='#94a3b8'">
                <i class="fas fa-arrow-left text-xs"></i> Licencias
            </a>
            <span style="color:#e2e8f0;">/</span>
            <span style="font-size:13px;color:#64748b;">Nueva Licencia</span>
        </div>
        <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Crear Nueva Licencia</h2>
    </div>

    <form method="POST">
        <div class="card">
            <div class="card-body" style="display:flex;flex-direction:column;gap:18px;">

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" for="plan_id">Plan <span style="color:#ef4444;">*</span></label>
                    <select id="plan_id" name="plan_id" required class="form-input">
                        <option value="1">Starter — 50 productos, 5 GB</option>
                        <option value="2" selected>Professional — 500 productos, 50 GB</option>
                        <option value="3">Enterprise — Productos ilimitados</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" for="storage_gb">Espacio de Disco (GB) <span style="color:#ef4444;">*</span></label>
                    <input type="number" id="storage_gb" name="storage_gb" value="50" min="1" step="0.5" required class="form-input">
                    <p class="form-help">Puedes personalizar el espacio asignado para esta licencia.</p>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Módulos Incluidos</label>
                    <div style="display:flex;gap:16px;flex-wrap:wrap;padding:10px 12px;border:1px solid #e2e8f0;border-radius:8px;background:#f8fafc;">
                        <label style="display:flex;align-items:center;gap:8px;font-size:14px;color:#1e293b;cursor:pointer;">
                            <input type="checkbox" id="module_inventory" name="module_inventory" checked style="width:16px;height:16px;accent-color:#0ea5e9;cursor:pointer;">
                            Módulo de Inventario
                        </label>
                        <label style="display:flex;align-items:center;gap:8px;font-size:14px;color:#1e293b;cursor:pointer;">
                            <input type="checkbox" id="module_finance" name="module_finance" checked style="width:16px;height:16px;accent-color:#10b981;cursor:pointer;">
                            Módulo de Finanzas
                        </label>
                    </div>
                    <p class="form-help">Starter: Inventario. Professional y Enterprise: Inventario + Finanzas.</p>
                </div>

                <div class="form-grid-2" style="gap:14px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="trial_days">Días de Prueba</label>
                        <input type="number" id="trial_days" name="trial_days" value="15" required
                               class="form-input" min="0">
                    </div>
                    <div class="form-group" style="margin-bottom:0;display:flex;flex-direction:column;justify-content:flex-end;">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;padding:10px 0;">
                            <input type="checkbox" id="is_trial" name="is_trial" checked
                                   style="width:16px;height:16px;accent-color:#4f46e5;cursor:pointer;">
                            <span style="font-size:14px;font-weight:600;color:#1e293b;">Es Licencia de Prueba</span>
                        </label>
                    </div>
                </div>

                <div style="background:#eef2ff;border:1px solid #c7d2fe;border-radius:9px;padding:13px 15px;display:flex;align-items:flex-start;gap:10px;">
                    <i class="fas fa-info-circle" style="color:#4f46e5;font-size:14px;flex-shrink:0;margin-top:1px;"></i>
                    <p style="font-size:13px;color:#3730a3;line-height:1.5;">
                        Se generará automáticamente un <strong>código único</strong> que el usuario podrá usar para activar su licencia.
                    </p>
                </div>

            </div>
        </div>

        <div style="display:flex;gap:10px;margin-top:20px;">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle"></i> Crear Licencia
            </button>
            <a href="<?= BASE_URL ?>superadmin/licenses" class="btn btn-ghost btn-lg">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
(function() {
    var planInput = document.getElementById('plan_id');
    var storageInput = document.getElementById('storage_gb');
    var inventoryInput = document.getElementById('module_inventory');
    var financeInput = document.getElementById('module_finance');
    var defaults = { '1': 5, '2': 50, '3': 500 };
    var moduleDefaults = {
        '1': { inventory: true, finance: false },
        '2': { inventory: true, finance: true },
        '3': { inventory: true, finance: true }
    };

    if (!planInput || !storageInput || !inventoryInput || !financeInput) return;

    planInput.addEventListener('change', function() {
        var selected = String(planInput.value || '1');
        if (defaults[selected]) {
            storageInput.value = defaults[selected];
        }
        if (moduleDefaults[selected]) {
            inventoryInput.checked = !!moduleDefaults[selected].inventory;
            financeInput.checked = !!moduleDefaults[selected].finance;
        }
    });
})();
</script>
