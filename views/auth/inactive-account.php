<?php
$isStore = ($tipo ?? 'usuario') === 'tienda';
$page_title = ($isStore ? 'Tienda Inactiva' : 'Cuenta Inactiva') . ' — Kyros Commerce';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="font-family:'Inter',sans-serif;background:#f8fafc;color:#0f172a;">

<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;">
    <div style="width:100%;max-width:500px;text-align:center;">

        <!-- Icon -->
        <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#fef2f2,#fee2e2);display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
            <?php if ($isStore): ?>
            <i class="fas fa-store-slash" style="font-size:32px;color:#dc2626;"></i>
            <?php else: ?>
            <i class="fas fa-user-slash" style="font-size:32px;color:#dc2626;"></i>
            <?php endif; ?>
        </div>

        <!-- Card -->
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:32px 28px;">

            <h1 style="font-size:26px;font-weight:900;letter-spacing:-0.6px;color:#0f172a;margin-bottom:10px;">
                <?= $isStore ? 'Tienda inactiva' : 'Cuenta inactiva' ?>
            </h1>

            <?php if ($isStore): ?>
            <p style="font-size:15px;color:#64748b;line-height:1.7;margin-bottom:20px;">
                Tu tienda ha sido <strong style="color:#dc2626;">desactivada</strong> temporalmente por el administrador de la plataforma. No puedes iniciar sesión mientras la tienda esté inactiva.
            </p>
            <div style="background:#fef9ec;border:1px solid #fde68a;border-radius:10px;padding:14px 16px;margin-bottom:24px;text-align:left;">
                <p style="font-size:13px;color:#92400e;line-height:1.6;margin:0;">
                    <i class="fas fa-info-circle" style="margin-right:6px;"></i>
                    Si crees que esto es un error, contacta al soporte de la plataforma para que reactiven tu tienda.
                </p>
            </div>
            <?php else: ?>
            <p style="font-size:15px;color:#64748b;line-height:1.7;margin-bottom:20px;">
                Tu cuenta ha sido <strong style="color:#dc2626;">desactivada</strong>. No es posible acceder a la plataforma con esta cuenta en este momento.
            </p>
            <div style="background:#fef9ec;border:1px solid #fde68a;border-radius:10px;padding:14px 16px;margin-bottom:24px;text-align:left;">
                <p style="font-size:13px;color:#92400e;line-height:1.6;margin:0;">
                    <i class="fas fa-info-circle" style="margin-right:6px;"></i>
                    Si crees que esto es un error o necesitas más información, comunícate con el soporte de la plataforma.
                </p>
            </div>
            <?php endif; ?>

            <!-- Action buttons -->
            <div style="display:flex;flex-direction:column;gap:10px;">
                <a href="<?= BASE_URL ?>auth/login"
                         style="display:flex;align-items:center;justify-content:center;gap:8px;height:44px;border-radius:10px;background:linear-gradient(135deg,#2a7a52,#1f5c3d);color:#fff;text-decoration:none;font-size:14px;font-weight:700;">
                    <i class="fas fa-arrow-left"></i> Volver al inicio de sesión
                </a>
                <a href="<?= BASE_URL ?>contact"
                   style="display:flex;align-items:center;justify-content:center;gap:8px;height:44px;border-radius:10px;border:1px solid #e2e8f0;background:#fff;color:#475569;text-decoration:none;font-size:14px;font-weight:600;">
                    <i class="fas fa-envelope"></i> Contactar soporte
                </a>
            </div>
        </div>

        <!-- Footer note -->
        <p style="margin-top:20px;font-size:12px;color:#94a3b8;">
            ¿No eres tú?
            <a href="<?= BASE_URL ?>auth/login" style="color:#2a7a52;text-decoration:none;font-weight:600;">Iniciar sesión con otra cuenta</a>
        </p>

    </div>
</div>

</body>
</html>
