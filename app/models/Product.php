<?php

require_once __DIR__ . '/../config/Database.php';

class Product {
    private $db;
    private $table = 'products';

    public $id;
    public $store_id;
    public $name;
    public $slug;
    public $description;
    public $price;
    public $cost;
    public $discount_price;
    public $discount_percent;
    public $sku;
    public $image;
    public $gallery;
    public $category_id;
    public $stock;
    public $is_active;
    public $rating;
    public $reviews_count;
    public $meta_title;
    public $meta_description;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (store_id, name, slug, description, price, cost, discount_price, discount_percent, 
                   sku, image, category_id, stock, is_active, meta_title, meta_description) 
                  VALUES 
                  (:store_id, :name, :slug, :description, :price, :cost, :discount_price, :discount_percent, 
                   :sku, :image, :category_id, :stock, :is_active, :meta_title, :meta_description)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':store_id', $this->store_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':slug', $this->slug);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':cost', $this->cost);
        $stmt->bindParam(':discount_price', $this->discount_price);
        $stmt->bindParam(':discount_percent', $this->discount_percent);
        $stmt->bindParam(':sku', $this->sku);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':stock', $this->stock);
        $stmt->bindParam(':is_active', $this->is_active);
        $stmt->bindParam(':meta_title', $this->meta_title);
        $stmt->bindParam(':meta_description', $this->meta_description);

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

    public function findBySlugAndStore($slug, $store_id) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE slug = :slug AND store_id = :store_id AND is_active = 1
                  LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':store_id', $store_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByStore($store_id, $limit = 20, $offset = 0) {
        $query = "SELECT p.*, c.name AS category_name FROM " . $this->table . " p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE p.store_id = :store_id AND p.is_active = 1
                  ORDER BY p.created_at DESC 
                  LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':store_id', $store_id);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByStoreFiltered($store_id, $filters = [], $limit = 20, $offset = 0) {
        $conditions = ["p.store_id = :store_id", "p.is_active = 1"];
        $params = [':store_id' => intval($store_id)];

        if (!empty($filters['category_id'])) {
            $conditions[] = "p.category_id = :category_id";
            $params[':category_id'] = intval($filters['category_id']);
        }

        if (!empty($filters['q'])) {
            $conditions[] = "(p.name LIKE :q OR p.description LIKE :q)";
            $params[':q'] = '%' . $filters['q'] . '%';
        }

        $where = implode(' AND ', $conditions);
        $query = "SELECT p.*, c.name AS category_name
                  FROM " . $this->table . " p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE " . $where . "
                  ORDER BY p.created_at DESC
                  LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            if ($key === ':category_id' || $key === ':store_id') {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value);
            }
        }
        $stmt->bindValue(':limit', intval($limit), PDO::PARAM_INT);
        $stmt->bindValue(':offset', intval($offset), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByStoreFiltered($store_id, $filters = []) {
        $conditions = ["store_id = :store_id", "is_active = 1"];
        $params = [':store_id' => intval($store_id)];

        if (!empty($filters['category_id'])) {
            $conditions[] = "category_id = :category_id";
            $params[':category_id'] = intval($filters['category_id']);
        }

        if (!empty($filters['q'])) {
            $conditions[] = "(name LIKE :q OR description LIKE :q)";
            $params[':q'] = '%' . $filters['q'] . '%';
        }

        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE " . implode(' AND ', $conditions);
        $stmt = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            if ($key === ':category_id' || $key === ':store_id') {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value);
            }
        }
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return intval($row['total'] ?? 0);
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET name = :name, 
                      description = :description, 
                      price = :price, 
                      cost = :cost,
                      discount_price = :discount_price,
                      discount_percent = :discount_percent,
                      stock = :stock,
                      image = :image,
                      category_id = :category_id,
                      is_active = :is_active,
                      meta_title = :meta_title,
                      meta_description = :meta_description,
                      updated_at = CURRENT_TIMESTAMP 
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':cost', $this->cost);
        $stmt->bindParam(':discount_price', $this->discount_price);
        $stmt->bindParam(':discount_percent', $this->discount_percent);
        $stmt->bindParam(':stock', $this->stock);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':is_active', $this->is_active);
        $stmt->bindParam(':meta_title', $this->meta_title);
        $stmt->bindParam(':meta_description', $this->meta_description);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    public function countByStore($store_id) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE store_id = :store_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':store_id', $store_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function updateStock($id, $store_id, $stock) {
        $query = "UPDATE " . $this->table . "
                  SET stock = :stock, updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id AND store_id = :store_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':stock', intval($stock), PDO::PARAM_INT);
        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);
        $stmt->bindValue(':store_id', intval($store_id), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function searchAcrossStores($filters = [], $limit = 20, $offset = 0) {
        $conditions = ["p.is_active = 1", "s.is_active = 1"];
        $params = [];

        if (!empty($filters['q'])) {
            $conditions[] = "(p.name LIKE :q OR p.description LIKE :q)";
            $params[':q'] = '%' . $filters['q'] . '%';
        }

        if (!empty($filters['min_price'])) {
            $conditions[] = "COALESCE(NULLIF(p.discount_price, 0), p.price) >= :min_price";
            $params[':min_price'] = floatval($filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $conditions[] = "COALESCE(NULLIF(p.discount_price, 0), p.price) <= :max_price";
            $params[':max_price'] = floatval($filters['max_price']);
        }

        $orderBy = "p.created_at DESC";
        $sort = $filters['sort'] ?? '';
        if ($sort === 'price_asc') {
            $orderBy = "COALESCE(NULLIF(p.discount_price, 0), p.price) ASC";
        } elseif ($sort === 'price_desc') {
            $orderBy = "COALESCE(NULLIF(p.discount_price, 0), p.price) DESC";
        } elseif ($sort === 'name_asc') {
            $orderBy = "p.name ASC";
        }

        $whereSql = implode(' AND ', $conditions);

        $query = "SELECT p.id, p.name, p.slug, p.price, p.discount_price, p.image,
                         s.name AS store_name, s.slug AS store_slug
                  FROM " . $this->table . " p
                  JOIN stores s ON p.store_id = s.id
                  WHERE " . $whereSql . "
                  ORDER BY " . $orderBy . "
                  LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', intval($limit), PDO::PARAM_INT);
        $stmt->bindValue(':offset', intval($offset), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countSearchAcrossStores($filters = []) {
        $conditions = ["p.is_active = 1", "s.is_active = 1"];
        $params = [];

        if (!empty($filters['q'])) {
            $conditions[] = "(p.name LIKE :q OR p.description LIKE :q)";
            $params[':q'] = '%' . $filters['q'] . '%';
        }

        if (!empty($filters['min_price'])) {
            $conditions[] = "COALESCE(NULLIF(p.discount_price, 0), p.price) >= :min_price";
            $params[':min_price'] = floatval($filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $conditions[] = "COALESCE(NULLIF(p.discount_price, 0), p.price) <= :max_price";
            $params[':max_price'] = floatval($filters['max_price']);
        }

        $whereSql = implode(' AND ', $conditions);
        $query = "SELECT COUNT(*) as total
                  FROM " . $this->table . " p
                  JOIN stores s ON p.store_id = s.id
                  WHERE " . $whereSql;

        $stmt = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return intval($row['total'] ?? 0);
    }
}
