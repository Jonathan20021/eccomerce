<?php

/**
 * EmailTemplate — Plantillas profesionales de correo para Kyros Commerce.
 * Diseño coherente con la landing page: verde #2a7a52, dorado #d4973a, fondo oscuro en header.
 * Usa tablas HTML para máxima compatibilidad con clientes de correo.
 */
class EmailTemplate {

    /* ─────────────── CONSTANTES DE MARCA ─────────────── */
    const COLOR_PRIMARY    = '#2a7a52';
    const COLOR_DARK       = '#0c1f12';
    const COLOR_DARK_MID   = '#1a4a2e';
    const COLOR_GOLD       = '#d4973a';
    const COLOR_TEXT       = '#1e293b';
    const COLOR_MUTED      = '#64748b';
    const COLOR_BORDER     = '#e2e8f0';
    const COLOR_BG_LIGHT   = '#f8fafc';
    const COLOR_GREEN_LIGHT = '#ecfdf5';
    const COLOR_GREEN_BORDER = '#bbf7d0';

    /* ─────────────── WRAPPER BASE ─────────────── */
    private static function base(string $preheader, string $bodyContent, string $appUrl = '') : string {
        $year    = date('Y');
        $url     = rtrim((string) $appUrl, '/');
        $terms   = $url ? $url . '/terms'   : '#';
        $privacy = $url ? $url . '/privacy' : '#';

        return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="x-apple-disable-message-reformatting"/>
<title>Kyros Commerce</title>
<style type="text/css">
body,table,td,p,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin:0;padding:0;}
table{border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;}
img{border:0;height:auto;line-height:100%;outline:none;text-decoration:none;}
body{font-family:\'Inter\',Arial,sans-serif;background-color:#f1f5f9;}
@media only screen and (max-width:600px){
  .email-shell{width:100%!important;min-width:100%!important;}
  .email-pad{padding:24px 16px!important;}
  .btn-cta{font-size:14px!important;padding:12px 24px!important;}
}
</style>
</head>
<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:\'Inter\',Arial,sans-serif;">

<!-- Preheader (invisible) -->
<div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;line-height:1px;color:#f1f5f9;">' . htmlspecialchars($preheader) . '</div>

<!-- Wrapper -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9;padding:32px 16px;">
<tr>
<td align="center">

  <!-- Shell -->
  <table class="email-shell" width="600" border="0" cellpadding="0" cellspacing="0" style="width:600px;max-width:600px;">

    <!-- ══ HEADER ══ -->
    <tr>
      <td style="background:linear-gradient(135deg,#0c1f12 0%,#1a4a2e 50%,#2a7a52 100%);border-radius:20px 20px 0 0;padding:32px 40px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td style="vertical-align:middle;">
              <!-- Logo mark -->
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="vertical-align:middle;">
                    <div style="width:40px;height:40px;background:linear-gradient(135deg,#2a7a52,#d4973a);border-radius:10px;display:inline-flex;align-items:center;justify-content:center;font-weight:900;font-size:18px;color:#fff;font-family:Arial,sans-serif;letter-spacing:-0.5px;text-align:center;line-height:40px;">K</div>
                  </td>
                  <td style="padding-left:12px;vertical-align:middle;">
                    <div style="font-size:18px;font-weight:800;color:#ffffff;letter-spacing:-0.5px;font-family:\'Inter\',Arial,sans-serif;">Kyros Commerce</div>
                    <div style="font-size:11px;color:rgba(255,255,255,0.55);font-weight:500;margin-top:1px;font-family:Arial,sans-serif;">Plataforma de E-commerce</div>
                  </td>
                </tr>
              </table>
            </td>
            <td align="right" style="vertical-align:middle;">
              <div style="background:rgba(134,239,172,0.15);border:1px solid rgba(134,239,172,0.3);border-radius:20px;padding:5px 14px;display:inline-block;">
                <span style="color:#86efac;font-size:11px;font-weight:700;font-family:Arial,sans-serif;">&#9679; Notificacion</span>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- ══ BODY ══ -->
    <tr>
      <td style="background:#ffffff;padding:0;">
        ' . $bodyContent . '
      </td>
    </tr>

    <!-- ══ FOOTER ══ -->
    <tr>
      <td style="background:#f8fafc;border-top:1px solid #e2e8f0;border-radius:0 0 20px 20px;padding:24px 40px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center">
              <p style="font-size:12px;color:#94a3b8;margin:0 0 8px 0;font-family:Arial,sans-serif;">
                &copy; ' . $year . ' Kyros Commerce. Todos los derechos reservados.
              </p>
              <p style="font-size:12px;margin:0;font-family:Arial,sans-serif;">
                <a href="' . $terms . '" style="color:#64748b;text-decoration:none;">Términos</a>
                &nbsp;&middot;&nbsp;
                <a href="' . $privacy . '" style="color:#64748b;text-decoration:none;">Privacidad</a>
                &nbsp;&middot;&nbsp;
                <span style="color:#94a3b8;">notificaciones@kyrosrd.com</span>
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>

  </table>
  <!-- /Shell -->

</td>
</tr>
</table>
</body>
</html>';
    }

    /* ─────────────── HELPER: DATA ROW ─────────────── */
    private static function row(string $label, string $value) : string {
        return '<tr>
          <td style="padding:8px 0;border-bottom:1px solid #f1f5f9;vertical-align:top;">
            <span style="font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;font-family:Arial,sans-serif;">' . htmlspecialchars($label) . '</span>
          </td>
          <td style="padding:8px 0 8px 16px;border-bottom:1px solid #f1f5f9;vertical-align:top;text-align:right;">
            <span style="font-size:13px;font-weight:600;color:#1e293b;font-family:Arial,sans-serif;">' . $value . '</span>
          </td>
        </tr>';
    }

    /* ─────────────── HELPER: BADGE ─────────────── */
    private static function badge(string $text, string $bg = '#ecfdf5', string $color = '#2a7a52', string $border = '#bbf7d0') : string {
        return '<span style="display:inline-block;background:' . $bg . ';color:' . $color . ';border:1px solid ' . $border . ';border-radius:20px;padding:3px 12px;font-size:11px;font-weight:700;font-family:Arial,sans-serif;">' . htmlspecialchars($text) . '</span>';
    }

    /* ─────────────── HELPER: CTA BUTTON ─────────────── */
    private static function cta(string $text, string $url, string $bg = '#2a7a52') : string {
        return '<table border="0" cellpadding="0" cellspacing="0" style="margin:24px auto 0;">
          <tr>
            <td align="center" style="background:' . $bg . ';border-radius:12px;">
              <a href="' . htmlspecialchars($url) . '" class="btn-cta" style="display:inline-block;padding:14px 32px;font-size:15px;font-weight:700;color:#ffffff;text-decoration:none;font-family:Arial,sans-serif;border-radius:12px;">' . htmlspecialchars($text) . '</a>
            </td>
          </tr>
        </table>';
    }

    /* ─────────────── HELPER: SECTION HEADER ─────────────── */
    private static function sectionHeader(string $icon, string $title, string $subtitle = '') : string {
        $sub = $subtitle ? '<p style="margin:6px 0 0 0;font-size:13px;color:#64748b;font-family:Arial,sans-serif;line-height:1.5;">' . htmlspecialchars($subtitle) . '</p>' : '';
        return '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
          <tr>
            <td align="center">
              <div style="width:60px;height:60px;background:linear-gradient(135deg,#ecfdf5,#d1fae5);border:2px solid #bbf7d0;border-radius:16px;display:inline-flex;align-items:center;justify-content:center;font-size:26px;margin-bottom:16px;text-align:center;line-height:60px;">' . $icon . '</div>
              <h1 style="margin:0;font-size:22px;font-weight:800;color:#1e293b;font-family:\'Inter\',Arial,sans-serif;letter-spacing:-0.5px;">' . htmlspecialchars($title) . '</h1>
              ' . $sub . '
            </td>
          </tr>
        </table>';
    }

    /* ══════════════════════════════════════════════
       PLANTILLA 1 — BIENVENIDA (enviada al nuevo usuario)
    ══════════════════════════════════════════════ */
    public static function welcome(
        string $name,
        string $email,
        string $storeName,
        string $planName,
        string $appUrl = '',
        string $loginUrl = ''
    ) : string {
        $body = '<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="email-pad" style="padding:40px 40px 32px;">

              ' . self::sectionHeader('🎉', '¡Bienvenido a Kyros Commerce!', 'Tu tienda online está lista para despegar.') . '

              <p style="margin:0 0 20px 0;font-size:15px;color:#334155;line-height:1.7;font-family:Arial,sans-serif;">
                Hola <strong>' . htmlspecialchars($name) . '</strong>,<br><br>
                ¡Nos alegra mucho que estés aquí! Tu cuenta fue creada exitosamente y ya puedes empezar a gestionar tu tienda <strong>' . htmlspecialchars($storeName) . '</strong>.
              </p>

              <!-- Data card -->
              <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;margin-bottom:24px;">
                <tr><td style="padding:20px;">
                  <p style="margin:0 0 12px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.8px;font-family:Arial,sans-serif;">Resumen de tu cuenta</p>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    ' . self::row('Nombre', htmlspecialchars($name)) . '
                    ' . self::row('Correo', htmlspecialchars($email)) . '
                    ' . self::row('Tienda', htmlspecialchars($storeName)) . '
                    ' . self::row('Plan', self::badge($planName)) . '
                  </table>
                </td></tr>
              </table>

              <!-- Steps -->
              <p style="margin:0 0 16px 0;font-size:13px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:0.5px;font-family:Arial,sans-serif;">Próximos pasos</p>
              <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                ' . self::stepRow('1', 'Inicia sesión en tu panel', 'Accede con tu correo y contraseña.') . '
                ' . self::stepRow('2', 'Agrega tus productos', 'Sube fotos, precios y descripciones.') . '
                ' . self::stepRow('3', 'Comparte tu tienda', 'Copia el enlace de tu tienda y empieza a vender.') . '
              </table>

              ' . ($loginUrl ? self::cta('Ir a mi tienda →', $loginUrl) : '') . '

              <p style="margin:28px 0 0 0;font-size:13px;color:#94a3b8;text-align:center;font-family:Arial,sans-serif;">
                ¿Tienes dudas? Escríbenos a <a href="mailto:notificaciones@kyrosrd.com" style="color:#2a7a52;font-weight:600;">notificaciones@kyrosrd.com</a>
              </p>

            </td>
          </tr>
        </table>';

        return self::base('¡Bienvenido a Kyros Commerce! Tu tienda está lista.', $body, $appUrl);
    }

    private static function stepRow(string $num, string $title, string $desc) : string {
        return '<tr>
          <td style="padding:8px 0;vertical-align:top;">
            <table border="0" cellpadding="0" cellspacing="0"><tr>
              <td style="vertical-align:top;">
                <div style="width:28px;height:28px;background:linear-gradient(135deg,#2a7a52,#d4973a);border-radius:8px;text-align:center;line-height:28px;font-size:13px;font-weight:800;color:#fff;font-family:Arial,sans-serif;display:inline-block;">' . $num . '</div>
              </td>
              <td style="padding-left:12px;vertical-align:top;">
                <div style="font-size:13px;font-weight:700;color:#1e293b;font-family:Arial,sans-serif;">' . htmlspecialchars($title) . '</div>
                <div style="font-size:12px;color:#64748b;margin-top:2px;font-family:Arial,sans-serif;">' . htmlspecialchars($desc) . '</div>
              </td>
            </tr></table>
          </td>
        </tr>';
    }

    /* ══════════════════════════════════════════════
       PLANTILLA 2 — NUEVO REGISTRO (notificación admin)
    ══════════════════════════════════════════════ */
    public static function newRegistrationAdmin(
        string $name,
        string $email,
        string $storeName,
        string $planName,
        string $date,
        string $appUrl = ''
    ) : string {
        $body = '<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="email-pad" style="padding:40px 40px 32px;">

              <!-- Alert banner -->
              <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                <tr>
                  <td style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);border:2px solid #bbf7d0;border-radius:14px;padding:18px 24px;">
                    <table border="0" cellpadding="0" cellspacing="0"><tr>
                      <td style="font-size:22px;vertical-align:middle;">👤</td>
                      <td style="padding-left:14px;vertical-align:middle;">
                        <div style="font-size:15px;font-weight:800;color:#2a7a52;font-family:Arial,sans-serif;">Nuevo usuario registrado</div>
                        <div style="font-size:12px;color:#64748b;margin-top:2px;font-family:Arial,sans-serif;">Alguien acaba de crear una cuenta en Kyros Commerce.</div>
                      </td>
                    </tr></table>
                  </td>
                </tr>
              </table>

              <!-- Data card -->
              <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;margin-bottom:24px;">
                <tr><td style="padding:24px;">
                  <p style="margin:0 0 14px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.8px;font-family:Arial,sans-serif;">Datos del nuevo usuario</p>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    ' . self::row('Nombre', htmlspecialchars($name)) . '
                    ' . self::row('Correo', htmlspecialchars($email)) . '
                    ' . self::row('Tienda', htmlspecialchars($storeName)) . '
                    ' . self::row('Plan', self::badge($planName)) . '
                    ' . self::row('Fecha', htmlspecialchars($date)) . '
                  </table>
                </td></tr>
              </table>

              ' . ($appUrl ? self::cta('Ver en el panel →', $appUrl . '/superadmin/stores') : '') . '

            </td>
          </tr>
        </table>';

        return self::base('Nuevo usuario registrado: ' . $name . ' — ' . $storeName, $body, $appUrl);
    }

    /* ══════════════════════════════════════════════
       PLANTILLA 3 — NUEVA ORDEN (notificación admin)
    ══════════════════════════════════════════════ */
    public static function newOrderAdmin(
        string $orderNumber,
        string $storeName,
        string $customerName,
        string $customerEmail,
        string $total,
        string $date,
        string $appUrl = ''
    ) : string {
        $body = '<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="email-pad" style="padding:40px 40px 32px;">

              <!-- Alert banner -->
              <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                <tr>
                  <td style="background:linear-gradient(135deg,#fffbeb,#fef3c7);border:2px solid #fde68a;border-radius:14px;padding:18px 24px;">
                    <table border="0" cellpadding="0" cellspacing="0"><tr>
                      <td style="font-size:22px;vertical-align:middle;">🛒</td>
                      <td style="padding-left:14px;vertical-align:middle;">
                        <div style="font-size:15px;font-weight:800;color:#d4973a;font-family:Arial,sans-serif;">Nueva orden recibida</div>
                        <div style="font-size:12px;color:#92400e;margin-top:2px;font-family:Arial,sans-serif;">Un cliente acaba de completar un pedido.</div>
                      </td>
                    </tr></table>
                  </td>
                </tr>
              </table>

              <!-- Total highlight -->
              <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                <tr>
                  <td align="center" style="background:linear-gradient(135deg,#0c1f12,#1a4a2e);border-radius:14px;padding:24px;">
                    <div style="font-size:11px;font-weight:700;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;font-family:Arial,sans-serif;">Total de la orden</div>
                    <div style="font-size:38px;font-weight:900;color:#ffffff;letter-spacing:-1.5px;font-family:Arial,sans-serif;">' . htmlspecialchars($total) . '</div>
                    <div style="margin-top:8px;">' . self::badge($orderNumber, 'rgba(134,239,172,0.15)', '#86efac', 'rgba(134,239,172,0.3)') . '</div>
                  </td>
                </tr>
              </table>

              <!-- Data card -->
              <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;margin-bottom:24px;">
                <tr><td style="padding:24px;">
                  <p style="margin:0 0 14px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.8px;font-family:Arial,sans-serif;">Detalles de la orden</p>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    ' . self::row('Tienda', htmlspecialchars($storeName)) . '
                    ' . self::row('Cliente', htmlspecialchars($customerName)) . '
                    ' . self::row('Email', htmlspecialchars($customerEmail)) . '
                    ' . self::row('Fecha', htmlspecialchars($date)) . '
                  </table>
                </td></tr>
              </table>

              ' . ($appUrl ? self::cta('Ver orden en el panel →', $appUrl . '/admin/orders') : '') . '

            </td>
          </tr>
        </table>';

        return self::base('Nueva orden ' . $orderNumber . ' — ' . $total, $body, $appUrl);
    }

    /* ══════════════════════════════════════════════
       PLANTILLA 4 — CONFIRMACIÓN DE ORDEN (enviada al cliente)
    ══════════════════════════════════════════════ */
    public static function orderConfirmation(
        string $customerName,
        string $orderNumber,
        string $storeName,
        string $total,
        string $date,
        string $appUrl = ''
    ) : string {
        $body = '<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="email-pad" style="padding:40px 40px 32px;">

              ' . self::sectionHeader('✅', '¡Orden recibida!', 'Tu pedido fue registrado correctamente.') . '

              <p style="margin:0 0 20px 0;font-size:15px;color:#334155;line-height:1.7;font-family:Arial,sans-serif;">
                Hola <strong>' . htmlspecialchars($customerName) . '</strong>,<br><br>
                Hemos recibido tu orden en <strong>' . htmlspecialchars($storeName) . '</strong>. Pronto nos pondremos en contacto contigo para coordinar la entrega.
              </p>

              <!-- Order summary -->
              <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#0c1f12,#1a4a2e);border-radius:14px;margin-bottom:24px;">
                <tr>
                  <td align="center" style="padding:24px;">
                    <div style="font-size:11px;font-weight:700;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;font-family:Arial,sans-serif;">Número de orden</div>
                    <div style="font-size:26px;font-weight:900;color:#ffffff;letter-spacing:-1px;font-family:Arial,sans-serif;">' . htmlspecialchars($orderNumber) . '</div>
                  </td>
                </tr>
              </table>

              <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;margin-bottom:24px;">
                <tr><td style="padding:24px;">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    ' . self::row('Tienda', htmlspecialchars($storeName)) . '
                    ' . self::row('Total', '<strong>' . htmlspecialchars($total) . '</strong>') . '
                    ' . self::row('Fecha', htmlspecialchars($date)) . '
                  </table>
                </td></tr>
              </table>

              <p style="margin:0;font-size:13px;color:#64748b;text-align:center;line-height:1.6;font-family:Arial,sans-serif;">
                Si tienes alguna pregunta sobre tu pedido, contacta a la tienda directamente.<br>
                <span style="color:#94a3b8;font-size:12px;">No respondas a este correo automático.</span>
              </p>

            </td>
          </tr>
        </table>';

        return self::base('Confirmación de orden ' . $orderNumber . ' — ' . $storeName, $body, $appUrl);
    }

    /* ══════════════════════════════════════════════
       PLANTILLA 5 — RECUPERACIÓN DE ACCESO (enviada al usuario)
    ══════════════════════════════════════════════ */
    public static function forgotPassword(string $email, string $date, string $appUrl = '') : string {
        $body = '<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="email-pad" style="padding:40px 40px 32px;">

              ' . self::sectionHeader('🔐', 'Solicitud de recuperación', 'Recibimos una solicitud para tu cuenta.') . '

              <p style="margin:0 0 20px 0;font-size:15px;color:#334155;line-height:1.7;font-family:Arial,sans-serif;">
                Hemos recibido una solicitud de recuperación de acceso para la cuenta asociada a <strong>' . htmlspecialchars($email) . '</strong>.
              </p>

              <!-- Info card -->
              <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background:#fef2f2;border:1.5px solid #fecaca;border-radius:12px;margin-bottom:24px;">
                <tr><td style="padding:20px;">
                  <table border="0" cellpadding="0" cellspacing="0"><tr>
                    <td style="font-size:20px;vertical-align:middle;">⚠️</td>
                    <td style="padding-left:12px;vertical-align:middle;">
                      <div style="font-size:13px;font-weight:700;color:#991b1b;font-family:Arial,sans-serif;">Si no fuiste tú, ignora este correo.</div>
                      <div style="font-size:12px;color:#b91c1c;margin-top:2px;font-family:Arial,sans-serif;">Tu cuenta permanece segura mientras no hagas clic en ningún enlace sospechoso.</div>
                    </td>
                  </tr></table>
                </td></tr>
              </table>

              <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;margin-bottom:24px;">
                <tr><td style="padding:20px;">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    ' . self::row('Correo', htmlspecialchars($email)) . '
                    ' . self::row('Fecha y hora', htmlspecialchars($date)) . '
                  </table>
                </td></tr>
              </table>

              <p style="margin:0;font-size:13px;color:#94a3b8;text-align:center;font-family:Arial,sans-serif;">
                Para reestablecer tu acceso, contacta al equipo de soporte.<br>
                <a href="mailto:notificaciones@kyrosrd.com" style="color:#2a7a52;font-weight:600;">notificaciones@kyrosrd.com</a>
              </p>

            </td>
          </tr>
        </table>';

        return self::base('Solicitud de recuperación de acceso a Kyros Commerce', $body, $appUrl);
    }

    /* ══════════════════════════════════════════════
       PLANTILLA 6 — PRUEBA DE SMTP
    ══════════════════════════════════════════════ */
    public static function smtpTest(string $date, string $appUrl = '') : string {
        $body = '<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="email-pad" style="padding:40px 40px 32px;">

              ' . self::sectionHeader('🚀', 'Prueba de correo exitosa', 'Tu configuración SMTP funciona correctamente.') . '

              <!-- Success card -->
              <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);border:2px solid #bbf7d0;border-radius:14px;margin-bottom:24px;">
                <tr><td align="center" style="padding:28px;">
                  <div style="font-size:40px;margin-bottom:12px;">✅</div>
                  <div style="font-size:18px;font-weight:800;color:#2a7a52;font-family:Arial,sans-serif;">¡Conexión SMTP verificada!</div>
                  <div style="font-size:13px;color:#065f46;margin-top:6px;font-family:Arial,sans-serif;">Las notificaciones de la plataforma están activas.</div>
                </td></tr>
              </table>

              <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;margin-bottom:24px;">
                <tr><td style="padding:20px;">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    ' . self::row('Plataforma', 'Kyros Commerce') . '
                    ' . self::row('Estado', self::badge('Activo')) . '
                    ' . self::row('Fecha de prueba', htmlspecialchars($date)) . '
                  </table>
                </td></tr>
              </table>

              <p style="margin:0;font-size:12px;color:#94a3b8;text-align:center;font-family:Arial,sans-serif;">
                Este correo fue generado automáticamente desde el panel de administración de Kyros Commerce.
              </p>

            </td>
          </tr>
        </table>';

        return self::base('Prueba de correo — Kyros Commerce funciona correctamente', $body, $appUrl);
    }
}
