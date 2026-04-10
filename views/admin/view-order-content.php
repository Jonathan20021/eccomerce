<!-- Admin View Order Content -->
<div style="display:flex;flex-direction:column;gap:20px;">

    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                <a href="<?= BASE_URL ?>admin/orders"
                   style="color:#94a3b8;font-size:13px;text-decoration:none;display:flex;align-items:center;gap:4px;"
                   onmouseover="this.style.color='#64748b'" onmouseout="this.style.color='#94a3b8'">
                    <i class="fas fa-arrow-left text-xs"></i> Órdenes
                </a>
                <span style="color:#e2e8f0;">/</span>
                <span style="font-size:13px;color:#64748b;">#<?= htmlspecialchars($orderData['order_number']) ?></span>
            </div>
            <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">
                Orden
                <code style="font-size:18px;background:#eef2ff;color:#4f46e5;padding:3px 10px;border-radius:7px;border:1px solid #c7d2fe;font-family:monospace;margin-left:6px;">
                    #<?= htmlspecialchars($orderData['order_number']) ?>
                </code>
            </h2>
        </div>
        <?php
        $statusMap = [
            'pending'    => ['badge-yellow', 'Pendiente'],
            'confirmed'  => ['badge-blue',   'Confirmada'],
            'processing' => ['badge-indigo',  'Procesando'],
            'shipped'    => ['badge-purple',  'Enviada'],
            'delivered'  => ['badge-green',   'Entregada'],
            'cancelled'  => ['badge-red',     'Cancelada'],
        ];
        $sb = $statusMap[$orderData['status']] ?? ['badge-slate', ucfirst($orderData['status'])];
        ?>
        <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;justify-content:flex-end;">
            <a href="<?= BASE_URL ?>admin/orders/<?= intval($orderData['id']) ?>/invoice/online"
               target="_blank"
               class="btn btn-ghost btn-sm">
                <i class="fas fa-globe"></i> Factura Online
            </a>
            <a href="<?= BASE_URL ?>admin/orders/<?= intval($orderData['id']) ?>/invoice/pdf"
               class="btn btn-ghost btn-sm">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
            <a href="<?= BASE_URL ?>admin/orders/<?= intval($orderData['id']) ?>/invoice/thermal"
               onclick="window.open(this.href, 'thermalPrintWindow', 'width=420,height=860,menubar=no,toolbar=no,location=no,status=no,resizable=yes,scrollbars=yes'); return false;"
               class="btn btn-ghost btn-sm">
                <i class="fas fa-print"></i> Térmica
            </a>
            <span class="badge <?= $sb[0] ?>" style="font-size:13px;padding:6px 14px;"><?= $sb[1] ?></span>
        </div>
    </div>

    <div class="store-checkout-grid" style="align-items:start;">

        <!-- Left column -->
        <div style="display:flex;flex-direction:column;gap:16px;">

            <!-- Customer Info -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-user" style="color:#4f46e5;margin-right:8px;"></i>Información del Cliente</h3>
                </div>
                <div class="card-body">
                    <div class="form-grid-2" style="gap:16px;">
                        <div>
                            <p style="font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Nombre</p>
                            <p style="font-size:14px;font-weight:600;color:#1e293b;"><?= htmlspecialchars($orderData['customer_name']) ?></p>
                        </div>
                        <div>
                            <p style="font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Email</p>
                            <p style="font-size:14px;font-weight:600;color:#1e293b;"><?= htmlspecialchars($orderData['customer_email']) ?></p>
                        </div>
                        <div>
                            <p style="font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Teléfono</p>
                            <p style="font-size:14px;font-weight:600;color:#1e293b;"><?= htmlspecialchars($orderData['customer_phone']) ?></p>
                        </div>
                        <div>
                            <p style="font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Método de Pago</p>
                            <p style="font-size:14px;font-weight:600;color:#1e293b;"><?= ucfirst($orderData['payment_method']) ?></p>
                        </div>
                        <?php if ($orderData['shipping_address']): ?>
                        <div style="grid-column:1/-1;">
                            <p style="font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Dirección de Envío</p>
                            <p style="font-size:14px;color:#1e293b;"><?= htmlspecialchars($orderData['shipping_address']) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="table-card">
                <div class="table-card-header">
                    <h3><i class="fas fa-shopping-cart" style="color:#64748b;margin-right:8px;"></i>Productos</h3>
                    <span style="font-size:13px;color:#64748b;"><?= count($orderItems) ?> artículo<?= count($orderItems) !== 1 ? 's' : '' ?></span>
                </div>
                <div class="overflow-x">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th style="text-align:center;">Cantidad</th>
                                <th style="text-align:right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderItems as $item): ?>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:12px;">
                                        <?php if ($item['image']): ?>
                                                <img src="<?= htmlspecialchars(Helper::resolvePublicFileUrl($item['image'])) ?>"
                                                 alt="<?= htmlspecialchars($item['name']) ?>"
                                                 style="width:42px;height:42px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;flex-shrink:0;">
                                        <?php else: ?>
                                            <div style="width:42px;height:42px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <i class="fas fa-box" style="color:#94a3b8;font-size:14px;"></i>
                                            </div>
                                        <?php endif; ?>
                                        <span style="font-size:13.5px;font-weight:600;color:#1e293b;"><?= htmlspecialchars($item['name']) ?></span>
                                    </div>
                                </td>
                                <td><span style="font-size:13.5px;color:#64748b;">$<?= number_format($item['price'], 2) ?></span></td>
                                <td style="text-align:center;">
                                    <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background:#f1f5f9;border-radius:8px;font-size:13px;font-weight:700;color:#1e293b;">
                                        <?= $item['quantity'] ?>
                                    </span>
                                </td>
                                <td style="text-align:right;">
                                    <span style="font-size:14px;font-weight:700;color:#1e293b;">$<?= number_format($item['subtotal'], 2) ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Right column -->
        <div style="display:flex;flex-direction:column;gap:16px;">

            <!-- Financial Summary -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-receipt" style="color:#16a34a;margin-right:8px;"></i>Resumen</h3>
                </div>
                <div class="card-body">
                    <div style="display:flex;flex-direction:column;gap:10px;padding-bottom:14px;border-bottom:1px solid #f1f5f9;margin-bottom:14px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:13.5px;color:#64748b;">Subtotal</span>
                            <span style="font-size:13.5px;font-weight:600;color:#1e293b;">$<?= number_format($orderData['subtotal'], 2) ?></span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:13.5px;color:#64748b;">Impuesto</span>
                            <span style="font-size:13.5px;font-weight:600;color:#1e293b;">$<?= number_format($orderData['tax'], 2) ?></span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:13.5px;color:#64748b;">Envío</span>
                            <span style="font-size:13.5px;font-weight:600;color:#1e293b;">$<?= number_format($orderData['shipping_cost'], 2) ?></span>
                        </div>
                        <?php if ($orderData['discount'] > 0): ?>
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:13.5px;color:#64748b;">Descuento</span>
                            <span style="font-size:13.5px;font-weight:600;color:#16a34a;">−$<?= number_format($orderData['discount'], 2) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:15px;font-weight:700;color:#1e293b;">Total</span>
                        <span style="font-size:18px;font-weight:800;color:#4f46e5;">$<?= number_format($orderData['total'], 2) ?></span>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-sync-alt" style="color:#7c3aed;margin-right:8px;"></i>Actualizar Estado</h3>
                </div>
                <div class="card-body" style="display:flex;flex-direction:column;gap:14px;">
                    <form method="POST">
                        <div class="form-group" style="margin-bottom:12px;">
                            <label class="form-label" for="status">Estado de Orden</label>
                            <select id="status" name="status" class="form-input">
                                <option value="pending"    <?= $orderData['status'] == 'pending'    ? 'selected' : '' ?>>Pendiente</option>
                                <option value="confirmed"  <?= $orderData['status'] == 'confirmed'  ? 'selected' : '' ?>>Confirmada</option>
                                <option value="processing" <?= $orderData['status'] == 'processing' ? 'selected' : '' ?>>Procesando</option>
                                <option value="shipped"    <?= $orderData['status'] == 'shipped'    ? 'selected' : '' ?>>Enviada</option>
                                <option value="delivered"  <?= $orderData['status'] == 'delivered'  ? 'selected' : '' ?>>Entregada</option>
                                <option value="cancelled"  <?= $orderData['status'] == 'cancelled'  ? 'selected' : '' ?>>Cancelada</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom:16px;">
                            <label class="form-label" for="payment_status">Estado de Pago</label>
                            <select id="payment_status" name="payment_status" class="form-input">
                                <option value="pending" <?= $orderData['payment_status'] == 'pending' ? 'selected' : '' ?>>Pendiente</option>
                                <option value="paid"    <?= $orderData['payment_status'] == 'paid'    ? 'selected' : '' ?>>Pagada</option>
                                <option value="failed"  <?= $orderData['payment_status'] == 'failed'  ? 'selected' : '' ?>>Fallida</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Meta -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-info-circle" style="color:#64748b;margin-right:8px;"></i>Información</h3>
                </div>
                <div class="card-body" style="display:flex;flex-direction:column;gap:12px;">
                    <div>
                        <p style="font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Número de Orden</p>
                        <code style="font-size:12px;background:#eef2ff;color:#4f46e5;padding:3px 8px;border-radius:5px;border:1px solid #c7d2fe;font-family:monospace;">
                            <?= htmlspecialchars($orderData['order_number']) ?>
                        </code>
                    </div>
                    <div>
                        <p style="font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Fecha de Creación</p>
                        <p style="font-size:13.5px;font-weight:600;color:#1e293b;"><?= Helper::formatDate($orderData['created_at']) ?></p>
                    </div>
                    <div>
                        <p style="font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Estado de Pago</p>
                        <?php
                        $payMap = ['pending'=>['badge-yellow','Pendiente'], 'paid'=>['badge-green','Pagada'], 'failed'=>['badge-red','Fallida']];
                        $pb = $payMap[$orderData['payment_status']] ?? ['badge-slate', ucfirst($orderData['payment_status'])];
                        ?>
                        <span class="badge <?= $pb[0] ?>"><?= $pb[1] ?></span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
