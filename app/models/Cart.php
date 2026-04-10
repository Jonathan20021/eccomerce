<?php

require_once __DIR__ . '/../config/Database.php';

class Cart {
    private $db;
    private $table = 'cart_items';

    public $id;
    public $user_id;
    public $session_id;
    public $store_id;
    public $product_id;
    public $quantity;
    public $price;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function addItem($product_id, $quantity = 1, $store_id = null, $user_id = null) {
        $session_id = session_id();
        
        // Verificar si el item ya existe en el carrito
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE product_id = :product_id 
                  AND (" . ($user_id ? "user_id = :user_id" : "session_id = :session_id") . ")";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        if ($user_id) {
            $stmt->bindParam(':user_id', $user_id);
        } else {
            $stmt->bindParam(':session_id', $session_id);
        }
        $stmt->execute();
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Actualizar cantidad
            return $this->updateQuantity($existing['id'], $existing['quantity'] + $quantity);
        } else {
            // Insertar nuevo item
            $query = "INSERT INTO " . $this->table . " 
                      (user_id, session_id, store_id, product_id, quantity) 
                      VALUES 
                      (:user_id, :session_id, :store_id, :product_id, :quantity)";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':session_id', $session_id);
            $stmt->bindParam(':store_id', $store_id);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':quantity', $quantity);

            return $stmt->execute();
        }
    }

    public function getCart($user_id = null) {
        $session_id = session_id();
        
        $query = "SELECT ci.*, p.name, p.image, p.price, p.discount_price, p.discount_percent
                  FROM " . $this->table . " ci
                  JOIN products p ON ci.product_id = p.id
                  WHERE " . ($user_id ? "ci.user_id = :user_id" : "ci.session_id = :session_id");
        
        $stmt = $this->db->prepare($query);
        if ($user_id) {
            $stmt->bindParam(':user_id', $user_id);
        } else {
            $stmt->bindParam(':session_id', $session_id);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateQuantity($cart_item_id, $quantity) {
        if ($quantity <= 0) {
            return $this->removeItem($cart_item_id);
        }

        $query = "UPDATE " . $this->table . " 
                  SET quantity = :quantity, updated_at = CURRENT_TIMESTAMP 
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':id', $cart_item_id);

        return $stmt->execute();
    }

    public function removeItem($cart_item_id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $cart_item_id);

        return $stmt->execute();
    }

    public function clearCart($user_id = null) {
        $session_id = session_id();
        
        $query = "DELETE FROM " . $this->table . " 
                  WHERE " . ($user_id ? "user_id = :user_id" : "session_id = :session_id");

        $stmt = $this->db->prepare($query);
        if ($user_id) {
            $stmt->bindParam(':user_id', $user_id);
        } else {
            $stmt->bindParam(':session_id', $session_id);
        }

        return $stmt->execute();
    }

    public function getCartTotal($user_id = null) {
        $cart = $this->getCart($user_id);
        $total = 0;

        foreach ($cart as $item) {
            $discountPrice = isset($item['discount_price']) ? floatval($item['discount_price']) : 0;
            $price = $discountPrice > 0 ? $discountPrice : floatval($item['price']);
            $total += $price * $item['quantity'];
        }

        return $total;
    }

    public function getCartCount($user_id = null) {
        $cart = $this->getCart($user_id);
        return count($cart);
    }
}
