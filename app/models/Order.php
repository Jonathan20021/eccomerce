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
}
