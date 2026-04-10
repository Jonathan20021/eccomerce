<?php

require_once __DIR__ . '/../models/Setting.php';
require_once __DIR__ . '/Helper.php';
require_once __DIR__ . '/EmailTemplate.php';

class NotificationService {
    private static function defaultConfig() {
        return [
            'enabled' => '1',
            'admin_recipient' => defined('NOTIFICATIONS_DEFAULT_ADMIN_RECIPIENT') ? NOTIFICATIONS_DEFAULT_ADMIN_RECIPIENT : 'notificaciones@kyrosrd.com',
            'from_name' => defined('NOTIFICATIONS_DEFAULT_FROM_NAME') ? NOTIFICATIONS_DEFAULT_FROM_NAME : 'Kyros Commerce',
            'from_email' => defined('NOTIFICATIONS_DEFAULT_FROM_EMAIL') ? NOTIFICATIONS_DEFAULT_FROM_EMAIL : 'notificaciones@kyrosrd.com',
            'smtp_host' => defined('NOTIFICATIONS_DEFAULT_SMTP_HOST') ? NOTIFICATIONS_DEFAULT_SMTP_HOST : 'localhost',
            'smtp_port' => defined('NOTIFICATIONS_DEFAULT_SMTP_PORT') ? strval(NOTIFICATIONS_DEFAULT_SMTP_PORT) : '465',
            'smtp_security' => defined('NOTIFICATIONS_DEFAULT_SMTP_SECURITY') ? NOTIFICATIONS_DEFAULT_SMTP_SECURITY : 'ssl',
            'smtp_username' => defined('NOTIFICATIONS_DEFAULT_SMTP_USERNAME') ? NOTIFICATIONS_DEFAULT_SMTP_USERNAME : 'notificaciones@kyrosrd.com',
            'smtp_password' => defined('NOTIFICATIONS_DEFAULT_SMTP_PASSWORD') ? NOTIFICATIONS_DEFAULT_SMTP_PASSWORD : '',
            'notify_new_registration' => '1',
            'notify_new_order' => '1',
            'notify_forgot_password' => '1',
            'notify_customer_welcome' => '1',
            'notify_customer_order_copy' => '1',
            'registration_recipients' => '',
            'order_recipients' => ''
        ];
    }

    public static function getConfig() {
        $defaults = self::defaultConfig();

        try {
            $setting = new Setting();
            foreach ($defaults as $key => $defaultValue) {
                $storedValue = $setting->getValue('platform_notifications_' . $key, null);
                if ($storedValue !== null && $storedValue !== '') {
                    $defaults[$key] = (string) $storedValue;
                }
            }
        } catch (Throwable $e) {
            // Keep defaults when settings are not available.
        }

        return $defaults;
    }

    public static function isEnabled() {
        $config = self::getConfig();
        return ($config['enabled'] ?? '0') === '1';
    }

    public static function notifyNewRegistration($name, $email, $storeName, $planId) {
        $config = self::getConfig();
        if (!self::isEnabled() || ($config['notify_new_registration'] ?? '0') !== '1') {
            return false;
        }

        $date    = date('d/m/Y H:i');
        $planName = 'Plan ' . intval($planId);
        $appUrl  = defined('BASE_URL') ? rtrim(BASE_URL, '/') : '';

        // Notificación a admin(s)
        $subjectAdmin = 'Nueva cuenta registrada en Kyros Commerce';
        $htmlAdmin    = EmailTemplate::newRegistrationAdmin(
            (string) $name, (string) $email, (string) $storeName, $planName, $date, $appUrl
        );
        $textAdmin = "Nueva cuenta registrada\nNombre: $name\nEmail: $email\nTienda: $storeName\nPlan: $planName\nFecha: $date";

        $recipients = self::parseRecipients(
            $config['registration_recipients'] ?? '',
            $config['admin_recipient'] ?? ''
        );
        $okAdmin = true;
        foreach ($recipients as $recipient) {
            if (!self::sendEmail($recipient, $subjectAdmin, $htmlAdmin, $textAdmin)) {
                $okAdmin = false;
            }
        }

        // Bienvenida al cliente
        $okCustomer = true;
        if (($config['notify_customer_welcome'] ?? '0') === '1') {
            $subjectCustomer = '¡Bienvenido a Kyros Commerce!';
            $htmlCustomer    = EmailTemplate::welcome(
                (string) $name, (string) $email, (string) $storeName, $planName,
                $appUrl, $appUrl ? $appUrl . '/login' : ''
            );
            $textCustomer = "¡Bienvenido a Kyros Commerce!\n\nHola $name,\nTu tienda $storeName está lista.\nInicia sesión en: " . ($appUrl ?: 'Kyros Commerce');
            $okCustomer = self::sendEmail((string) $email, $subjectCustomer, $htmlCustomer, $textCustomer);
        }

        return $okAdmin && $okCustomer;
    }

    public static function notifyNewOrder($orderNumber, $storeName, $customerName, $customerEmail, $total) {
        $config = self::getConfig();
        if (!self::isEnabled() || ($config['notify_new_order'] ?? '0') !== '1') {
            return false;
        }

        $date   = date('d/m/Y H:i');
        $appUrl = defined('BASE_URL') ? rtrim(BASE_URL, '/') : '';

        // Notificación a admin(s)
        $subjectAdmin = 'Nueva orden recibida: ' . $orderNumber;
        $htmlAdmin    = EmailTemplate::newOrderAdmin(
            (string) $orderNumber, (string) $storeName, (string) $customerName,
            (string) $customerEmail, (string) $total, $date, $appUrl
        );
        $textAdmin = "Nueva orden\nOrden: $orderNumber\nTienda: $storeName\nCliente: $customerName ($customerEmail)\nTotal: $total\nFecha: $date";

        $recipients = self::parseRecipients(
            $config['order_recipients'] ?? '',
            $config['admin_recipient'] ?? ''
        );
        $okAdmin = true;
        foreach ($recipients as $recipient) {
            if (!self::sendEmail($recipient, $subjectAdmin, $htmlAdmin, $textAdmin)) {
                $okAdmin = false;
            }
        }

        // Confirmación al cliente
        $okCustomer = true;
        if (($config['notify_customer_order_copy'] ?? '0') === '1' && Helper::validateEmail($customerEmail)) {
            $subjectCustomer = 'Confirmación de orden ' . $orderNumber;
            $htmlCustomer    = EmailTemplate::orderConfirmation(
                (string) $customerName, (string) $orderNumber, (string) $storeName,
                (string) $total, $date, $appUrl
            );
            $textCustomer = "Recibimos tu orden\nNúmero: $orderNumber\nTienda: $storeName\nTotal: $total\nGracias por tu compra.";
            $okCustomer = self::sendEmail((string) $customerEmail, $subjectCustomer, $htmlCustomer, $textCustomer);
        }

        return $okAdmin && $okCustomer;
    }

    public static function notifyForgotPasswordRequest($email) {
        $config = self::getConfig();
        if (!self::isEnabled() || ($config['notify_forgot_password'] ?? '0') !== '1') {
            return false;
        }

        $date   = date('d/m/Y H:i');
        $appUrl = defined('BASE_URL') ? rtrim(BASE_URL, '/') : '';
        $cleanEmail = (string) $email;

        // Notificación al admin
        $subjectAdmin = 'Solicitud de recuperación de acceso';
        $htmlAdmin    = EmailTemplate::forgotPassword($cleanEmail, $date, $appUrl);
        $textAdmin    = "Solicitud de recuperación\nEmail: $cleanEmail\nFecha: $date";
        $okAdmin = self::sendEmail($config['admin_recipient'], $subjectAdmin, $htmlAdmin, $textAdmin);

        // Notificación al usuario
        $okUser = true;
        if (Helper::validateEmail($cleanEmail)) {
            $subjectUser = 'Solicitud de recuperación de acceso a Kyros Commerce';
            $htmlUser    = EmailTemplate::forgotPassword($cleanEmail, $date, $appUrl);
            $textUser    = "Hemos recibido una solicitud para recuperar tu acceso en Kyros Commerce.\nSi no realizaste esta solicitud, ignora este correo.";
            $okUser = self::sendEmail($cleanEmail, $subjectUser, $htmlUser, $textUser);
        }

        return $okAdmin && $okUser;
    }

    public static function sendTestEmail($toEmail = '', $type = 'test') {
        $config = self::getConfig();
        $target = trim((string) $toEmail) !== '' ? trim((string) $toEmail) : ($config['admin_recipient'] ?? '');
        if (!Helper::validateEmail($target)) {
            return false;
        }

        $date   = date('d/m/Y H:i');
        $appUrl = defined('BASE_URL') ? rtrim(BASE_URL, '/') : '';

        switch ($type) {
            case 'welcome':
                $subject = '¡Bienvenido a Kyros Commerce! [PRUEBA]';
                $html    = EmailTemplate::welcome('Usuario Demo', $target, 'Tienda Demo', 'Básico', $appUrl, $appUrl);
                break;
            case 'new_registration_admin':
                $subject = 'Nuevo registro [PRUEBA]';
                $html    = EmailTemplate::newRegistrationAdmin('Usuario Demo', $target, 'Tienda Demo', 'Básico', $date, $appUrl);
                break;
            case 'new_order_admin':
                $subject = 'Nueva orden recibida [PRUEBA]';
                $html    = EmailTemplate::newOrderAdmin('ORD-0001', 'Tienda Demo', 'Cliente Demo', $target, 'RD$ 1,500.00', $date, $appUrl);
                break;
            case 'order_confirmation':
                $subject = 'Confirmación de orden [PRUEBA]';
                $html    = EmailTemplate::orderConfirmation('Cliente Demo', 'ORD-0001', 'Tienda Demo', 'RD$ 1,500.00', $date, $appUrl);
                break;
            case 'forgot_password':
                $subject = 'Recuperación de acceso [PRUEBA]';
                $html    = EmailTemplate::forgotPassword($target, $date, $appUrl);
                break;
            default:
                $subject = 'Prueba SMTP — Kyros Commerce';
                $html    = EmailTemplate::smtpTest($date, $appUrl);
                break;
        }

        $text = strip_tags(str_replace(['</td>', '</tr>', '</p>'], "\n", $html));
        return self::sendEmail($target, $subject, $html, $text);
    }

    private static function parseRecipients(string $recipientsList, string $fallback): array {
        $list = array_filter(array_map('trim', explode(',', $recipientsList)));
        $list = array_filter($list, function ($e) { return Helper::validateEmail($e); });
        if (empty($list) && Helper::validateEmail($fallback)) {
            $list = [$fallback];
        }
        return array_values($list);
    }

    public static function sendEmail($to, $subject, $htmlBody, $textBody = '') {
        $config = self::getConfig();

        if (($config['enabled'] ?? '0') !== '1') {
            return false;
        }

        if (!Helper::validateEmail($to)) {
            return false;
        }

        $host = trim((string) ($config['smtp_host'] ?? ''));
        $port = intval($config['smtp_port'] ?? 0);
        $security = strtolower(trim((string) ($config['smtp_security'] ?? 'none')));
        $username = trim((string) ($config['smtp_username'] ?? ''));
        $password = (string) ($config['smtp_password'] ?? '');
        $fromEmail = trim((string) ($config['from_email'] ?? ''));
        $fromName = trim((string) ($config['from_name'] ?? 'Kyros Commerce'));

        if ($host === '' || $port <= 0 || $username === '' || $password === '' || !Helper::validateEmail($fromEmail)) {
            return false;
        }

        if ($textBody === '') {
            $textBody = strip_tags($htmlBody);
        }

        $boundary = 'b' . md5((string) microtime(true));
        $message = '';
        $message .= 'From: ' . self::formatAddress($fromEmail, $fromName) . "\r\n";
        $message .= 'To: ' . self::formatAddress($to, '') . "\r\n";
        $message .= 'Subject: ' . self::encodeHeader($subject) . "\r\n";
        $message .= 'Date: ' . date(DATE_RFC2822) . "\r\n";
        $message .= 'MIME-Version: 1.0' . "\r\n";
        $message .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '"' . "\r\n";
        $message .= "\r\n";
        $message .= '--' . $boundary . "\r\n";
        $message .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";
        $message .= 'Content-Transfer-Encoding: 8bit' . "\r\n\r\n";
        $message .= $textBody . "\r\n\r\n";
        $message .= '--' . $boundary . "\r\n";
        $message .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        $message .= 'Content-Transfer-Encoding: 8bit' . "\r\n\r\n";
        $message .= $htmlBody . "\r\n\r\n";
        $message .= '--' . $boundary . '--' . "\r\n";

        return self::smtpSend($host, $port, $security, $username, $password, $fromEmail, $to, $message);
    }

    private static function smtpSend($host, $port, $security, $username, $password, $fromEmail, $to, $message) {
        $remoteHost = $security === 'ssl' ? 'ssl://' . $host : $host;
        $errno = 0;
        $errstr = '';

        $socket = @fsockopen($remoteHost, $port, $errno, $errstr, 20);
        if (!$socket) {
            return false;
        }

        stream_set_timeout($socket, 20);

        if (!self::expectResponse($socket, [220])) {
            fclose($socket);
            return false;
        }

        $hostName = $_SERVER['HTTP_HOST'] ?? 'localhost';
        if (!self::sendCommand($socket, 'EHLO ' . $hostName, [250])) {
            fclose($socket);
            return false;
        }

        if ($security === 'tls') {
            if (!self::sendCommand($socket, 'STARTTLS', [220])) {
                fclose($socket);
                return false;
            }

            if (!@stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                fclose($socket);
                return false;
            }

            if (!self::sendCommand($socket, 'EHLO ' . $hostName, [250])) {
                fclose($socket);
                return false;
            }
        }

        if (!self::sendCommand($socket, 'AUTH LOGIN', [334])) {
            fclose($socket);
            return false;
        }

        if (!self::sendCommand($socket, base64_encode($username), [334])) {
            fclose($socket);
            return false;
        }

        if (!self::sendCommand($socket, base64_encode($password), [235])) {
            fclose($socket);
            return false;
        }

        if (!self::sendCommand($socket, 'MAIL FROM:<' . $fromEmail . '>', [250])) {
            fclose($socket);
            return false;
        }

        if (!self::sendCommand($socket, 'RCPT TO:<' . $to . '>', [250, 251])) {
            fclose($socket);
            return false;
        }

        if (!self::sendCommand($socket, 'DATA', [354])) {
            fclose($socket);
            return false;
        }

        fwrite($socket, $message . "\r\n.\r\n");
        if (!self::expectResponse($socket, [250])) {
            fclose($socket);
            return false;
        }

        self::sendCommand($socket, 'QUIT', [221]);
        fclose($socket);
        return true;
    }

    private static function sendCommand($socket, $command, $expectedCodes) {
        fwrite($socket, $command . "\r\n");
        return self::expectResponse($socket, $expectedCodes);
    }

    private static function expectResponse($socket, $expectedCodes) {
        $response = '';

        while (($line = fgets($socket, 515)) !== false) {
            $response .= $line;
            if (strlen($line) < 4) {
                break;
            }

            if ($line[3] === ' ') {
                break;
            }
        }

        if ($response === '') {
            return false;
        }

        $code = intval(substr($response, 0, 3));
        return in_array($code, $expectedCodes, true);
    }

    private static function encodeHeader($value) {
        $value = trim((string) $value);
        if ($value === '') {
            return '';
        }

        return '=?UTF-8?B?' . base64_encode($value) . '?=';
    }

    private static function formatAddress($email, $name) {
        $email = trim((string) $email);
        $name = trim((string) $name);

        if ($name === '') {
            return '<' . $email . '>';
        }

        return self::encodeHeader($name) . ' <' . $email . '>';
    }
}
