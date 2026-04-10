<!-- Checkout Content -->
<div class="store-page-wrap">

    <?php $checkoutSuccess = isset($_GET['success']) && trim((string)$_GET['success']) !== ''; ?>

    <?php if (isset($_GET['error'])): ?>
    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:18px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-exclamation-circle" style="color:#dc2626;font-size:14px;flex-shrink:0;"></i>
        <p style="font-size:13.5px;color:#b91c1c;font-weight:500;"><?= htmlspecialchars($_GET['error']) ?></p>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;margin-bottom:18px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-check-circle" style="color:#16a34a;font-size:14px;flex-shrink:0;"></i>
        <p style="font-size:13.5px;color:#166534;font-weight:500;"><?= htmlspecialchars($_GET['success']) ?></p>
    </div>
    <?php endif; ?>

    <!-- Header -->
    <div style="margin-bottom:28px;">
        <a href="javascript:history.back()"
           style="display:inline-flex;align-items:center;gap:6px;color:#94a3b8;font-size:13px;text-decoration:none;margin-bottom:10px;"
           onmouseover="this.style.color='#64748b'" onmouseout="this.style.color='#94a3b8'">
            <i class="fas fa-arrow-left" style="font-size:11px;"></i> Volver al carrito
        </a>
        <h1 style="font-size:26px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Finalizar Compra</h1>
    </div>

    <?php if ($checkoutSuccess && empty($cartItems)): ?>
    <div style="max-width:720px;margin:0 auto;background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:30px 24px;text-align:center;">
        <div style="width:64px;height:64px;border-radius:50%;background:#f0fdf4;border:1px solid #bbf7d0;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <i class="fas fa-check" style="font-size:24px;color:#16a34a;"></i>
        </div>

        <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;margin-bottom:8px;">¡Orden confirmada!</h2>
        <p style="font-size:14px;color:#64748b;line-height:1.6;margin-bottom:18px;">
            <?= htmlspecialchars($_GET['success']) ?>
        </p>

        <div style="display:flex;align-items:center;justify-content:center;gap:10px;flex-wrap:wrap;">
            <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>"
               style="display:inline-flex;align-items:center;gap:8px;padding:11px 16px;border-radius:10px;background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;font-size:14px;font-weight:700;text-decoration:none;">
                <i class="fas fa-store"></i> Volver a la tienda
            </a>
            <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>/cart"
               style="display:inline-flex;align-items:center;gap:8px;padding:11px 16px;border-radius:10px;border:1.5px solid #e2e8f0;color:#64748b;font-size:14px;font-weight:600;text-decoration:none;">
                <i class="fas fa-shopping-cart"></i> Ver carrito
            </a>
        </div>
    </div>
    <?php else: ?>

    <div class="store-checkout-grid">

        <!-- Checkout Form -->
        <form method="POST">
            <!-- Personal Info -->
            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;margin-bottom:16px;">
                <div style="padding:20px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;">
                    <div style="width:32px;height:32px;border-radius:8px;background:#eef2ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-user" style="color:#4f46e5;font-size:13px;"></i>
                    </div>
                    <h3 style="font-size:15px;font-weight:700;color:#1e293b;">Información Personal</h3>
                </div>
                <div style="padding:20px 24px;display:flex;flex-direction:column;gap:14px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;" for="name">
                            Nombre Completo <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" id="name" name="name" required
                               placeholder="Tu nombre completo"
                               style="width:100%;box-sizing:border-box;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;font-family:'Inter',sans-serif;color:#1e293b;outline:none;transition:border-color .15s;"
                               onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                    <div class="form-grid-2">
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;" for="email">
                                Email <span style="color:#ef4444;">*</span>
                            </label>
                            <input type="email" id="email" name="email" required
                                   placeholder="tu@email.com"
                                   style="width:100%;box-sizing:border-box;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;font-family:'Inter',sans-serif;color:#1e293b;outline:none;transition:border-color .15s;"
                                   onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;" for="phone">
                                Teléfono <span style="color:#ef4444;">*</span>
                            </label>
                            <input type="tel" id="phone" name="phone" required
                                   placeholder="+1 234 567 8900"
                                   style="width:100%;box-sizing:border-box;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;font-family:'Inter',sans-serif;color:#1e293b;outline:none;transition:border-color .15s;"
                                   onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;margin-bottom:16px;">
                <div style="padding:20px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;">
                    <div style="width:32px;height:32px;border-radius:8px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-map-marker-alt" style="color:#16a34a;font-size:13px;"></i>
                    </div>
                    <h3 style="font-size:15px;font-weight:700;color:#1e293b;">Dirección de Envío</h3>
                </div>
                <div style="padding:20px 24px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;" for="address">
                        Dirección Completa <span style="color:#ef4444;">*</span>
                    </label>
                    <textarea id="address" name="address" required rows="3"
                              placeholder="Calle, número, colonia, ciudad, estado, código postal"
                              style="width:100%;box-sizing:border-box;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;font-family:'Inter',sans-serif;color:#1e293b;outline:none;resize:vertical;transition:border-color .15s;"
                              onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
                </div>
            </div>

            <!-- Payment Method Notice -->
            <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:12px;padding:16px 18px;display:flex;align-items:flex-start;gap:12px;margin-bottom:20px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#dcfce7;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fab fa-whatsapp" style="color:#16a34a;font-size:18px;"></i>
                </div>
                <div>
                    <p style="font-size:14px;font-weight:700;color:#15803d;margin-bottom:3px;">Coordinación por mensaje (wa.me)</p>
                    <?php if (!empty($storeData['whatsapp_number'])): ?>
                    <p style="font-size:13px;color:#166534;line-height:1.5;">
                        Recibirás un enlace wa.me para coordinar el pago con la tienda.
                        Número de contacto: <strong><?= htmlspecialchars($storeData['whatsapp_number']) ?></strong>
                    </p>
                    <?php else: ?>
                    <p style="font-size:13px;color:#166534;line-height:1.5;">
                        La tienda aún no configuró un número de WhatsApp. Al confirmar la orden, se registrará en el sistema para seguimiento manual.
                    </p>
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit"
                    style="width:100%;padding:14px;border:none;border-radius:12px;background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;font-size:15px;font-weight:700;font-family:'Inter',sans-serif;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:opacity .15s;"
                    onmouseover="this.style.opacity='.92'" onmouseout="this.style.opacity='1'">
                <i class="fas fa-check-circle"></i> Confirmar y Crear Orden
            </button>
        </form>

        <!-- Order Summary -->
        <div class="store-summary-col" style="position:sticky;top:90px;">
            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;">
                <div style="padding:20px 24px;border-bottom:1px solid #f1f5f9;">
                    <h3 style="font-size:15px;font-weight:700;color:#1e293b;">Resumen de Orden</h3>
                </div>

                <?php if (!empty($cartItems)): ?>
                <!-- Items List -->
                <div style="padding:16px 24px;max-height:260px;overflow-y:auto;display:flex;flex-direction:column;gap:12px;border-bottom:1px solid #f1f5f9;">
                    <?php foreach ($cartItems as $item):
                        $itemPrice = (isset($item['discount_price']) && floatval($item['discount_price']) > 0)
                            ? floatval($item['discount_price'])
                            : floatval($item['price']);
                        $itemTotal = $itemPrice * $item['quantity'];
                    ?>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <?php if (!empty($item['image'])): ?>
                            <img src="<?= htmlspecialchars(Helper::resolvePublicFileUrl($item['image'])) ?>" alt=""
                                 style="width:40px;height:40px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;flex-shrink:0;">
                        <?php else: ?>
                            <div style="width:40px;height:40px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-box" style="color:#94a3b8;font-size:12px;"></i>
                            </div>
                        <?php endif; ?>
                        <div style="flex:1;min-width:0;">
                            <p style="font-size:13px;font-weight:600;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                <?= htmlspecialchars($item['name']) ?>
                            </p>
                            <p style="font-size:12px;color:#94a3b8;">x<?= $item['quantity'] ?></p>
                        </div>
                        <span style="font-size:13px;font-weight:700;color:#1e293b;flex-shrink:0;">$<?= number_format($itemTotal, 2) ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Totals -->
                <div style="padding:16px 24px;display:flex;flex-direction:column;gap:10px;border-bottom:1px solid #f1f5f9;">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:13.5px;color:#64748b;">Subtotal</span>
                        <span style="font-size:13.5px;font-weight:600;color:#1e293b;">$<?= number_format($cartTotal, 2) ?></span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:13.5px;color:#64748b;">Impuesto</span>
                        <span style="font-size:13.5px;font-weight:600;color:#1e293b;">$0.00</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:13.5px;color:#64748b;">Envío</span>
                        <span style="font-size:13px;color:#94a3b8;font-style:italic;">Acordar con tienda</span>
                    </div>
                </div>

                <div style="padding:16px 24px 20px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                        <span style="font-size:15px;font-weight:700;color:#1e293b;">Total</span>
                        <span style="font-size:20px;font-weight:800;color:#4f46e5;">$<?= number_format($cartTotal, 2) ?></span>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:#f8fafc;border-radius:9px;border:1px solid #e2e8f0;">
                        <i class="fas fa-shield-alt" style="color:#4f46e5;font-size:13px;flex-shrink:0;"></i>
                        <p style="font-size:12px;color:#64748b;line-height:1.4;">Tus datos están seguros. No almacenamos información de tarjeta.</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
    <?php endif; ?>
</div>
