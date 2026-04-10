<?php

require_once __DIR__ . '/../config/Config.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Store.php';
require_once __DIR__ . '/../models/License.php';
require_once __DIR__ . '/../models/Setting.php';
require_once __DIR__ . '/../helpers/Helper.php';
require_once __DIR__ . '/../middleware/Auth.php';

class AuthController {

    private static function getPlatformToggle($key, $default) {
        try {
            $setting = new Setting();
            $raw = $setting->getValue($key, $default ? '1' : '0');
            return strval($raw) === '1';
        } catch (Throwable $e) {
            return $default;
        }
    }

    private static function isDemoAccountsEnabled() {
        $defaultEnabled = defined('ENABLE_DEMO_ACCOUNTS') && ENABLE_DEMO_ACCOUNTS;
        return self::getPlatformToggle('platform_demo_accounts_enabled', $defaultEnabled);
    }

    private static function isDemoPasswordsVisible() {
        if (!self::isDemoAccountsEnabled()) {
            return false;
        }

        $defaultVisible = defined('SHOW_DEMO_PASSWORDS') && SHOW_DEMO_PASSWORDS;
        return self::getPlatformToggle('platform_demo_passwords_visible', $defaultVisible);
    }

    private static function isDemoBlockVisible() {
        if (!self::isDemoAccountsEnabled()) {
            return false;
        }

        return self::getPlatformToggle('platform_demo_block_visible', true);
    }

    private static function getDemoAccountsConfig() {
        return [
            [
                'key' => 'demo_superadmin',
                'name' => 'Demo SuperAdmin',
                'email' => 'demo.admin@kyros.com',
                'password' => 'DemoAdmin123!',
                'phone' => '+57 300 000 0001',
                'role' => ROLE_SUPERADMIN,
                'store_name' => '',
                'plan_id' => 1
            ],
            [
                'key' => 'demo_starter',
                'name' => 'Demo Tienda Starter',
                'email' => 'demo.starter@kyros.com',
                'password' => 'DemoStore123!',
                'phone' => '+57 300 000 0002',
                'role' => ROLE_STORE_OWNER,
                'store_name' => 'Demo Starter Store',
                'plan_id' => 1
            ],
            [
                'key' => 'demo_pro',
                'name' => 'Demo Tienda Pro',
                'email' => 'demo.pro@kyros.com',
                'password' => 'DemoPro123!',
                'phone' => '+57 300 000 0003',
                'role' => ROLE_STORE_OWNER,
                'store_name' => 'Demo Pro Store',
                'plan_id' => 2
            ]
        ];
    }

    private static function ensureDemoUsers() {
        if (!self::isDemoAccountsEnabled()) {
            return [];
        }

        $accounts = self::getDemoAccountsConfig();

        $createdAccounts = [];
        $user = new User();

        foreach ($accounts as $account) {
            $existing = $user->findByEmail($account['email']);

            if (!$existing) {
                $newUser = new User();
                $newUser->name = $account['name'];
                $newUser->email = $account['email'];
                $newUser->password = $account['password'];
                $newUser->phone = $account['phone'];
                $newUser->role = $account['role'];
                $newUser->store_id = null;
                $newUser->is_active = true;
                $newUser->email_verified = true;
                $userId = $newUser->create();

                if (!$userId) {
                    continue;
                }

                $existing = $newUser->findById($userId);
            }

            if (!$existing) {
                continue;
            }

            if (($account['role'] ?? '') === ROLE_STORE_OWNER) {
                self::ensureDemoStoreAndLicense($existing, $account['store_name'], intval($account['plan_id']));
            }

            $createdAccounts[] = [
                'key' => $account['key'],
                'name' => $account['name'],
                'email' => $account['email'],
                'password' => $account['password'],
                'role' => $account['role']
            ];
        }

        return $createdAccounts;
    }

    private static function ensureDemoStoreAndLicense($userData, $storeName, $planId) {
        $store = new Store();
        $license = new License();
        $user = new User();

        $storeData = null;
        if (!empty($userData['store_id'])) {
            $storeData = $store->findById(intval($userData['store_id']));
        }

        if (!$storeData) {
            $stores = $store->findByOwnerId(intval($userData['id']));
            if (!empty($stores)) {
                $storeData = $stores[0];
                $user->assignStore(intval($userData['id']), intval($storeData['id']));
            }
        }

        if (!$storeData) {
            $newStore = new Store();
            $newStore->owner_id = intval($userData['id']);
            $newStore->name = $storeName;
            $newStore->slug = Helper::generateSlug($storeName) . '-' . substr(sha1($userData['email']), 0, 8);
            $newStore->description = 'Cuenta demo para pruebas de Kyros Commerce';
            $newStore->phone = $userData['phone'] ?? '';
            $newStore->email = $userData['email'];
            $newStore->plan_id = $planId;
            $newStore->is_active = true;

            $storeId = $newStore->create();
            if ($storeId) {
                $user->assignStore(intval($userData['id']), intval($storeId));
                $storeData = $newStore->findById(intval($storeId));
            }
        }

        if (!$storeData) {
            return;
        }

        $activeLicense = $license->findActiveByStoreId(intval($storeData['id']));
        if ($activeLicense) {
            return;
        }

        $newLicense = new License();
        $newLicense->plan_id = $planId;
        $newLicense->store_id = intval($storeData['id']);
        $newLicense->trial_days = 3650;
        $newLicense->is_trial = true;
        $newLicense->features = Helper::getLicensePlan($planId);

        $licenseId = $newLicense->create();
        if ($licenseId) {
            $store->assignLicense(intval($storeData['id']), intval($licenseId));
        }
    }
    
    public static function register() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            include VIEWS_PATH . 'auth/register.php';
            return;
        }

        $name = Helper::sanitizeInput($_POST['name'] ?? '');
        $email = Helper::sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        $phone = Helper::sanitizeInput($_POST['phone'] ?? '');
        $plan_id = intval($_POST['plan_id'] ?? 1);

        // Validaciones
        $errors = [];
        
        if (empty($name)) $errors['name'] = 'Nombre requerido';
        if (!Helper::validateEmail($email)) $errors['email'] = 'Email no válido';
        if (strlen($password) < 6) $errors['password'] = 'La contraseña debe tener al menos 6 caracteres';
        if ($password !== $password_confirm) $errors['password_confirm'] = 'Las contraseñas no coinciden';

        if (!in_array($plan_id, [1, 2, 3], true)) {
            $errors['plan_id'] = 'Plan no válido';
        }

        if (count($errors) > 0) {
            Helper::redirect(BASE_URL . 'auth/register?error=' . urlencode(implode(' | ', array_values($errors))));
        }

        // Verificar si el email ya existe
        $user = new User();
        if ($user->findByEmail($email)) {
            Helper::redirect(BASE_URL . 'auth/register?error=' . urlencode('Este email ya está registrado'));
        }

        // Crear usuario
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->phone = $phone;
        $user->role = ROLE_STORE_OWNER;
        $user->store_id = null;
        $user->is_active = TRUE;
        $user->email_verified = FALSE;

        $user_id = $user->create();
        if (!$user_id) {
            Helper::redirect(BASE_URL . 'auth/register?error=' . urlencode('Error al crear la cuenta'));
        }

        // Crear tienda
        $store = new Store();
        $store->owner_id = $user_id;
        $store->name = $name . "'s Store";
        $store->slug = Helper::generateSlug($store->name) . '-' . uniqid();
        $store->phone = $phone;
        $store->email = $email;
        $store->plan_id = $plan_id;
        $store->is_active = TRUE;

        $store_id = $store->create();
        if (!$store_id) {
            $user->id = $user_id;
            $user->delete();
            Helper::redirect(BASE_URL . 'auth/register?error=' . urlencode('No se pudo crear la tienda'));
        }

        $user->assignStore($user_id, $store_id);

        // Crear licencia de prueba
        $license = new License();
        $license->plan_id = $plan_id;
        $license->store_id = $store_id;
        $license->trial_days = 15;
        $license->is_trial = TRUE;
        $license->features = Helper::getLicensePlan($plan_id);
        $license_id = $license->create();

        if (!$license_id) {
            $store->deleteById($store_id);
            $user->id = $user_id;
            $user->delete();
            Helper::redirect(BASE_URL . 'auth/register?error=' . urlencode('No se pudo crear la licencia de prueba'));
        }

        $store->assignLicense($store_id, $license_id);

        Helper::redirect(BASE_URL . 'auth/login?success=' . urlencode('Cuenta creada exitosamente. Ya puedes iniciar sesión.'));
    }

    public static function login() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $demoAccounts = self::ensureDemoUsers();
            $showDemoPasswords = self::isDemoPasswordsVisible();
            $showDemoBlock = self::isDemoBlockVisible();
            include VIEWS_PATH . 'auth/login.php';
            return;
        }

        $email = Helper::sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $demoLoginKey = Helper::sanitizeInput($_POST['demo_login_key'] ?? '');

        if (self::isDemoAccountsEnabled() && $demoLoginKey !== '') {
            foreach (self::getDemoAccountsConfig() as $account) {
                if ($account['key'] === $demoLoginKey) {
                    $email = $account['email'];
                    $password = $account['password'];
                    break;
                }
            }
        }

        $errors = [];
        
        if (!$email) $errors['email'] = 'Email requerido';
        if (!$password) $errors['password'] = 'Contraseña requerida';

        if (count($errors) > 0) {
            Helper::redirect(BASE_URL . 'auth/login?error=' . urlencode(implode(' | ', array_values($errors))));
        }

        $loginResult = Auth::login($email, $password);

        if ($loginResult === true) {
            if (Auth::isSuperAdmin()) {
                Helper::redirect(BASE_URL . 'superadmin/dashboard');
            } elseif (Auth::isStoreOwner()) {
                Helper::redirect(BASE_URL . 'admin/dashboard');
            }
        } elseif ($loginResult === 'user_inactive') {
            Helper::redirect(BASE_URL . 'auth/cuenta-inactiva?tipo=usuario');
        } elseif ($loginResult === 'store_inactive') {
            Helper::redirect(BASE_URL . 'auth/cuenta-inactiva?tipo=tienda');
        }

        Helper::redirect(BASE_URL . 'auth/login?error=' . urlencode('Email o contraseña incorrectos'));
    }

    public static function logout() {
        Auth::logout();
        Helper::redirect(BASE_URL);
    }

    public static function inactiveAccount() {
        $tipo = Helper::sanitizeInput($_GET['tipo'] ?? 'usuario');
        include VIEWS_PATH . 'auth/inactive-account.php';
    }

    public static function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            include VIEWS_PATH . 'auth/forgot-password.php';
            return;
        }

        $email = Helper::sanitizeInput($_POST['email'] ?? '');

        if (!$email || !Helper::validateEmail($email)) {
            Helper::redirect(BASE_URL . 'auth/forgot-password?error=' . urlencode('Ingresa un email valido'));
        }

        // Por seguridad, respondemos con el mismo mensaje exista o no la cuenta.
        Helper::redirect(BASE_URL . 'auth/forgot-password?success=' . urlencode('Si el email existe, te enviaremos instrucciones para recuperar tu acceso.'));
    }
}
