<!-- SuperAdmin Stores Content -->
<?php $planNames = ['Starter', 'Professional', 'Enterprise']; ?>
<div style="display:flex;flex-direction:column;gap:20px;">

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

    <div class="page-header">
        <div>
            <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Tiendas Registradas</h2>
            <p style="font-size:13.5px;color:#64748b;margin-top:3px;"><?= count($stores ?? []) ?> tiendas en la plataforma</p>
        </div>
        <div style="position:relative;">
            <input type="search" id="storeSearch" placeholder="Buscar tienda..."
                   oninput="filterStores(this.value)"
                   style="padding:9px 14px 9px 38px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13.5px;font-family:'Inter',sans-serif;color:#1e293b;background:#fff;outline:none;transition:border-color .15s;width:220px;"
                   onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#e2e8f0'">
            <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:12px;pointer-events:none;"></i>
        </div>
    </div>

    <?php if (!empty($stores)): ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;" id="storesGrid">
        <?php $count = 0; foreach ($stores as $store): if ($count++ >= 30) break; ?>
        <div class="store-card" data-name="<?= strtolower(htmlspecialchars($store['name'])) ?>"
             style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;transition:all .2s;"
             onmouseover="this.style.boxShadow='0 6px 24px rgba(0,0,0,0.08)';this.style.transform='translateY(-2px)'"
             onmouseout="this.style.boxShadow='none';this.style.transform='none'">
            <!-- Card top banner -->
            <div style="height:72px;background:linear-gradient(135deg,#312e81 0%,#4f46e5 60%,#7c3aed 100%);position:relative;">
                <div style="position:absolute;bottom:-22px;left:20px;">
                    <div style="width:44px;height:44px;border-radius:11px;background:#fff;border:2px solid #f1f5f9;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                        <?php if ($store['logo']): ?>
                            <img src="<?= htmlspecialchars($store['logo']) ?>" alt="" style="width:36px;height:36px;object-fit:cover;border-radius:8px;">
                        <?php else: ?>
                            <i class="fas fa-store" style="color:#4f46e5;font-size:16px;"></i>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div style="padding:30px 20px 20px;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:8px;">
                    <h3 style="font-size:15px;font-weight:700;color:#1e293b;line-height:1.3;"><?= htmlspecialchars($store['name']) ?></h3>
                    <span class="badge <?= $store['is_active'] ? 'badge-green' : 'badge-red' ?>" style="margin-left:8px;flex-shrink:0;">
                        <?= $store['is_active'] ? 'Activa' : 'Inactiva' ?>
                    </span>
                </div>
                <p style="font-size:12.5px;color:#94a3b8;margin-bottom:14px;line-height:1.5;" class="line-clamp-2">
                    <?= htmlspecialchars(Helper::truncate($store['description'] ?? 'Sin descripción', 65)) ?>
                </p>

                <div style="display:flex;flex-direction:column;gap:6px;margin-bottom:16px;padding:12px;background:#f8fafc;border-radius:8px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:12px;color:#94a3b8;font-weight:600;">Plan</span>
                        <span class="badge badge-indigo" style="font-size:11px;">
                            <?= $planNames[($store['plan_id'] - 1)] ?? 'Plan ' . $store['plan_id'] ?>
                        </span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:12px;color:#94a3b8;font-weight:600;">Propietario</span>
                        <span style="font-size:12.5px;font-weight:600;color:#64748b;">ID #<?= $store['owner_id'] ?></span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:12px;color:#94a3b8;font-weight:600;">Creada</span>
                        <span style="font-size:12.5px;color:#64748b;"><?= Helper::formatDate($store['created_at']) ?></span>
                    </div>
                </div>

                <a href="<?= BASE_URL ?>superadmin/stores/<?= $store['id'] ?>"
                   style="display:flex;align-items:center;justify-content:center;gap:7px;padding:9px;border-radius:8px;border:1.5px solid #e2e8f0;color:#4f46e5;font-size:13px;font-weight:700;text-decoration:none;transition:all .15s;"
                   onmouseover="this.style.background='#eef2ff';this.style.borderColor='#c7d2fe'"
                   onmouseout="this.style.background='transparent';this.style.borderColor='#e2e8f0'">
                    <i class="fas fa-eye text-xs"></i> Ver Detalles
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
    <div class="table-card">
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-store"></i></div>
            <h3>No hay tiendas registradas</h3>
            <p>Las tiendas creadas por los usuarios aparecerán aquí.</p>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
function filterStores(term) {
    const lower = term.toLowerCase();
    document.querySelectorAll('.store-card').forEach(card => {
        card.style.display = card.dataset.name.includes(lower) ? '' : 'none';
    });
}
</script>
