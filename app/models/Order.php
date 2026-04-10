<?php

require_once __DIR__ . '/../config/Database.php';

class Order {
    private $db;
    private $table = 'orders';

    public $id;
    public $user_id;
    public $store_id;
    public $order_number;
    public $status;
    public $total;
    public $subtotal;
    public $tax;
    public $shipping_cost;
    public $discount;
    public $customer_name;
    public $customer_email;
    public $customer_phone;
    public $shipping_address;
    public $payment_method;
    public $payment_status;
    public $notes;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function create() {
        $this->order_number = $this->generateOrderNumber();

        $query = "INSERT INTO " . $this->table . " 
                  (user_id, store_id, order_number, status, total, subtotal, tax, shipping_cost, 
                   discount, customer_name, customer_email, customer_phone, shipping_address, 
                   payment_method, payment_status) 
                  VALUES 
                  (:user_id, :store_id, :order_number, :status, :total, :subtotal, :tax, :shipping_cost, 
                   :discount, :customer_name, :customer_email, :customer_phone, :shipping_address, 
                   :payment_method, :payment_status)";

        $stmt = $this->db->prepare($query);

        $status = 'pending';
        $payment_status = 'pending';

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':store_id', $this->store_id);
        $stmt->bindParam(':order_number', $this->order_number);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':total', $this->total);
        $stmt->bindParam(':subtotal', $this->subtotal);
        $stmt->bindParam(':tax', $this->tax);
        $stmt->bindParam(':shipping_cost', $this->shipping_cost);
        $stmt->bindParam(':discount', $this->discount);
        $stmt->bindParam(':customer_name', $this->customer_name);
        $stmt->bindParam(':customer_email', $this->customer_email);
        $stmt->bindParam(':customer_phone', $this->customer_phone);
        $stmt->bindParam(':shipping_address', $this->shipping_address);
        $stmt->bindParam(':payment_method', $this->payment_method);
        $stmt->bindParam(':payment_status', $payment_status);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function createPosSale($store_id, $saleData, $items) {
        if (empty($items)) {
            throw new Exception('Debes agregar al menos un producto a la venta');
        }

        $this->db->beginTransaction();

        try {
            $preparedItems = [];
            $subtotal = 0.0;

            foreach ($items as $item) {
                $productId = intval($item['product_id'] ?? 0);
                $quantity = intval($item['quantity'] ?? 0);

                if ($productId <= 0 || $quantity <= 0) {
                    throw new Exception('Datos de producto inválidos en la venta');
                }

                $queryProduct = "SELECT id, name, price, discount_price, stock
                                 FROM products
                                 WHERE id = :id AND store_id = :store_id AND is_active = 1
                                 LIMIT 1 FOR UPDATE";
                $stmtProduct = $this->db->prepare($queryProduct);
                $stmtProduct->bindValue(':id', $productId, PDO::PARAM_INT);
                $stmtProduct->bindValue(':store_id', intval($store_id), PDO::PARAM_INT);
                $stmtProduct->execute();
                $product = $stmtProduct->fetch(PDO::FETCH_ASSOC);

                if (!$product) {
                    throw new Exception('Uno de los productos ya no existe o no está disponible');
                }

                $currentStock = intval($product['stock'] ?? 0);
                if ($currentStock < $quantity) {
                    throw new Exception('Stock insuficiente para "' . ($product['name'] ?? 'producto') . '"');
                }

                $discountPrice = floatval($product['discount_price'] ?? 0);
                $unitPrice = $discountPrice > 0 ? $discountPrice : floatval($product['price'] ?? 0);
                $lineSubtotal = $unitPrice * $quantity;
                $subtotal += $lineSubtotal;

                $preparedItems[] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $unitPrice,
                    'subtotal' => $lineSubtotal,
                    'new_stock' => $currentStock - $quantity
                ];
            }

            $tax = max(0, floatval($saleData['tax'] ?? 0));
            $shipping = max(0, floatval($saleData['shipping_cost'] ?? 0));
            $discount = max(0, floatval($saleData['discount'] ?? 0));
            $total = max(0, ($subtotal + $tax + $shipping) - $discount);

            $orderNumber = $this->generateOrderNumber();
            $status = strval($saleData['status'] ?? 'delivered');
            $paymentStatus = strval($saleData['payment_status'] ?? 'paid');
            $paymentMethod = strval($saleData['payment_method'] ?? 'cash');

            $queryOrder = "INSERT INTO " . $this->table . "
                           (user_id, store_id, order_number, status, total, subtotal, tax, shipping_cost,
                            discount, customer_name, customer_email, customer_phone, shipping_address,
                            payment_method, payment_status, notes)
                           VALUES
                           (:user_id, :store_id, :order_number, :status, :total, :subtotal, :tax, :shipping_cost,
                            :discount, :customer_name, :customer_email, :customer_phone, :shipping_address,
                            :payment_method, :payment_status, :notes)";

            $stmtOrder = $this->db->prepare($queryOrder);
            $stmtOrder->bindValue(':user_id', !empty($saleData['user_id']) ? intval($saleData['user_id']) : null, PDO::PARAM_INT);
            $stmtOrder->bindValue(':store_id', intval($store_id), PDO::PARAM_INT);
            $stmtOrder->bindValue(':order_number', $orderNumber);
            $stmtOrder->bindValue(':status', $status);
            $stmtOrder->bindValue(':total', $total);
            $stmtOrder->bindValue(':subtotal', $subtotal);
            $stmtOrder->bindValue(':tax', $tax);
            $stmtOrder->bindValue(':shipping_cost', $shipping);
            $stmtOrder->bindValue(':discount', $discount);
            $stmtOrder->bindValue(':customer_name', strval($saleData['customer_name'] ?? 'Cliente POS'));
            $stmtOrder->bindValue(':customer_email', strval($saleData['customer_email'] ?? ''));
            $stmtOrder->bindValue(':customer_phone', strval($saleData['customer_phone'] ?? ''));
            $stmtOrder->bindValue(':shipping_address', strval($saleData['shipping_address'] ?? 'Venta en tienda'));
            $stmtOrder->bindValue(':payment_method', $paymentMethod);
            $stmtOrder->bindValue(':payment_status', $paymentStatus);
            $rawNotes = trim(strval($saleData['notes'] ?? 'Venta POS'));
            if (stripos($rawNotes, 'POS:') !== 0) {
                $rawNotes = 'POS: ' . $rawNotes;
            }
            $stmtOrder->bindValue(':notes', $rawNotes);
            $stmtOrder->execute();

            $orderId = intval($this->db->lastInsertId());

            $queryItem = "INSERT INTO order_items (order_id, product_id, quantity, price, subtotal)
                          VALUES (:order_id, :product_id, :quantity, :price, :subtotal)";
            $stmtItem = $this->db->prepare($queryItem);

            $queryStock = "UPDATE products
                           SET stock = :stock, updated_at = CURRENT_TIMESTAMP
                           WHERE id = :id AND store_id = :store_id";
            $stmtStock = $this->db->prepare($queryStock);

            foreach ($preparedItems as $item) {
                $stmtItem->bindValue(':order_id', $orderId, PDO::PARAM_INT);
                $stmtItem->bindValue(':product_id', intval($item['product_id']), PDO::PARAM_INT);
                $stmtItem->bindValue(':quantity', intval($item['quantity']), PDO::PARAM_INT);
                $stmtItem->bindValue(':price', floatval($item['price']));
                $stmtItem->bindValue(':subtotal', floatval($item['subtotal']));
                $stmtItem->execute();

                $stmtStock->bindValue(':stock', intval($item['new_stock']), PDO::PARAM_INT);
                $stmtStock->bindValue(':id', intval($item['product_id']), PDO::PARAM_INT);
                $stmtStock->bindValue(':store_id', intval($store_id), PDO::PARAM_INT);
                $stmtStock->execute();
            }

            $this->db->commit();

            return [
                'order_id' => $orderId,
                'order_number' => $orderNumber,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_cost' => $shipping,
                'discount' => $discount,
                'total' => $total
            ];
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }

    public function findById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByStore($store_id, $limit = 20, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE store_id = :store_id
                  ORDER BY created_at DESC 
                  LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':store_id', $store_id);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCustomer($store_id, $customer_id, $limit = 20, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE store_id = :store_id AND user_id = :user_id
                  ORDER BY created_at DESC
                  LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':store_id', $store_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $customer_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByCustomer($store_id, $customer_id) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . "
                  WHERE store_id = :store_id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':store_id', $store_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return intval($row['total'] ?? 0);
    }

    public function findByIdForCustomer($order_id, $store_id, $customer_id) {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE id = :id AND store_id = :store_id AND user_id = :user_id
                  LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':store_id', $store_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET status = :status, 
                      payment_status = :payment_status,
                      updated_at = CURRENT_TIMESTAMP 
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':payment_status', $this->payment_status);

        return $stmt->execute();
    }

    public function addOrderItem($order_id, $product_id, $quantity, $price) {
        $query = "INSERT INTO order_items (order_id, product_id, quantity, price, subtotal) 
                  VALUES (:order_id, :product_id, :quantity, :price, :subtotal)";

        $stmt = $this->db->prepare($query);
        $subtotal = $quantity * $price;

        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':subtotal', $subtotal);

        return $stmt->execute();
    }

    public function getOrderItems($order_id) {
        $query = "SELECT oi.*, p.name, p.image FROM order_items oi
                  JOIN products p ON oi.product_id = p.id
                  WHERE oi.order_id = :order_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function generateOrderNumber() {
        return 'ORD-' . time() . '-' . rand(1000, 9999);
    }

    public function countByStore($store_id) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE store_id = :store_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':store_id', $store_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalRevenue($store_id) {
        $query = "SELECT SUM(total) as revenue FROM " . $this->table . " 
                  WHERE store_id = :store_id AND status != 'cancelled'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':store_id', $store_id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['revenue'] ?? 0;
    }

    public function getPosDailySummary($store_id, $date) {
        $query = "SELECT
                    COUNT(*) as total_sales,
                    COALESCE(SUM(total), 0) as gross_total,
                    COALESCE(AVG(total), 0) as average_ticket,
                    COALESCE(SUM(CASE WHEN payment_method = 'cash' THEN total ELSE 0 END), 0) as cash_total,
                    COALESCE(SUM(CASE WHEN payment_method = 'card' THEN total ELSE 0 END), 0) as card_total,
                    COALESCE(SUM(CASE WHEN payment_method = 'transfer' THEN total ELSE 0 END), 0) as transfer_total,
                    COALESCE(SUM(CASE WHEN payment_method = 'mixed' THEN total ELSE 0 END), 0) as mixed_total,
                    MAX(created_at) as last_sale_at
                  FROM " . $this->table . "
                  WHERE store_id = :store_id
                    AND DATE(created_at) = :sale_date
                    AND status != 'cancelled'
                    AND (notes LIKE 'POS:%' OR shipping_address = 'Venta POS en tienda')";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':store_id', intval($store_id), PDO::PARAM_INT);
        $stmt->bindValue(':sale_date', $date);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: [
            'total_sales' => 0,
            'gross_total' => 0,
            'average_ticket' => 0,
            'cash_total' => 0,
            'card_total' => 0,
            'transfer_total' => 0,
            'mixed_total' => 0,
            'last_sale_at' => null
        ];
    }

    public function getPosOrdersByDate($store_id, $date, $limit = 100) {
        $query = "SELECT id, order_number, customer_name, payment_method, payment_status, status, total, created_at
                  FROM " . $this->table . "
                  WHERE store_id = :store_id
                    AND DATE(created_at) = :sale_date
                    AND status != 'cancelled'
                    AND (notes LIKE 'POS:%' OR shipping_address = 'Venta POS en tienda')
                  ORDER BY created_at DESC
                  LIMIT :limit";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':store_id', intval($store_id), PDO::PARAM_INT);
        $stmt->bindValue(':sale_date', $date);
        $stmt->bindValue(':limit', intval($limit), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
