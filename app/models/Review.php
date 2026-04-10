<?php

require_once __DIR__ . '/../config/Database.php';

class Review {
    private $db;
    private $table = 'reviews';

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . "
                  (product_id, user_id, store_id, rating, customer_name, comment, is_verified, is_approved)
                  VALUES
                  (:product_id, :user_id, :store_id, :rating, :customer_name, :comment, :is_verified, :is_approved)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':product_id', intval($data['product_id']), PDO::PARAM_INT);
        $stmt->bindValue(':user_id', isset($data['user_id']) ? intval($data['user_id']) : null, isset($data['user_id']) ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $stmt->bindValue(':store_id', intval($data['store_id']), PDO::PARAM_INT);
        $stmt->bindValue(':rating', max(1, min(5, intval($data['rating'] ?? 5))), PDO::PARAM_INT);
        $stmt->bindValue(':customer_name', trim((string)($data['customer_name'] ?? '')));
        $stmt->bindValue(':comment', trim((string)($data['comment'] ?? '')));
        $stmt->bindValue(':is_verified', !empty($data['is_verified']) ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':is_approved', !empty($data['is_approved']) ? 1 : 0, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return intval($this->db->lastInsertId());
        }

        return false;
    }

    public function getApprovedByProduct($productId, $storeId) {
        $query = "SELECT r.*, u.name AS user_name
                  FROM " . $this->table . " r
                  LEFT JOIN users u ON r.user_id = u.id
                  WHERE r.product_id = :product_id
                    AND r.store_id = :store_id
                    AND r.is_approved = 1
                  ORDER BY r.created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':product_id', intval($productId), PDO::PARAM_INT);
        $stmt->bindValue(':store_id', intval($storeId), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByStore($storeId, $limit = 30, $offset = 0) {
        $query = "SELECT r.*, p.id AS product_id, p.name AS product_name, p.slug AS product_slug, p.image AS product_image,
                         u.name AS user_name
                  FROM " . $this->table . " r
                  INNER JOIN products p ON r.product_id = p.id
                  LEFT JOIN users u ON r.user_id = u.id
                  WHERE r.store_id = :store_id
                  ORDER BY r.created_at DESC
                  LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':store_id', intval($storeId), PDO::PARAM_INT);
        $stmt->bindValue(':limit', intval($limit), PDO::PARAM_INT);
        $stmt->bindValue(':offset', intval($offset), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByStore($storeId) {
        $query = "SELECT COUNT(*) AS total FROM " . $this->table . " WHERE store_id = :store_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':store_id', intval($storeId), PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return intval($row['total'] ?? 0);
    }

    public function getStatsByStore($storeId) {
        $query = "SELECT COUNT(*) AS total_reviews,
                         SUM(CASE WHEN COALESCE(TRIM(reply_comment), '') <> '' THEN 1 ELSE 0 END) AS replied_reviews,
                         SUM(CASE WHEN COALESCE(TRIM(reply_comment), '') = '' THEN 1 ELSE 0 END) AS pending_reviews,
                         ROUND(AVG(rating), 1) AS avg_rating
                  FROM " . $this->table . "
                  WHERE store_id = :store_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':store_id', intval($storeId), PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        return [
            'total_reviews' => intval($row['total_reviews'] ?? 0),
            'replied_reviews' => intval($row['replied_reviews'] ?? 0),
            'pending_reviews' => intval($row['pending_reviews'] ?? 0),
            'avg_rating' => floatval($row['avg_rating'] ?? 0)
        ];
    }

    public function getTopCommentedProducts($storeId, $limit = 5) {
        $query = "SELECT p.id AS product_id,
                         p.name AS product_name,
                         p.slug AS product_slug,
                         p.image AS product_image,
                         COUNT(r.id) AS comments_count,
                         ROUND(AVG(r.rating), 1) AS avg_rating
                  FROM " . $this->table . " r
                  INNER JOIN products p ON r.product_id = p.id
                  WHERE r.store_id = :store_id
                  GROUP BY p.id, p.name, p.slug, p.image
                  ORDER BY comments_count DESC, p.name ASC
                  LIMIT :limit";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':store_id', intval($storeId), PDO::PARAM_INT);
        $stmt->bindValue(':limit', intval($limit), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateReply($id, $storeId, $replyComment, $isApproved = true) {
        $query = "UPDATE " . $this->table . "
                  SET reply_comment = :reply_comment,
                      replied_at = CURRENT_TIMESTAMP,
                      is_approved = :is_approved,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id AND store_id = :store_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':reply_comment', trim((string)$replyComment));
        $stmt->bindValue(':is_approved', $isApproved ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);
        $stmt->bindValue(':store_id', intval($storeId), PDO::PARAM_INT);

        return $stmt->execute();
    }
}
