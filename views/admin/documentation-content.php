<div style="display:flex;flex-direction:column;gap:20px;">
    <div class="page-header">
        <div>
            <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Documentación de tu tienda</h2>
            <p style="font-size:13.5px;color:#64748b;margin-top:3px;">Guías rápidas para operar mejor tu portal y atender a tus clientes.</p>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:12px;">
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:10px;padding:14px;">
            <p style="font-size:12px;color:#94a3b8;margin-bottom:6px;">Documentos disponibles</p>
            <p style="font-size:24px;font-weight:800;color:#1e293b;">1</p>
        </div>
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:10px;padding:14px;">
            <p style="font-size:12px;color:#94a3b8;margin-bottom:6px;">Tema actual</p>
            <p style="font-size:14px;font-weight:700;color:#0f766e;">Portal de clientes</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-book-open" style="color:#2563eb;margin-right:8px;"></i>Guía #1 — Registro de clientes y uso del portal</h3>
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:16px;">
            <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:12px 14px;">
                <p style="font-size:13px;color:#1d4ed8;line-height:1.55;">
                    Esta guía explica cómo tus clientes pueden crear su cuenta en tu tienda y qué acciones estarán disponibles en su portal una vez inicien sesión.
                </p>
            </div>

            <div>
                <h4 style="font-size:15px;font-weight:800;color:#1e293b;margin-bottom:8px;">1) ¿Cómo se registra un cliente en la tienda?</h4>
                <ol style="margin:0;padding-left:18px;display:flex;flex-direction:column;gap:7px;color:#475569;font-size:13.5px;line-height:1.6;">
                    <li>El cliente entra a tu tienda pública en <code><?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug'] ?? '') ?></code>.</li>
                    <li>Hace clic en la opción <strong>"Crear cuenta"</strong> o <strong>"Registrarse"</strong>.</li>
                    <li>Completa nombre, correo, teléfono y contraseña.</li>
                    <li>Una vez enviado el formulario, podrá iniciar sesión en su portal de cliente.</li>
                </ol>
            </div>

            <div>
                <h4 style="font-size:15px;font-weight:800;color:#1e293b;margin-bottom:8px;">2) ¿Qué puede hacer el cliente desde su portal?</h4>
                <ul style="margin:0;padding-left:18px;display:flex;flex-direction:column;gap:7px;color:#475569;font-size:13.5px;line-height:1.6;">
                    <li>Ver un resumen de su cuenta y pedidos recientes.</li>
                    <li>Editar su perfil (nombre, correo, teléfono y contraseña).</li>
                    <li>Gestionar direcciones de entrega guardadas.</li>
                    <li>Consultar el historial de pedidos de su tienda.</li>
                    <li>Abrir el detalle de cada pedido y revisar productos, totales y estado.</li>
                </ul>
            </div>

            <div>
                <h4 style="font-size:15px;font-weight:800;color:#1e293b;margin-bottom:8px;">3) ¿Cómo ayuda esto a la tienda?</h4>
                <ul style="margin:0;padding-left:18px;display:flex;flex-direction:column;gap:7px;color:#475569;font-size:13.5px;line-height:1.6;">
                    <li>Reduce errores en checkout al autocompletar datos del cliente.</li>
                    <li>Mejora la retención al facilitar recompra y seguimiento.</li>
                    <li>Permite soporte más rápido con información centralizada en <code>admin/customers</code>.</li>
                </ul>
            </div>

            <div style="background:#f8fafc;border:1px dashed #cbd5e1;border-radius:10px;padding:12px 14px;">
                <p style="font-size:12.5px;color:#64748b;line-height:1.6;">
                    Tip: también puedes crear clientes manualmente desde <code>Clientes</code> en el panel de tienda para registrar compradores por teléfono, WhatsApp o ventas asistidas.
                </p>
            </div>
        </div>
    </div>
</div>
