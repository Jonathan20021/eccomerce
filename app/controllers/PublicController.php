<?php

require_once __DIR__ . '/../config/Config.php';
require_once __DIR__ . '/../models/Store.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Setting.php';
require_once __DIR__ . '/../helpers/Helper.php';
require_once __DIR__ . '/../helpers/NotificationService.php';
require_once __DIR__ . '/../middleware/Auth.php';

class PublicController {

    private static function getStaticPages() {
        return [
            'terms' => [
                'title' => 'Terminos y Condiciones',
                'subtitle' => 'Condiciones de uso de la plataforma Kyros Commerce.',
                'updated_at' => '2026-04-09',
                'sections' => [
                    ['title' => 'Aceptacion de terminos', 'content' => 'Al usar Kyros Commerce aceptas estas condiciones. Si no estas de acuerdo, debes dejar de usar la plataforma.'],
                    ['title' => 'Uso permitido', 'content' => 'Puedes usar la plataforma para crear y gestionar tiendas legales. No esta permitido usarla para fraude, suplantacion, malware o actividades ilicitas.'],
                    ['title' => 'Cuentas y seguridad', 'content' => 'Eres responsable de proteger tus credenciales y de toda actividad realizada desde tu cuenta.'],
                    ['title' => 'Pagos y planes', 'content' => 'Los planes pagos se facturan segun la modalidad vigente. Puedes cambiar o cancelar segun tu plan y condiciones comerciales.'],
                    ['title' => 'Suspension y terminacion', 'content' => 'Kyros Commerce puede limitar o suspender cuentas que incumplan estos terminos o representen riesgo para la plataforma.']
                ]
            ],
            'privacy' => [
                'title' => 'Politica de Privacidad',
                'subtitle' => 'Como recopilamos, usamos y protegemos tus datos.',
                'updated_at' => '2026-04-09',
                'sections' => [
                    ['title' => 'Datos que recopilamos', 'content' => 'Recopilamos informacion de registro, configuracion de tienda, uso de plataforma y datos tecnicos basicos para operar el servicio.'],
                    ['title' => 'Uso de datos', 'content' => 'Usamos tus datos para autenticar acceso, prestar funciones del producto, soporte, seguridad y mejoras del servicio.'],
                    ['title' => 'Comparticion', 'content' => 'No vendemos tus datos personales. Compartimos solo lo necesario con proveedores de infraestructura y cumplimiento legal cuando aplique.'],
                    ['title' => 'Retencion', 'content' => 'Conservamos informacion mientras tu cuenta este activa o exista una necesidad operativa y legal razonable.'],
                    ['title' => 'Tus derechos', 'content' => 'Puedes solicitar acceso, correccion o eliminacion de tus datos contactandonos por los canales oficiales de soporte.']
                ]
            ],
            'cookies' => [
                'title' => 'Politica de Cookies',
                'subtitle' => 'Uso de cookies para funcionamiento y analitica basica.',
                'updated_at' => '2026-04-09',
                'sections' => [
                    ['title' => 'Que son las cookies', 'content' => 'Son archivos pequenos que ayudan a recordar sesion, preferencias y estado de navegacion.'],
                    ['title' => 'Tipos usadas', 'content' => 'Usamos cookies esenciales para autenticacion y seguridad. Tambien podemos usar cookies de analitica agregada.'],
                    ['title' => 'Control', 'content' => 'Puedes gestionar cookies desde tu navegador, aunque desactivarlas puede afectar funciones clave de la plataforma.']
                ]
            ],
            'security' => [
                'title' => 'Seguridad',
                'subtitle' => 'Buenas practicas y medidas de proteccion de Kyros Commerce.',
                'updated_at' => '2026-04-09',
                'sections' => [
                    ['title' => 'Proteccion de cuentas', 'content' => 'Recomendamos contrasenas robustas, rotacion periodica y no compartir accesos entre usuarios.'],
                    ['title' => 'Controles de aplicacion', 'content' => 'Aplicamos validaciones de acceso por rol, control de licencias y saneamiento de entrada en formularios clave.'],
                    ['title' => 'Reportes', 'content' => 'Si detectas una vulnerabilidad, reportala por el canal de contacto para atencion prioritaria.']
                ]
            ],
            'api-docs' => [
                'title' => 'API de Kyros Commerce',
                'subtitle' => 'Informacion general sobre endpoints y uso de integraciones.',
                'updated_at' => '2026-04-09',
                'sections' => [
                    ['title' => 'Acceso', 'content' => 'Algunos endpoints requieren sesion de administrador o superadmin y aplican control de tasa.'],
                    ['title' => 'Endpoints base', 'content' => 'Incluye operaciones de licencias, busqueda global y estadisticas de plataforma/tienda.'],
                    ['title' => 'Referencia completa', 'content' => 'Consulta la documentacion tecnica de la app para ejemplos de request y response.']
                ]
            ],
            'about' => [
                'title' => 'Acerca de Kyros Commerce',
                'subtitle' => 'Construimos tecnologia simple para que emprender online sea posible para todos.',
                'updated_at' => '2026-04-09',
                'sections' => [
                    ['title' => 'Mision', 'content' => 'Ayudar a emprendedores y negocios a lanzar su tienda digital sin friccion tecnica.'],
                    ['title' => 'Vision', 'content' => 'Ser la plataforma ecommerce mas accesible de habla hispana para PYMES y creadores.'],
                    ['title' => 'Valores', 'content' => 'Simplicidad, velocidad de ejecucion, soporte humano y mejora continua.']
                ]
            ],
            'blog' => [
                'title' => 'Blog',
                'subtitle' => 'Recursos y contenido para crecer tu tienda online.',
                'updated_at' => '2026-04-09',
                'sections' => [
                    ['title' => 'Contenido proximo', 'content' => 'Estamos preparando guias practicas sobre catalogo, conversion, atencion por WhatsApp y analitica.'],
                    ['title' => 'Sugerencias', 'content' => 'Puedes proponer temas desde nuestra pagina de contacto para priorizar nuevo contenido.']
                ]
            ],
            'contact' => [
                'title' => 'Contacto',
                'subtitle' => 'Estamos listos para ayudarte con ventas, soporte o alianzas.',
                'updated_at' => '2026-04-09',
                'sections' => [
                    ['title' => 'Soporte', 'content' => 'Escribenos a soporte@kyroscommerce.com para incidencias tecnicas y ayuda de uso.'],
                    ['title' => 'Comercial', 'content' => 'Para planes enterprise y acuerdos, escribe a ventas@kyroscommerce.com.'],
                    ['title' => 'Horario', 'content' => 'Atencion de lunes a viernes de 8:00 a 18:00 (UTC-5).']
                ]
            ],
            'jobs' => [
                'title' => 'Empleos',
                'subtitle' => 'Unete al equipo que esta construyendo el futuro del comercio digital.',
                'updated_at' => '2026-04-09',
                'sections' => [
                    ['title' => 'Talento abierto', 'content' => 'Buscamos perfiles en producto, ingenieria, soporte y growth.'],
                    ['title' => 'Como aplicar', 'content' => 'Envia tu CV y portafolio a talento@kyroscommerce.com con el rol de interes.']
                ]
            ]
        ];
    }

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
    
    public static function storeFront($store_slug) {
        $store = new Store();
        $storeData = $store->findBySlug($store_slug);

        if (!$storeData || !$storeData['is_active']) {
            http_response_code(404);
            echo "Tienda no encontrada";
            exit;
        }

        $page = intval($_GET['page'] ?? 1);
        $limit = 12;
        $offset = ($page - 1) * $limit;
        $selectedCategoryId = intval($_GET['category'] ?? 0);
        $searchQuery = Helper::sanitizeInput($_GET['q'] ?? '');

        $categoryModel = new Category();
        $categories = $categoryModel->getByStore(intval($storeData['id']), true);

        $validCategoryIds = array_map(function ($item) {
            return intval($item['id'] ?? 0);
        }, $categories);
        if ($selectedCategoryId > 0 && !in_array($selectedCategoryId, $validCategoryIds, true)) {
            $selectedCategoryId = 0;
        }

        $product = new Product();
        $filters = [
            'category_id' => $selectedCategoryId,
            'q' => $searchQuery
        ];
        $products = $product->getByStoreFiltered($storeData['id'], $filters, $limit, $offset);
        $totalProducts = $product->countByStoreFiltered($storeData['id'], $filters);
        $totalPages = ceil($totalProducts / $limit);

        $cart = new Cart();
        $cartItems = $cart->getCart(Auth::getUserId());
        $cartCount = count($cartItems);
        $storeTheme = self::resolveStoreTheme($storeData);

        include VIEWS_PATH . 'public/storefront.php';
    }

    public static function productDetail($store_slug, $product_slug) {
        $store = new Store();
        $storeData = $store->findBySlug($store_slug);

        if (!$storeData) {
            http_response_code(404);
            echo "Tienda no encontrada";
            exit;
        }

        $product = new Product();
        $productData = $product->findBySlugAndStore($product_slug, intval($storeData['id']));

        if (!$productData && intval($_GET['id'] ?? 0) > 0) {
            $productData = $product->findById(intval($_GET['id'] ?? 0));
        }

        if (!$productData || $productData['store_id'] != $storeData['id'] || !$productData['is_active']) {
            http_response_code(404);
            echo "Producto no encontrado";
            exit;
        }

        $cart = new Cart();
        $cartItems = $cart->getCart(Auth::getUserId());
        $cartCount = count($cartItems);
        $storeTheme = self::resolveStoreTheme($storeData);

        include VIEWS_PATH . 'public/product.php';
    }

    public static function cart($store_slug = null) {
        $storeData = null;

        $store = new Store();
        if (!empty($store_slug)) {
            $storeData = $store->findBySlug($store_slug);
        }

        $cart = new Cart();
        $cartItems = $cart->getCart(Auth::getUserId());
        $cartTotal = $cart->getCartTotal(Auth::getUserId());

        if (!$storeData && !empty($cartItems) && !empty($cartItems[0]['store_id'])) {
            $storeData = $store->findById(intval($cartItems[0]['store_id']));
        }

        if (!$storeData) {
            $storeData = ['id' => 0, 'name' => 'Mi Tienda', 'slug' => '', 'email' => '', 'phone' => ''];
        }

        $storeTheme = self::resolveStoreTheme($storeData);

        include VIEWS_PATH . 'public/cart.php';
    }

    public static function addToCart() {
        $product_id = intval($_POST['product_id'] ?? 0);
        $quantity = intval($_POST['quantity'] ?? 1);
        $store_id = intval($_POST['store_id'] ?? 0);

        if (!$product_id || !$store_id) {
            Helper::json(['success' => false, 'message' => 'Datos inválidos']);
        }

        $cart = new Cart();
        if ($cart->addItem($product_id, $quantity, $store_id, Auth::getUserId())) {
            $cartCount = $cart->getCartCount(Auth::getUserId());
            Helper::json(['success' => true, 'message' => 'Producto añadido al carrito', 'cartCount' => $cartCount]);
        }

        Helper::json(['success' => false, 'message' => 'Error al añadir al carrito'], 500);
    }

    public static function updateCartItem() {
        $cart_item_id = intval($_POST['cart_item_id'] ?? 0);
        $quantity = intval($_POST['quantity'] ?? 1);

        if (!$cart_item_id) {
            Helper::json(['success' => false, 'message' => 'Datos inválidos']);
        }

        $cart = new Cart();
        if ($cart->updateQuantity($cart_item_id, $quantity)) {
            $cartTotal = $cart->getCartTotal(Auth::getUserId());
            Helper::json(['success' => true, 'cartTotal' => $cartTotal]);
        }

        Helper::json(['success' => false, 'message' => 'Error al actualizar'], 500);
    }

    public static function removeFromCart() {
        $cart_item_id = intval($_POST['cart_item_id'] ?? 0);

        if (!$cart_item_id) {
            Helper::json(['success' => false, 'message' => 'Datos inválidos']);
        }

        $cart = new Cart();
        if ($cart->removeItem($cart_item_id)) {
            Helper::json(['success' => true, 'message' => 'Producto removido']);
        }

        Helper::json(['success' => false, 'message' => 'Error al remover'], 500);
    }

    public static function checkout() {
        $store_id = intval($_GET['store_id'] ?? 0);

        // Try to recover store context from cart when store_id is missing.
        if (!$store_id) {
            $cart = new Cart();
            $cartItemsFallback = $cart->getCart(Auth::getUserId());
            if (!empty($cartItemsFallback) && !empty($cartItemsFallback[0]['store_id'])) {
                $store_id = intval($cartItemsFallback[0]['store_id']);
                Helper::redirect(BASE_URL . 'checkout?store_id=' . $store_id);
            }

            Helper::redirect(BASE_URL);
        }

        $store = new Store();
        $storeData = $store->findById($store_id);
        if (!$storeData || !$storeData['is_active']) {
            Helper::redirect(BASE_URL);
        }

        $cart = new Cart();
        $cartItems = $cart->getCart(Auth::getUserId());
        $isSuccessView = isset($_GET['success']) && trim((string)$_GET['success']) !== '';

        if (empty($cartItems) && !$isSuccessView) {
            Helper::redirect(BASE_URL . 'shop/' . $storeData['slug'] . '/cart?error=' . urlencode('Tu carrito está vacío'));
        }

        $cartTotal = $cart->getCartTotal(Auth::getUserId());
        $storeTheme = self::resolveStoreTheme($storeData);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = Helper::sanitizeInput($_POST['name'] ?? '');
            $email = Helper::sanitizeInput($_POST['email'] ?? '');
            $phone = Helper::sanitizeInput($_POST['phone'] ?? '');
            $address = Helper::sanitizeInput($_POST['address'] ?? '');

            $errors = [];
            
            if (!$name) $errors['name'] = 'Nombre requerido';
            if (!$email) $errors['email'] = 'Email requerido';
            if (!$phone) $errors['phone'] = 'Teléfono requerido';
            if (!$address) $errors['address'] = 'Dirección requerida';

            if (count($errors) > 0) {
                Helper::redirect(BASE_URL . 'checkout?store_id=' . $store_id . '&error=' . urlencode(implode(' | ', array_values($errors))));
            }

            $order = new Order();
            $order->user_id = Auth::getUserId();
            $order->store_id = $store_id;
            $order->customer_name = $name;
            $order->customer_email = $email;
            $order->customer_phone = $phone;
            $order->shipping_address = $address;
            $order->subtotal = $cartTotal;
            $order->total = $cartTotal;
            $order->payment_method = 'whatsapp';
            $order->tax = 0;
            $order->shipping_cost = 0;
            $order->discount = 0;

            $order_id = $order->create();

            if ($order_id) {
                // Agregar items a la orden
                foreach ($cartItems as $item) {
                    $discountPrice = isset($item['discount_price']) ? floatval($item['discount_price']) : 0;
                    $effectivePrice = $discountPrice > 0 ? $discountPrice : floatval($item['price']);
                    $order->addOrderItem($order_id, $item['product_id'], $item['quantity'], $effectivePrice);
                }

                // Limpiar carrito
                $cart->clearCart(Auth::getUserId());

                // Notificacion no bloqueante para nueva orden.
                NotificationService::notifyNewOrder(
                    $order->order_number,
                    $storeData['name'] ?? 'Tienda',
                    $name,
                    $email,
                    Helper::formatPrice($cartTotal)
                );

                if (!empty($storeData['whatsapp_number'])) {
                    $whatsappLink = Helper::getWhatsAppLink($storeData['whatsapp_number'], 
                        "Hola, he realizado un pedido con número: " . $order->order_number);
                    Helper::redirect($whatsappLink);
                }

                Helper::redirect(
                    BASE_URL . 'checkout?store_id=' . $store_id . '&success=' . urlencode('Orden creada exitosamente. Número: ' . $order->order_number)
                );
            }

            Helper::redirect(BASE_URL . 'checkout?store_id=' . $store_id . '&error=' . urlencode('No se pudo crear la orden'));
        }

        include VIEWS_PATH . 'public/checkout.php';
    }

    public static function home() {
        $store = new Store();
        $featuredStores = $store->getAll(6, 0);

        include VIEWS_PATH . 'public/home.php';
    }

    public static function page($slug) {
        $pages = self::getStaticPages();
        $pageData = $pages[$slug] ?? null;

        if (!$pageData) {
            http_response_code(404);
            echo 'Pagina no encontrada';
            exit;
        }

        $page_title = $pageData['title'];
        include VIEWS_PATH . 'public/page.php';
    }
}
