<?php

require_once __DIR__ . '/../config/Config.php';
require_once __DIR__ . '/../models/Store.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Setting.php';
require_once __DIR__ . '/../models/CustomerAddress.php';
require_once __DIR__ . '/../helpers/Helper.php';
require_once __DIR__ . '/../middleware/Auth.php';

class CustomerController {

    private static function resolveStoreTheme($storeData) {
        $defaultMenu = [
            ['label' => 'Inicio', 'url' => BASE_URL . 'shop/' . ($storeData['slug'] ?? '')],
            ['label' => 'Productos', 'url' => BASE_URL . 'shop/' . ($storeData['slug'] ?? '')],
            ['label' => 'Carrito', 'url' => BASE_URL . 'shop/' . ($storeData['slug'] ?? '') . '/cart']
        ];

        $defaultFooter = [
            'text' => 'Gracias por comprar en nuestra tienda.',
            'contact_email' => $storeData['email'] ?? '',
            'contact_phone' => $storeData['phone'] ?? '',
            'terms_url' => BASE_URL . 'terms',
            'privacy_url' => BASE_URL . 'privacy',
            'facebook' => '',
            'instagram' => '',
            'tiktok' => ''
        ];

        if (empty($storeData['id'])) {
            return ['menu' => $defaultMenu, 'footer' => $defaultFooter];
        }

        $setting = new Setting();
        $theme = $setting->getStoreTheme(intval($storeData['id']));

        $menu = $theme['menu'] ?? [];
        if (!is_array($menu) || count($menu) === 0) {
            $menu = $defaultMenu;
        }

        $footer = array_merge($defaultFooter, is_array($theme['footer'] ?? null) ? $theme['footer'] : []);
        return ['menu' => $menu, 'footer' => $footer];
    }

    private static function getStoreBySlugOrFail($storeSlug) {
        $store = new Store();
        $storeData = $store->findBySlug($storeSlug);

        if (!$storeData || empty($storeData['is_active'])) {
            http_response_code(404);
            echo 'Tienda no encontrada';
            exit;
        }

        return $storeData;
    }

    private static function getCurrentCustomerStoreOrRedirect() {
        Auth::requireCustomer();

        $storeId = intval(Auth::getCustomerStoreId() ?? 0);
        if ($storeId <= 0) {
            Auth::logoutCustomer();
            Helper::redirect(BASE_URL);
        }

        $storeModel = new Store();
        $storeData = $storeModel->findById($storeId);
        if (!$storeData || empty($storeData['is_active'])) {
            Auth::logoutCustomer();
            Helper::redirect(BASE_URL);
        }

        return $storeData;
    }

    public static function register($storeSlug) {
        $storeData = self::getStoreBySlugOrFail($storeSlug);
        $storeTheme = self::resolveStoreTheme($storeData);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include VIEWS_PATH . 'public/customer-register.php';
            return;
        }

        $name = Helper::sanitizeInput($_POST['name'] ?? '');
        $email = Helper::sanitizeInput($_POST['email'] ?? '');
        $phone = Helper::sanitizeInput($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        $errors = [];
        if ($name === '') $errors[] = 'Nombre requerido';
        if (!Helper::validateEmail($email)) $errors[] = 'Email no valido';
        if (strlen($password) < 6) $errors[] = 'La contraseña debe tener al menos 6 caracteres';
        if ($password !== $passwordConfirm) $errors[] = 'Las contraseñas no coinciden';

        $user = new User();
        $existingGlobal = $user->findByEmail($email);
        if ($existingGlobal && ($existingGlobal['role'] ?? '') !== ROLE_CUSTOMER) {
            $errors[] = 'Este email ya pertenece a otra cuenta dentro de la plataforma';
        }

        if ($existingGlobal && ($existingGlobal['role'] ?? '') === ROLE_CUSTOMER && intval($existingGlobal['store_id'] ?? 0) !== intval($storeData['id'])) {
            $errors[] = 'Este email ya está registrado en otra tienda';
        }

        if ($user->customerEmailExistsInStore($email, intval($storeData['id']))) {
            $errors[] = 'Ya existe una cuenta de cliente con este email en esta tienda';
        }

        if (!empty($errors)) {
            Helper::redirect(BASE_URL . 'shop/' . $storeSlug . '/customer/register?error=' . urlencode(implode(' | ', $errors)));
        }

        $customer = new User();
        $customer->name = $name;
        $customer->email = $email;
        $customer->password = $password;
        $customer->phone = $phone;
        $customer->role = ROLE_CUSTOMER;
        $customer->store_id = intval($storeData['id']);
        $customer->is_active = 1;
        $customer->email_verified = 1;

        $customerId = $customer->create();
        if (!$customerId) {
            Helper::redirect(BASE_URL . 'shop/' . $storeSlug . '/customer/register?error=' . urlencode('No se pudo crear la cuenta'));
        }

        $customerData = $customer->findById(intval($customerId));
        Auth::loginCustomer($customerData);

        Helper::redirect(BASE_URL . 'customer/panel?success=' . urlencode('Bienvenido a tu panel de cliente'));
    }

    public static function login($storeSlug) {
        $storeData = self::getStoreBySlugOrFail($storeSlug);
        $storeTheme = self::resolveStoreTheme($storeData);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include VIEWS_PATH . 'public/customer-login.php';
            return;
        }

        $email = Helper::sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            Helper::redirect(BASE_URL . 'shop/' . $storeSlug . '/customer/login?error=' . urlencode('Email y contraseña son obligatorios'));
        }

        $user = new User();
        $customerData = $user->findCustomerByEmailAndStore($email, intval($storeData['id']));

        if (!$customerData || !$user->verifyPassword($password, $customerData['password'])) {
            Helper::redirect(BASE_URL . 'shop/' . $storeSlug . '/customer/login?error=' . urlencode('Credenciales incorrectas'));
        }

        $loginResult = Auth::loginCustomer($customerData);
        if ($loginResult === 'user_inactive') {
            Helper::redirect(BASE_URL . 'shop/' . $storeSlug . '/customer/login?error=' . urlencode('Tu cuenta está inactiva'));
        }

        if ($loginResult !== true) {
            Helper::redirect(BASE_URL . 'shop/' . $storeSlug . '/customer/login?error=' . urlencode('No se pudo iniciar sesión'));
        }

        Helper::redirect(BASE_URL . 'customer/panel');
    }

    public static function logout() {
        $storeSlug = '';
        if (Auth::isCustomerLoggedIn()) {
            $storeModel = new Store();
            $store = $storeModel->findById(intval(Auth::getCustomerStoreId()));
            $storeSlug = $store['slug'] ?? '';
        }

        Auth::logoutCustomer();

        if ($storeSlug !== '') {
            Helper::redirect(BASE_URL . 'shop/' . $storeSlug . '/customer/login?success=' . urlencode('Sesión cerrada'));
        }

        Helper::redirect(BASE_URL);
    }

    public static function dashboard() {
        $storeData = self::getCurrentCustomerStoreOrRedirect();
        $storeTheme = self::resolveStoreTheme($storeData);
        $customer = Auth::getCurrentCustomer();

        $orderModel = new Order();
        $customerId = intval(Auth::getCustomerId());
        $storeId = intval($storeData['id']);

        $orders = $orderModel->getByCustomer($storeId, $customerId, 10, 0);
        $totalOrders = $orderModel->countByCustomer($storeId, $customerId);

        include VIEWS_PATH . 'public/customer-dashboard.php';
    }

    public static function profile() {
        $storeData = self::getCurrentCustomerStoreOrRedirect();
        $storeTheme = self::resolveStoreTheme($storeData);
        $customer = Auth::getCurrentCustomer();

        if (!$customer) {
            Auth::logoutCustomer();
            Helper::redirect(BASE_URL);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = Helper::sanitizeInput($_POST['name'] ?? '');
            $email = Helper::sanitizeInput($_POST['email'] ?? '');
            $phone = Helper::sanitizeInput($_POST['phone'] ?? '');
            $newPassword = $_POST['new_password'] ?? '';

            $errors = [];
            if ($name === '') $errors[] = 'Nombre requerido';
            if (!Helper::validateEmail($email)) $errors[] = 'Email no valido';

            $user = new User();
            if ($user->customerEmailExistsInStore($email, intval($storeData['id']), intval($customer['id']))) {
                $errors[] = 'Ese email ya está en uso por otro cliente de esta tienda';
            }

            if ($newPassword !== '' && strlen($newPassword) < 6) {
                $errors[] = 'La nueva contraseña debe tener al menos 6 caracteres';
            }

            if (!empty($errors)) {
                Helper::redirect(BASE_URL . 'customer/profile?error=' . urlencode(implode(' | ', $errors)));
            }

            $user->updateCustomerProfile(intval($customer['id']), intval($storeData['id']), $name, $email, $phone);
            if ($newPassword !== '') {
                $user->updatePassword(intval($customer['id']), $newPassword);
            }

            $freshCustomer = $user->findById(intval($customer['id']));
            Auth::loginCustomer($freshCustomer);

            Helper::redirect(BASE_URL . 'customer/profile?success=' . urlencode('Perfil actualizado correctamente'));
        }

        include VIEWS_PATH . 'public/customer-profile.php';
    }

    public static function addresses() {
        $storeData = self::getCurrentCustomerStoreOrRedirect();
        $storeTheme = self::resolveStoreTheme($storeData);
        $customer = Auth::getCurrentCustomer();

        if (!$customer) {
            Auth::logoutCustomer();
            Helper::redirect(BASE_URL);
        }

        $customerId = intval($customer['id']);
        $storeId = intval($storeData['id']);
        $addressModel = new CustomerAddress();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = Helper::sanitizeInput($_POST['action'] ?? 'create');
            $addressId = intval($_POST['address_id'] ?? 0);

            if ($action === 'delete' && $addressId > 0) {
                $addressModel->delete($addressId, $customerId, $storeId);
                Helper::redirect(BASE_URL . 'customer/addresses?success=' . urlencode('Dirección eliminada'));
            }

            $label = Helper::sanitizeInput($_POST['label'] ?? 'Principal');
            $recipientName = Helper::sanitizeInput($_POST['recipient_name'] ?? '');
            $phone = Helper::sanitizeInput($_POST['phone'] ?? '');
            $addressLine = Helper::sanitizeInput($_POST['address_line'] ?? '');
            $city = Helper::sanitizeInput($_POST['city'] ?? '');
            $state = Helper::sanitizeInput($_POST['state'] ?? '');
            $country = Helper::sanitizeInput($_POST['country'] ?? '');
            $postalCode = Helper::sanitizeInput($_POST['postal_code'] ?? '');
            $isDefault = isset($_POST['is_default']) && $_POST['is_default'] == '1';

            $errors = [];
            if ($recipientName === '') $errors[] = 'Nombre del destinatario requerido';
            if ($addressLine === '') $errors[] = 'Dirección requerida';

            if (!empty($errors)) {
                Helper::redirect(BASE_URL . 'customer/addresses?error=' . urlencode(implode(' | ', $errors)));
            }

            if ($action === 'edit' && $addressId > 0) {
                $addressModel->update($addressId, $customerId, $storeId, $label, $recipientName, $phone, $addressLine, $city, $state, $country, $postalCode, $isDefault);
                Helper::redirect(BASE_URL . 'customer/addresses?success=' . urlencode('Dirección actualizada'));
            }

            $addressModel->create($customerId, $storeId, $label, $recipientName, $phone, $addressLine, $city, $state, $country, $postalCode, $isDefault);
            Helper::redirect(BASE_URL . 'customer/addresses?success=' . urlencode('Dirección agregada'));
        }

        $addresses = $addressModel->getByCustomer($customerId, $storeId);

        include VIEWS_PATH . 'public/customer-addresses.php';
    }

    public static function orderDetail($orderId) {
        $storeData = self::getCurrentCustomerStoreOrRedirect();
        $storeTheme = self::resolveStoreTheme($storeData);

        $customerId = intval(Auth::getCustomerId());
        $storeId = intval($storeData['id']);

        $orderModel = new Order();
        $orderData = $orderModel->findByIdForCustomer(intval($orderId), $storeId, $customerId);

        if (!$orderData) {
            Helper::redirect(BASE_URL . 'customer/panel?error=' . urlencode('Orden no encontrada'));
        }

        $orderItems = $orderModel->getOrderItems(intval($orderData['id']));

        include VIEWS_PATH . 'public/customer-order-detail.php';
    }
}
