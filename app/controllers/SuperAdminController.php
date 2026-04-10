<?php

require_once __DIR__ . '/../config/Config.php';
require_once __DIR__ . '/../models/Store.php';
require_once __DIR__ . '/../models/License.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Setting.php';
require_once __DIR__ . '/../helpers/Helper.php';
require_once __DIR__ . '/../helpers/NotificationService.php';
require_once __DIR__ . '/../middleware/Auth.php';

class SuperAdminController {
    
    public static function dashboard() {
        Auth::requireSuperAdmin();

        $store = new Store();
        $stores = $store->getAll(10, 0);

        $license = new License();
        $licenses = $license->getAllLicenses(10, 0);

        $user = new User();
        $totalUsers = $user->countAll();
        $totalSuperAdmins = $user->countAll(['role' => ROLE_SUPERADMIN]);

        include VIEWS_PATH . 'superadmin/dashboard.php';
    }

    public static function manageLicenses() {
        Auth::requireSuperAdmin();

        $page = intval($_GET['page'] ?? 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $storeFilterId = intval($_GET['store_id'] ?? 0);

        $license = new License();

        if ($storeFilterId > 0) {
            $licenses = $license->getAllLicenses(1000, 0);
            $licenses = array_values(array_filter($licenses, function ($item) use ($storeFilterId) {
                return intval($item['store_id'] ?? 0) === $storeFilterId;
            }));
        } else {
            $licenses = $license->getAllLicenses($limit, $offset);
        }

        foreach ($licenses as &$item) {
            $features = json_decode($item['features'] ?? '', true);
            if (!is_array($features)) {
                $features = Helper::getLicensePlan(intval($item['plan_id'] ?? 1));
            }
            $item['storage_gb'] = floatval($features['storage'] ?? 0);
            $item['module_inventory'] = !empty($features['module_inventory']) || in_array('inventory_module', $features['features'] ?? [], true);
            $item['module_finance'] = !empty($features['module_finance']) || in_array('finance_module', $features['features'] ?? [], true);
        }
        unset($item);

        include VIEWS_PATH . 'superadmin/licenses.php';
    }

    public static function createLicense() {
        Auth::requireSuperAdmin();

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            include VIEWS_PATH . 'superadmin/create-license.php';
            return;
        }

        $plan_id = intval($_POST['plan_id'] ?? 1);
        $trial_days = intval($_POST['trial_days'] ?? 15);
        $is_trial = isset($_POST['is_trial']) ? 1 : 0;
        $storage_gb = floatval($_POST['storage_gb'] ?? 0);
        $module_inventory = isset($_POST['module_inventory']) ? 1 : 0;
        $module_finance = isset($_POST['module_finance']) ? 1 : 0;

        if (!in_array($plan_id, [1, 2, 3], true)) {
            Helper::redirect(BASE_URL . 'superadmin/licenses/create?error=' . urlencode('Plan no válido'));
        }

        if ($storage_gb <= 0) {
            Helper::redirect(BASE_URL . 'superadmin/licenses/create?error=' . urlencode('El espacio de almacenamiento debe ser mayor a 0 GB'));
        }

        $license = new License();
        $license->plan_id = $plan_id;
        $license->trial_days = $trial_days;
        $license->is_trial = $is_trial;
        $licenseFeatures = Helper::getLicensePlan($plan_id);
        $licenseFeatures['storage'] = $storage_gb;
        $licenseFeatures['module_inventory'] = $module_inventory;
        $licenseFeatures['module_finance'] = $module_finance;
        if (!isset($licenseFeatures['features']) || !is_array($licenseFeatures['features'])) {
            $licenseFeatures['features'] = [];
        }
        if ($module_inventory && !in_array('inventory_module', $licenseFeatures['features'], true)) {
            $licenseFeatures['features'][] = 'inventory_module';
        }
        if (!$module_inventory) {
            $licenseFeatures['features'] = array_values(array_filter($licenseFeatures['features'], function ($feature) {
                return $feature !== 'inventory_module';
            }));
        }
        if ($module_finance && !in_array('finance_module', $licenseFeatures['features'], true)) {
            $licenseFeatures['features'][] = 'finance_module';
        }
        if (!$module_finance) {
            $licenseFeatures['features'] = array_values(array_filter($licenseFeatures['features'], function ($feature) {
                return $feature !== 'finance_module';
            }));
        }
        $license->features = $licenseFeatures;

        if ($license->create()) {
            Helper::redirect(BASE_URL . 'superadmin/licenses?success=' . urlencode('Licencia creada: ' . $license->code));
        }

        Helper::redirect(BASE_URL . 'superadmin/licenses/create?error=' . urlencode('Error al crear la licencia'));
    }

    public static function deleteLicense($license_id) {
        Auth::requireSuperAdmin();

        $license = new License();
        if ($license->deleteById($license_id)) {
            Helper::redirect(BASE_URL . 'superadmin/licenses?success=' . urlencode('Licencia eliminada exitosamente'));
        }

        Helper::redirect(BASE_URL . 'superadmin/licenses?error=' . urlencode('No se pudo eliminar la licencia'));
    }

    public static function updateLicenseStorage($license_id) {
        Auth::requireSuperAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect(BASE_URL . 'superadmin/licenses');
        }

        $storage_gb = floatval($_POST['storage_gb'] ?? 0);
        if ($storage_gb <= 0) {
            Helper::redirect(BASE_URL . 'superadmin/licenses?error=' . urlencode('El espacio de almacenamiento debe ser mayor a 0 GB'));
        }

        $license = new License();
        $licenseData = $license->findById($license_id);
        if (!$licenseData) {
            Helper::redirect(BASE_URL . 'superadmin/licenses?error=' . urlencode('Licencia no encontrada'));
        }

        $features = json_decode($licenseData['features'] ?? '', true);
        if (!is_array($features)) {
            $features = Helper::getLicensePlan(intval($licenseData['plan_id'] ?? 1));
        }

        $features['storage'] = $storage_gb;

        if ($license->updateFeaturesById($license_id, $features)) {
            Helper::redirect(BASE_URL . 'superadmin/licenses?success=' . urlencode('Espacio de licencia actualizado exitosamente'));
        }

        Helper::redirect(BASE_URL . 'superadmin/licenses?error=' . urlencode('No se pudo actualizar el espacio de la licencia'));
    }

    public static function updateLicenseModules($license_id) {
        Auth::requireSuperAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect(BASE_URL . 'superadmin/licenses');
        }

        $license = new License();
        $licenseData = $license->findById($license_id);
        if (!$licenseData) {
            Helper::redirect(BASE_URL . 'superadmin/licenses?error=' . urlencode('Licencia no encontrada'));
        }

        $features = json_decode($licenseData['features'] ?? '', true);
        if (!is_array($features)) {
            $features = Helper::getLicensePlan(intval($licenseData['plan_id'] ?? 1));
        }

        $moduleInventory = isset($_POST['module_inventory']);
        $moduleFinance = isset($_POST['module_finance']);

        $features['module_inventory'] = $moduleInventory ? 1 : 0;
        $features['module_finance'] = $moduleFinance ? 1 : 0;
        if (!isset($features['features']) || !is_array($features['features'])) {
            $features['features'] = [];
        }

        if ($moduleInventory && !in_array('inventory_module', $features['features'], true)) {
            $features['features'][] = 'inventory_module';
        }
        if (!$moduleInventory) {
            $features['features'] = array_values(array_filter($features['features'], function ($feature) {
                return $feature !== 'inventory_module';
            }));
        }

        if ($moduleFinance && !in_array('finance_module', $features['features'], true)) {
            $features['features'][] = 'finance_module';
        }
        if (!$moduleFinance) {
            $features['features'] = array_values(array_filter($features['features'], function ($feature) {
                return $feature !== 'finance_module';
            }));
        }

        if ($license->updateFeaturesById($license_id, $features)) {
            Helper::redirect(BASE_URL . 'superadmin/licenses?success=' . urlencode('Módulos de licencia actualizados exitosamente'));
        }

        Helper::redirect(BASE_URL . 'superadmin/licenses?error=' . urlencode('No se pudieron actualizar los módulos de la licencia'));
    }

    public static function manageStores() {
        Auth::requireSuperAdmin();

        $page = intval($_GET['page'] ?? 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $store = new Store();
        $stores = $store->getAll($limit, $offset);

        include VIEWS_PATH . 'superadmin/stores.php';
    }

    public static function manageUsers() {
        Auth::requireSuperAdmin();

        $page = max(1, intval($_GET['page'] ?? 1));
        $limit = 25;
        $offset = ($page - 1) * $limit;

        $roleFilter = Helper::sanitizeInput($_GET['role'] ?? '');
        $searchFilter = Helper::sanitizeInput($_GET['q'] ?? '');
        $storeFilterId = intval($_GET['store_id'] ?? 0);

        $filters = [];
        if (in_array($roleFilter, [ROLE_SUPERADMIN, ROLE_STORE_OWNER, ROLE_STORE_STAFF, ROLE_CUSTOMER], true)) {
            $filters['role'] = $roleFilter;
        } else {
            $roleFilter = '';
        }
        if ($storeFilterId > 0) {
            $filters['store_id'] = $storeFilterId;
        }
        if ($searchFilter !== '') {
            $filters['search'] = $searchFilter;
        }

        $store = new Store();
        $stores = $store->getAll(1000, 0);

        $user = new User();
        $users = $user->getAllWithStore($limit, $offset, $filters);
        $totalUsers = $user->countAll($filters);
        $totalPages = max(1, intval(ceil($totalUsers / $limit)));

        include VIEWS_PATH . 'superadmin/users.php';
    }

    public static function createSuperAdmin() {
        Auth::requireSuperAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include VIEWS_PATH . 'superadmin/create-superadmin.php';
            return;
        }

        $name = Helper::sanitizeInput($_POST['name'] ?? '');
        $email = Helper::sanitizeInput($_POST['email'] ?? '');
        $phone = Helper::sanitizeInput($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        if ($name === '' || $email === '' || $password === '' || $passwordConfirm === '') {
            Helper::redirect(BASE_URL . 'superadmin/users/create-superadmin?error=' . urlencode('Nombre, email y contraseña son obligatorios'));
        }

        if (!Helper::validateEmail($email)) {
            Helper::redirect(BASE_URL . 'superadmin/users/create-superadmin?error=' . urlencode('Email no válido'));
        }

        if (strlen($password) < 8) {
            Helper::redirect(BASE_URL . 'superadmin/users/create-superadmin?error=' . urlencode('La contraseña debe tener al menos 8 caracteres'));
        }

        if ($password !== $passwordConfirm) {
            Helper::redirect(BASE_URL . 'superadmin/users/create-superadmin?error=' . urlencode('Las contraseñas no coinciden'));
        }

        $user = new User();
        if ($user->findByEmail($email)) {
            Helper::redirect(BASE_URL . 'superadmin/users/create-superadmin?error=' . urlencode('Ese correo ya existe en la plataforma'));
        }

        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->phone = $phone;
        $user->role = ROLE_SUPERADMIN;
        $user->store_id = null;
        $user->is_active = 1;
        $user->email_verified = 1;

        if ($user->create()) {
            Helper::redirect(BASE_URL . 'superadmin/users?success=' . urlencode('Superadmin creado exitosamente'));
        }

        Helper::redirect(BASE_URL . 'superadmin/users/create-superadmin?error=' . urlencode('No se pudo crear el superadmin'));
    }

    public static function updateUser($user_id) {
        Auth::requireSuperAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect(BASE_URL . 'superadmin/users');
        }

        $user = new User();
        $store = new Store();
        $targetUser = $user->findById($user_id);

        if (!$targetUser) {
            Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('Usuario no encontrado'));
        }

        $name = Helper::sanitizeInput($_POST['name'] ?? '');
        $email = Helper::sanitizeInput($_POST['email'] ?? '');
        $phone = Helper::sanitizeInput($_POST['phone'] ?? '');
        $role = Helper::sanitizeInput($_POST['role'] ?? '');
        $storeIdRaw = intval($_POST['store_id'] ?? 0);
        $newPassword = trim($_POST['new_password'] ?? '');
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if ($name === '' || $email === '' || $role === '') {
            Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('Nombre, correo y rol son obligatorios'));
        }

        if (!Helper::validateEmail($email)) {
            Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('Correo electrónico no válido'));
        }

        if (!in_array($role, [ROLE_SUPERADMIN, ROLE_STORE_OWNER, ROLE_STORE_STAFF, ROLE_CUSTOMER], true)) {
            Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('Rol no válido'));
        }

        if ($user->emailExistsExceptId($email, $user_id)) {
            Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('Ya existe otro usuario con ese correo'));
        }

        $storeId = $storeIdRaw > 0 ? $storeIdRaw : null;
        if ($role === ROLE_SUPERADMIN) {
            $storeId = null;
        } else if ($storeId === null) {
            Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('Debes asignar una tienda para este rol'));
        }

        if ($storeId !== null && !$store->findById($storeId)) {
            Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('La tienda seleccionada no existe'));
        }

        $isSelf = intval($_SESSION['user_id'] ?? 0) === intval($user_id);
        if ($isSelf && $role !== ROLE_SUPERADMIN) {
            Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('No puedes quitarte el rol de superadmin'));
        }
        if ($isSelf && !$isActive) {
            Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('No puedes desactivar tu propia cuenta'));
        }

        $superAdminCount = $user->countAll(['role' => ROLE_SUPERADMIN, 'is_active' => 1]);
        if ($targetUser['role'] === ROLE_SUPERADMIN && $superAdminCount <= 1) {
            if ($role !== ROLE_SUPERADMIN || !$isActive) {
                Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('Debe existir al menos un superadmin activo'));
            }
        }

        if ($targetUser['role'] === ROLE_STORE_OWNER && $role !== ROLE_STORE_OWNER) {
            $ownedStores = $store->findByOwnerId($user_id);
            if (!empty($ownedStores)) {
                Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('Primero reasigna las tiendas de este propietario antes de cambiar su rol'));
            }
        }

        $payload = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'role' => $role,
            'store_id' => $storeId,
            'is_active' => $isActive
        ];

        if (!$user->updateByAdmin($user_id, $payload)) {
            Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('No se pudo actualizar el usuario'));
        }

        if ($role === ROLE_STORE_OWNER && $storeId !== null) {
            $store->setOwner($storeId, $user_id);
        }

        if ($newPassword !== '') {
            if (strlen($newPassword) < 8) {
                Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('La nueva contraseña debe tener al menos 8 caracteres'));
            }

            if (!$user->updatePassword($user_id, $newPassword)) {
                Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('No se pudo actualizar la contraseña'));
            }
        }

        if ($isSelf) {
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['store_id'] = $storeId;
        }

        Helper::redirect(BASE_URL . 'superadmin/users?success=' . urlencode('Usuario actualizado exitosamente'));
    }

    public static function toggleUserStatus($user_id) {
        Auth::requireSuperAdmin();

        $user = new User();
        $targetUser = $user->findById($user_id);
        if (!$targetUser) {
            Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('Usuario no encontrado'));
        }

        if (intval($_SESSION['user_id'] ?? 0) === intval($user_id)) {
            Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('No puedes inactivar tu propia cuenta'));
        }

        if ($targetUser['role'] === ROLE_SUPERADMIN && !empty($targetUser['is_active'])) {
            $superAdminCount = $user->countAll(['role' => ROLE_SUPERADMIN, 'is_active' => 1]);
            if ($superAdminCount <= 1) {
                Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('Debe existir al menos un superadmin activo'));
            }
        }

        $newStatus = empty($targetUser['is_active']) ? 1 : 0;
        if ($user->setActiveStatus($user_id, $newStatus)) {
            $text = $newStatus ? 'activado' : 'inactivado';
            Helper::redirect(BASE_URL . 'superadmin/users?success=' . urlencode('Usuario ' . $text . ' exitosamente'));
        }

        Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('No se pudo cambiar el estado del usuario'));
    }

    public static function deleteUser($user_id) {
        Auth::requireSuperAdmin();

        $user = new User();
        $store = new Store();
        $targetUser = $user->findById($user_id);
        if (!$targetUser) {
            Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('Usuario no encontrado'));
        }

        if (intval($_SESSION['user_id'] ?? 0) === intval($user_id)) {
            Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('No puedes eliminar tu propia cuenta'));
        }

        if ($targetUser['role'] === ROLE_SUPERADMIN) {
            $superAdminCount = $user->countAll(['role' => ROLE_SUPERADMIN, 'is_active' => 1]);
            if ($superAdminCount <= 1) {
                Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('No puedes eliminar el último superadmin'));
            }
        }

        if ($targetUser['role'] === ROLE_STORE_OWNER) {
            $ownedStores = $store->findByOwnerId($user_id);
            if (!empty($ownedStores)) {
                Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('No se puede eliminar: el usuario aún es propietario de una tienda'));
            }
        }

        if ($user->deleteById($user_id)) {
            Helper::redirect(BASE_URL . 'superadmin/users?success=' . urlencode('Usuario eliminado exitosamente'));
        }

        Helper::redirect(BASE_URL . 'superadmin/users?error=' . urlencode('No se pudo eliminar el usuario'));
    }

    public static function viewStore($store_id) {
        Auth::requireSuperAdmin();

        $store = new Store();
        $storeData = $store->findById($store_id);

        if (!$storeData) {
            Helper::redirect(BASE_URL . 'superadmin/stores');
        }

        $user = new User();
        $storeUsers = $user->getUserByStoreId($store_id);

        include VIEWS_PATH . 'superadmin/view-store.php';
    }

    public static function settings() {
        Auth::requireSuperAdmin();

        $setting = new Setting();
        $defaultDemoEnabled = (defined('ENABLE_DEMO_ACCOUNTS') && ENABLE_DEMO_ACCOUNTS) ? '1' : '0';
        $defaultShowPasswords = (defined('SHOW_DEMO_PASSWORDS') && SHOW_DEMO_PASSWORDS) ? '1' : '0';

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $platformSettings = [
                'demo_accounts_enabled' => $setting->getValue('platform_demo_accounts_enabled', $defaultDemoEnabled),
                'demo_passwords_visible' => $setting->getValue('platform_demo_passwords_visible', $defaultShowPasswords),
                'demo_block_visible' => $setting->getValue('platform_demo_block_visible', $defaultDemoEnabled)
            ];
            include VIEWS_PATH . 'superadmin/settings.php';
            return;
        }

        $demoAccountsEnabled  = isset($_POST['demo_accounts_enabled'])  ? '1' : '0';
        $demoPasswordsVisible = isset($_POST['demo_passwords_visible']) ? '1' : '0';
        $demoBlockVisible     = isset($_POST['demo_block_visible'])     ? '1' : '0';

        if ($demoAccountsEnabled === '0') {
            $demoPasswordsVisible = '0';
            $demoBlockVisible     = '0';
        }

        $valuesToSave = [
            'platform_demo_accounts_enabled'  => [$demoAccountsEnabled,  'boolean'],
            'platform_demo_passwords_visible' => [$demoPasswordsVisible, 'boolean'],
            'platform_demo_block_visible'     => [$demoBlockVisible,     'boolean']
        ];

        $allOk = true;
        foreach ($valuesToSave as $key => $payload) {
            if (!$setting->setValue($key, $payload[0], $payload[1])) {
                $allOk = false;
            }
        }

        if ($allOk) {
            Helper::redirect(BASE_URL . 'superadmin/settings?success=' . urlencode('Configuración guardada exitosamente'));
        }
        Helper::redirect(BASE_URL . 'superadmin/settings?error=' . urlencode('No se pudo guardar la configuración'));
    }

    public static function manageEmails() {
        Auth::requireSuperAdmin();

        $setting            = new Setting();
        $notificationDefaults = NotificationService::getConfig();

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $emailSettings = [
                'notifications_enabled'       => $setting->getValue('platform_notifications_enabled', $notificationDefaults['enabled'] ?? '1'),
                'notifications_admin_recipient' => $setting->getValue('platform_notifications_admin_recipient', $notificationDefaults['admin_recipient'] ?? ''),
                'notifications_from_name'     => $setting->getValue('platform_notifications_from_name', $notificationDefaults['from_name'] ?? 'Kyros Commerce'),
                'notifications_from_email'    => $setting->getValue('platform_notifications_from_email', $notificationDefaults['from_email'] ?? ''),
                'notifications_smtp_host'     => $setting->getValue('platform_notifications_smtp_host', $notificationDefaults['smtp_host'] ?? ''),
                'notifications_smtp_port'     => $setting->getValue('platform_notifications_smtp_port', $notificationDefaults['smtp_port'] ?? '465'),
                'notifications_smtp_security' => $setting->getValue('platform_notifications_smtp_security', $notificationDefaults['smtp_security'] ?? 'ssl'),
                'notifications_smtp_username' => $setting->getValue('platform_notifications_smtp_username', $notificationDefaults['smtp_username'] ?? ''),
                'notify_new_registration'     => $setting->getValue('platform_notifications_notify_new_registration', $notificationDefaults['notify_new_registration'] ?? '1'),
                'notify_new_order'            => $setting->getValue('platform_notifications_notify_new_order', $notificationDefaults['notify_new_order'] ?? '1'),
                'notify_forgot_password'      => $setting->getValue('platform_notifications_notify_forgot_password', $notificationDefaults['notify_forgot_password'] ?? '1'),
                'notify_customer_welcome'     => $setting->getValue('platform_notifications_notify_customer_welcome', $notificationDefaults['notify_customer_welcome'] ?? '1'),
                'notify_customer_order_copy'  => $setting->getValue('platform_notifications_notify_customer_order_copy', $notificationDefaults['notify_customer_order_copy'] ?? '1'),
                'registration_recipients'     => $setting->getValue('platform_notifications_registration_recipients', $notificationDefaults['registration_recipients'] ?? ''),
                'order_recipients'            => $setting->getValue('platform_notifications_order_recipients', $notificationDefaults['order_recipients'] ?? '')
            ];
            include VIEWS_PATH . 'superadmin/emails.php';
            return;
        }

        // --- Enviar correo de prueba ---
        if (isset($_POST['send_test_email'])) {
            $targetEmail = Helper::sanitizeInput($_POST['test_email'] ?? '');
            $emailType   = Helper::sanitizeInput($_POST['test_type'] ?? 'test');
            $validTypes  = ['welcome', 'new_registration_admin', 'new_order_admin', 'order_confirmation', 'forgot_password', 'test'];
            if (!in_array($emailType, $validTypes, true)) {
                $emailType = 'test';
            }
            $okTest = NotificationService::sendTestEmail($targetEmail, $emailType);
            if ($okTest) {
                Helper::redirect(BASE_URL . 'superadmin/emails?success=' . urlencode('Correo de prueba enviado a ' . $targetEmail));
            }
            Helper::redirect(BASE_URL . 'superadmin/emails?error=' . urlencode('No se pudo enviar el correo. Verifica tu configuración SMTP.'));
        }

        // --- Guardar configuración ---
        $notificationsEnabled    = isset($_POST['notifications_enabled'])     ? '1' : '0';
        $notifyNewRegistration   = isset($_POST['notify_new_registration'])   ? '1' : '0';
        $notifyNewOrder          = isset($_POST['notify_new_order'])          ? '1' : '0';
        $notifyForgotPassword    = isset($_POST['notify_forgot_password'])    ? '1' : '0';
        $notifyCustomerWelcome   = isset($_POST['notify_customer_welcome'])   ? '1' : '0';
        $notifyCustomerOrderCopy = isset($_POST['notify_customer_order_copy']) ? '1' : '0';

        $smtpPort = intval($_POST['notifications_smtp_port'] ?? 0);
        if ($smtpPort <= 0) $smtpPort = 465;

        $smtpSecurity = strtolower(Helper::sanitizeInput($_POST['notifications_smtp_security'] ?? 'ssl'));
        if (!in_array($smtpSecurity, ['ssl', 'tls', 'none'], true)) $smtpSecurity = 'ssl';

        $newPasswordRaw  = trim((string) ($_POST['notifications_smtp_password'] ?? ''));
        $currentPassword = $setting->getValue('platform_notifications_smtp_password', $notificationDefaults['smtp_password'] ?? '');
        $passwordToSave  = $newPasswordRaw !== '' ? $newPasswordRaw : $currentPassword;

        // Validate comma-separated recipient lists
        $registrationRecipients = self::sanitizeEmailList($_POST['registration_recipients'] ?? '');
        $orderRecipients        = self::sanitizeEmailList($_POST['order_recipients'] ?? '');

        $valuesToSave = [
            'platform_notifications_enabled'                    => [$notificationsEnabled,    'boolean'],
            'platform_notifications_admin_recipient'            => [Helper::sanitizeInput($_POST['notifications_admin_recipient'] ?? ''), 'string'],
            'platform_notifications_from_name'                  => [Helper::sanitizeInput($_POST['notifications_from_name'] ?? 'Kyros Commerce'), 'string'],
            'platform_notifications_from_email'                 => [Helper::sanitizeInput($_POST['notifications_from_email'] ?? ''), 'string'],
            'platform_notifications_smtp_host'                  => [Helper::sanitizeInput($_POST['notifications_smtp_host'] ?? ''), 'string'],
            'platform_notifications_smtp_port'                  => [strval($smtpPort), 'number'],
            'platform_notifications_smtp_security'              => [$smtpSecurity, 'string'],
            'platform_notifications_smtp_username'              => [Helper::sanitizeInput($_POST['notifications_smtp_username'] ?? ''), 'string'],
            'platform_notifications_smtp_password'              => [$passwordToSave, 'string'],
            'platform_notifications_notify_new_registration'    => [$notifyNewRegistration,   'boolean'],
            'platform_notifications_notify_new_order'           => [$notifyNewOrder,           'boolean'],
            'platform_notifications_notify_forgot_password'     => [$notifyForgotPassword,     'boolean'],
            'platform_notifications_notify_customer_welcome'    => [$notifyCustomerWelcome,    'boolean'],
            'platform_notifications_notify_customer_order_copy' => [$notifyCustomerOrderCopy,  'boolean'],
            'platform_notifications_registration_recipients'    => [$registrationRecipients,   'string'],
            'platform_notifications_order_recipients'           => [$orderRecipients,           'string']
        ];

        $allOk = true;
        foreach ($valuesToSave as $key => $payload) {
            if (!$setting->setValue($key, $payload[0], $payload[1])) {
                $allOk = false;
            }
        }

        if ($allOk) {
            Helper::redirect(BASE_URL . 'superadmin/emails?success=' . urlencode('Configuración de correos guardada exitosamente'));
        }
        Helper::redirect(BASE_URL . 'superadmin/emails?error=' . urlencode('No se pudo guardar la configuración de correos'));
    }

    public static function previewEmail() {
        Auth::requireSuperAdmin();

        require_once __DIR__ . '/../helpers/EmailTemplate.php';

        $type       = Helper::sanitizeInput($_GET['type'] ?? 'test');
        $validTypes = ['welcome', 'new_registration_admin', 'new_order_admin', 'order_confirmation', 'forgot_password', 'test'];
        if (!in_array($type, $validTypes, true)) {
            $type = 'test';
        }

        $date   = date('d/m/Y H:i');
        $appUrl = defined('BASE_URL') ? rtrim(BASE_URL, '/') : '';

        header('Content-Type: text/html; charset=UTF-8');
        switch ($type) {
            case 'welcome':
                echo EmailTemplate::welcome('María García', 'demo@ejemplo.com', 'Mi Tienda Online', 'Básico', $appUrl, $appUrl);
                break;
            case 'new_registration_admin':
                echo EmailTemplate::newRegistrationAdmin('María García', 'demo@ejemplo.com', 'Mi Tienda Online', 'Básico', $date, $appUrl);
                break;
            case 'new_order_admin':
                echo EmailTemplate::newOrderAdmin('ORD-0001', 'Mi Tienda Online', 'Carlos Pérez', 'cliente@demo.com', 'RD$ 2,500.00', $date, $appUrl);
                break;
            case 'order_confirmation':
                echo EmailTemplate::orderConfirmation('Carlos Pérez', 'ORD-0001', 'Mi Tienda Online', 'RD$ 2,500.00', $date, $appUrl);
                break;
            case 'forgot_password':
                echo EmailTemplate::forgotPassword('demo@ejemplo.com', $date, $appUrl);
                break;
            default:
                echo EmailTemplate::smtpTest($date, $appUrl);
                break;
        }
        exit;
    }

    private static function sanitizeEmailList(string $raw): string {
        $clean = [];
        foreach (explode(',', Helper::sanitizeInput($raw)) as $email) {
            $email = trim($email);
            if (Helper::validateEmail($email)) {
                $clean[] = $email;
            }
        }
        return implode(',', $clean);
    }

    public static function toggleStoreStatus($store_id) {
        Auth::requireSuperAdmin();

        $store = new Store();
        $storeData = $store->findById($store_id);

        if (!$storeData) {
            Helper::redirect(BASE_URL . 'superadmin/stores?error=' . urlencode('Tienda no encontrada'));
        }

        $newStatus = empty($storeData['is_active']);
        if ($store->setActiveStatus($store_id, $newStatus)) {
            $statusText = $newStatus ? 'activada' : 'inactivada';
            Helper::redirect(BASE_URL . 'superadmin/stores/' . $store_id . '?success=' . urlencode('Tienda ' . $statusText . ' exitosamente'));
        }

        Helper::redirect(BASE_URL . 'superadmin/stores/' . $store_id . '?error=' . urlencode('No se pudo cambiar el estado de la tienda'));
    }

    public static function deleteStore($store_id) {
        Auth::requireSuperAdmin();

        // Guard: prevent deleting the store associated with the current session
        if (!empty($_SESSION['store_id']) && intval($_SESSION['store_id']) === intval($store_id)) {
            Helper::redirect(BASE_URL . 'superadmin/stores/' . $store_id . '?error=' . urlencode('No puedes eliminar tu propia tienda'));
        }

        $store = new Store();
        $storeData = $store->findById($store_id);

        if (!$storeData) {
            Helper::redirect(BASE_URL . 'superadmin/stores?error=' . urlencode('Tienda no encontrada'));
        }

        // Guard: prevent deleting if current user is the store owner
        if (!empty($_SESSION['user_id']) && intval($storeData['owner_id'] ?? 0) === intval($_SESSION['user_id'])) {
            Helper::redirect(BASE_URL . 'superadmin/stores/' . $store_id . '?error=' . urlencode('No puedes eliminar una tienda de la que eres propietario'));
        }

        if ($store->deleteById($store_id)) {
            Helper::redirect(BASE_URL . 'superadmin/stores?success=' . urlencode('Tienda eliminada exitosamente'));
        }

        Helper::redirect(BASE_URL . 'superadmin/stores/' . $store_id . '?error=' . urlencode('No se pudo eliminar la tienda'));
    }
}
