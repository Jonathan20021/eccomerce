<!-- Admin Settings Content -->
<style>
@media (max-width: 768px) {
    .plan-change-history-row {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 6px !important;
    }

    .admin-settings-actions {
        flex-direction: column;
    }

    .admin-settings-actions .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
<div style="max-width:720px;">

    <div style="margin-bottom:24px;">
        <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Configuración de la Tienda</h2>
        <p style="font-size:13.5px;color:#64748b;margin-top:4px;">Personaliza la información y preferencias de tu tienda online.</p>
    </div>

    <?php if (isset($_GET['success'])): ?>
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:14px 16px;margin-bottom:24px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-check-circle" style="color:#16a34a;font-size:15px;flex-shrink:0;"></i>
        <p style="font-size:14px;color:#16a34a;font-weight:600;">Cambios guardados exitosamente</p>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:14px 16px;margin-bottom:24px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-exclamation-circle" style="color:#dc2626;font-size:15px;flex-shrink:0;"></i>
        <p style="font-size:14px;color:#b91c1c;font-weight:600;"><?= htmlspecialchars($_GET['error']) ?></p>
    </div>
    <?php endif; ?>

    <form method="POST">
        <div class="card">
            <div class="card-body" style="display:flex;flex-direction:column;gap:0;">

                <!-- Información General -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-store"></i> Información General
                    </div>
                    <div style="display:grid;gap:16px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label" for="name">Nombre de la Tienda <span style="color:#ef4444;">*</span></label>
                            <input type="text" id="name" name="name" required
                                   class="form-input"
                                   value="<?= htmlspecialchars($storeData['name']) ?>"
                                   placeholder="Nombre de tu tienda">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label" for="description">Descripción</label>
                            <textarea id="description" name="description" rows="3" class="form-input"
                                      placeholder="Describe brevemente tu tienda y lo que vendes..."><?= htmlspecialchars($storeData['description'] ?? '') ?></textarea>
                        </div>
                        <div class="form-grid-2">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" for="email">Email de Contacto</label>
                                <input type="email" id="email" name="email" class="form-input"
                                       value="<?= htmlspecialchars($storeData['email']) ?>"
                                       placeholder="contacto@tutienda.com">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" for="phone">Teléfono</label>
                                <input type="tel" id="phone" name="phone" class="form-input"
                                       value="<?= htmlspecialchars($storeData['phone'] ?? '') ?>"
                                       placeholder="+34 612 345 678">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fab fa-whatsapp" style="color:#16a34a;"></i> WhatsApp
                    </div>
                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:9px;padding:12px 14px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
                        <i class="fas fa-info-circle" style="color:#16a34a;font-size:13px;flex-shrink:0;"></i>
                        <p style="font-size:13px;color:#166534;line-height:1.5;">
                            Usa el formato internacional sin el <strong>+</strong>. Ej: <code style="background:#dcfce7;padding:1px 5px;border-radius:4px;">34612345678</code>
                        </p>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="whatsapp_number">Número de WhatsApp</label>
                        <div class="input-group">
                            <div class="input-prefix"><i class="fab fa-whatsapp" style="color:#16a34a;"></i>&nbsp;+</div>
                            <input type="tel" id="whatsapp_number" name="whatsapp_number"
                                   class="form-input input-with-prefix"
                                   style="border-radius:0 8px 8px 0;"
                                   value="<?= htmlspecialchars($storeData['whatsapp_number'] ?? '') ?>"
                                   placeholder="34612345678">
                        </div>
                        <?php if ($storeData['whatsapp_number']): ?>
                        <div class="form-help">
                                     <a href="<?= Helper::getWhatsAppLink($storeData['whatsapp_number'], 'Prueba desde Kyros Commerce Admin') ?>"
                               target="_blank" style="color:#16a34a;font-weight:600;">
                                <i class="fab fa-whatsapp mr-1"></i> Probar número de WhatsApp →
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Ubicación -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-map-marker-alt"></i> Ubicación
                    </div>
                    <div style="display:grid;gap:14px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label" for="address">Dirección</label>
                            <input type="text" id="address" name="address" class="form-input"
                                   value="<?= htmlspecialchars($storeData['address'] ?? '') ?>"
                                   placeholder="Calle Principal 123">
                        </div>
                        <div class="form-grid-2">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" for="city">Ciudad</label>
                                <input type="text" id="city" name="city" class="form-input"
                                       value="<?= htmlspecialchars($storeData['city'] ?? '') ?>"
                                       placeholder="Madrid">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" for="state">Estado / Provincia</label>
                                <input type="text" id="state" name="state" class="form-input"
                                       value="<?= htmlspecialchars($storeData['state'] ?? '') ?>"
                                       placeholder="Comunidad de Madrid">
                            </div>
                        </div>
                        <div class="form-grid-2">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" for="country">País</label>
                                <input type="text" id="country" name="country" class="form-input"
                                       value="<?= htmlspecialchars($storeData['country'] ?? '') ?>"
                                       placeholder="España">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" for="postal_code">Código Postal</label>
                                <input type="text" id="postal_code" name="postal_code" class="form-input"
                                       value="<?= htmlspecialchars($storeData['postal_code'] ?? '') ?>"
                                       placeholder="28001">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Moneda -->
                <div class="form-section" style="border-bottom:none;margin-bottom:0;padding-bottom:0;">
                    <div class="form-section-title">
                        <i class="fas fa-credit-card"></i> Configuración de Pagos
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="currency">Moneda de la Tienda</label>
                        <select id="currency" name="currency" class="form-input" style="max-width:320px;">
                            <option value="USD" <?= $storeData['currency'] == 'USD' ? 'selected' : '' ?>>USD — Dólar Americano ($)</option>
                            <option value="EUR" <?= $storeData['currency'] == 'EUR' ? 'selected' : '' ?>>EUR — Euro (€)</option>
                            <option value="MXN" <?= $storeData['currency'] == 'MXN' ? 'selected' : '' ?>>MXN — Peso Mexicano ($)</option>
                            <option value="COP" <?= $storeData['currency'] == 'COP' ? 'selected' : '' ?>>COP — Peso Colombiano ($)</option>
                            <option value="ARS" <?= $storeData['currency'] == 'ARS' ? 'selected' : '' ?>>ARS — Peso Argentino ($)</option>
                            <option value="DOP" <?= $storeData['currency'] == 'DOP' ? 'selected' : '' ?>>DOP — Peso Dominicano (RD$)</option>
                        </select>
                    </div>
                </div>

                <div class="form-section" style="margin-top:18px;">
                    <div class="form-section-title">
                        <i class="fas fa-exchange-alt"></i> Plan de Suscripción
                    </div>
                    <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:12px 14px;margin-bottom:12px;display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;">
                        <div>
                            <div style="font-size:12px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:.6px;">Plan actual</div>
                            <div style="font-size:15px;font-weight:800;color:#1e3a8a;margin-top:2px;">
                                <?= htmlspecialchars($currentPlanName ?? 'Starter') ?>
                            </div>
                        </div>
                        <?php if (!empty($pendingPlanRequest)): ?>
                        <span class="badge badge-yellow" style="font-size:11px;">Solicitud pendiente</span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($pendingPlanRequest)): ?>
                    <?php $planNamesMap = [1 => 'Starter', 2 => 'Professional', 3 => 'Enterprise']; ?>
                    <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:12px 14px;margin-bottom:12px;">
                        <div style="font-size:12px;color:#92400e;font-weight:700;">Ya tienes una solicitud en revisión</div>
                        <div style="font-size:13px;color:#78350f;margin-top:4px;">
                            <?= htmlspecialchars($planNamesMap[intval($pendingPlanRequest['current_plan_id'] ?? 1)] ?? 'Plan') ?>
                            <i class="fas fa-arrow-right" style="font-size:10px;color:#92400e;margin:0 4px;"></i>
                            <?= htmlspecialchars($planNamesMap[intval($pendingPlanRequest['requested_plan_id'] ?? 1)] ?? 'Plan') ?>
                            | <?= htmlspecialchars(Helper::formatDate($pendingPlanRequest['created_at'] ?? 'now')) ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <div style="display:grid;gap:10px;">
                        <div class="form-grid-2" style="gap:10px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" for="requested_plan_id">Nuevo plan solicitado</label>
                                <select id="requested_plan_id" name="requested_plan_id" class="form-input">
                                    <option value="1" <?= intval($currentPlanId ?? 1) === 1 ? 'disabled' : '' ?>>Starter</option>
                                    <option value="2" <?= intval($currentPlanId ?? 1) === 2 ? 'disabled' : '' ?>>Professional</option>
                                    <option value="3" <?= intval($currentPlanId ?? 1) === 3 ? 'disabled' : '' ?>>Enterprise</option>
                                </select>
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" for="reason">Motivo</label>
                                <input type="text" id="reason" name="reason" class="form-input" placeholder="Ej: necesito más capacidad y módulos">
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary btn-sm" formaction="<?= BASE_URL ?>admin/plan-change/request" formmethod="POST">
                                <i class="fas fa-paper-plane"></i> Enviar solicitud a superadmin
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($planChangeHistory)): ?>
                    <div style="margin-top:12px;">
                        <div style="font-size:12px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px;">Historial reciente</div>
                        <div style="display:flex;flex-direction:column;gap:6px;">
                            <?php
                            $planNamesMap = [1 => 'Starter', 2 => 'Professional', 3 => 'Enterprise'];
                            foreach ($planChangeHistory as $historyItem):
                                $historyStatus = strval($historyItem['status'] ?? 'pending');
                                $statusClass = $historyStatus === 'approved' ? 'badge-green' : ($historyStatus === 'rejected' ? 'badge-red' : 'badge-yellow');
                                $statusText = $historyStatus === 'approved' ? 'Aprobada' : ($historyStatus === 'rejected' ? 'Rechazada' : 'Pendiente');
                            ?>
                            <div class="plan-change-history-row" style="display:flex;align-items:center;justify-content:space-between;gap:8px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:8px 10px;">
                                <div style="font-size:12.5px;color:#334155;">
                                    <?= htmlspecialchars($planNamesMap[intval($historyItem['current_plan_id'] ?? 1)] ?? 'Plan') ?>
                                    <i class="fas fa-arrow-right" style="font-size:10px;color:#94a3b8;margin:0 4px;"></i>
                                    <?= htmlspecialchars($planNamesMap[intval($historyItem['requested_plan_id'] ?? 1)] ?? 'Plan') ?>
                                    <span style="color:#94a3b8;margin-left:6px;">(<?= htmlspecialchars(Helper::formatDate($historyItem['created_at'] ?? 'now')) ?>)</span>
                                </div>
                                <span class="badge <?= $statusClass ?>" style="font-size:11px;"><?= $statusText ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="form-section" style="margin-top:18px;">
                    <div class="form-section-title">
                        <i class="fas fa-bars"></i> Menú Público de la Tienda
                    </div>
                    <p style="font-size:12.5px;color:#64748b;margin-bottom:12px;">Configura enlaces del menú de tu storefront (máximo 4).</p>
                    <?php for ($i = 1; $i <= 4; $i++):
                        $menuItem = $menuSettings[$i - 1] ?? ['label' => '', 'url' => ''];
                    ?>
                    <div class="form-grid-1-2" style="gap:10px;margin-bottom:10px;">
                        <input type="text" name="menu_link_<?= $i ?>_label" class="form-input"
                               placeholder="Etiqueta #<?= $i ?>"
                               value="<?= htmlspecialchars($menuItem['label'] ?? '') ?>">
                        <input type="text" name="menu_link_<?= $i ?>_url" class="form-input"
                               placeholder="URL #<?= $i ?> (ej: <?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>)"
                               value="<?= htmlspecialchars($menuItem['url'] ?? '') ?>">
                    </div>
                    <?php endfor; ?>
                </div>

                <div class="form-section" style="border-bottom:none;margin-bottom:0;padding-bottom:0;">
                    <div class="form-section-title">
                        <i class="fas fa-shoe-prints"></i> Footer Público de la Tienda
                    </div>
                    <div style="display:grid;gap:12px;">
                        <textarea name="footer_text" rows="2" class="form-input"
                                  placeholder="Texto principal del footer"><?= htmlspecialchars($footerSettings['text'] ?? '') ?></textarea>
                        <div class="form-grid-2" style="gap:10px;">
                            <input type="email" name="footer_contact_email" class="form-input"
                                   placeholder="Email de contacto"
                                   value="<?= htmlspecialchars($footerSettings['contact_email'] ?? '') ?>">
                            <input type="text" name="footer_contact_phone" class="form-input"
                                   placeholder="Teléfono de contacto"
                                   value="<?= htmlspecialchars($footerSettings['contact_phone'] ?? '') ?>">
                        </div>
                        <div class="form-grid-2" style="gap:10px;">
                            <input type="text" name="footer_terms_url" class="form-input"
                                   placeholder="URL términos"
                                   value="<?= htmlspecialchars($footerSettings['terms_url'] ?? '') ?>">
                            <input type="text" name="footer_privacy_url" class="form-input"
                                   placeholder="URL privacidad"
                                   value="<?= htmlspecialchars($footerSettings['privacy_url'] ?? '') ?>">
                        </div>
                        <div class="form-grid-3" style="gap:10px;">
                            <input type="text" name="footer_facebook" class="form-input"
                                   placeholder="URL Facebook"
                                   value="<?= htmlspecialchars($footerSettings['facebook'] ?? '') ?>">
                            <input type="text" name="footer_instagram" class="form-input"
                                   placeholder="URL Instagram"
                                   value="<?= htmlspecialchars($footerSettings['instagram'] ?? '') ?>">
                            <input type="text" name="footer_tiktok" class="form-input"
                                   placeholder="URL TikTok"
                                   value="<?= htmlspecialchars($footerSettings['tiktok'] ?? '') ?>">
                        </div>
                    </div>
                </div>

            </div><!-- /card-body -->
        </div><!-- /card -->

        <!-- Action buttons -->
        <div class="admin-settings-actions" style="display:flex;gap:10px;margin-top:20px;">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <a href="<?= BASE_URL ?>admin/dashboard" class="btn btn-ghost btn-lg">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

    </form>
</div>
