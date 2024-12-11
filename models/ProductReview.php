<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
class ProductReview
{
    private $db;
    public function __construct() {
        $this->db = new Database();
    }
    public function createEmptyReview($productId, $userId, $rate, $content)
    {
        $pdo = $this->db->connect();

        try {
            $stmt = $pdo->prepare("INSERT INTO product_reviews (product_id, user_id, rate, content) VALUES (:product_id, :user_id, :rate, :content);");
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':rate', $rate, PDO::PARAM_INT);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Set Product Review Error: " . $e->getMessage());
            return false;
        }
    }
    public function updateImagePath($reviewId, $imagePath)
    {
        $pdo = $this->db->connect();

        try {
            $stmt = $pdo->prepare("UPDATE product_reviews SET image_path = :image_path WHERE id = :review_id");
            $stmt->bindParam(':image_path', $imagePath, PDO::PARAM_STR);
            $stmt->bindParam(':review_id', $reviewId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update Image Path Error: " . $e->getMessage());
            die(json_encode(['error' => 'Failed to update image path.']));
        }
    }



    public function getProductReviewById(int $reviewId): ?array
    {
        $pdo = $this->db->connect();

        try {
            $stmt = $pdo->prepare("SELECT id, product_id, user_id, rate, content, image_path, created_at FROM product_reviews WHERE id = :review_id");
            $stmt->bindParam(':review_id', $reviewId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Product Review By ID Error: " . $e->getMessage());
            return null;
        }
    }

    public function hasUserReviewedProduct(int $productId, int $userId): bool
    {
        $pdo = $this->db->connect();

        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM product_reviews WHERE product_id = :product_id AND user_id = :user_id");
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Check User Review Error: " . $e->getMessage());
            return false;
        }
    }

}