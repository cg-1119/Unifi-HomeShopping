<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/database.php";

class Wishlist
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function setWishlist($userId, $productId)
    {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (:user_id, :product_id)");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("addToWishlist error: " . $e->getMessage());
            return false;
        }
    }

    public function removeFromWishlist($userId, $productId)
    {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("DELETE FROM wishlist WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("removeFromWishlist error: " . $e->getMessage());
            return false;
        }
    }

    // 찜 여부 확인
    public function isProductInWishlist($userId, $productId)
    {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("isProductInWishlist error: " . $e->getMessage());
            return false;
        }
    }

    public function getWishlistByUser($userId)
    {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("
        SELECT 
            p.id,
            p.name,
            p.price,
            pi.file_path AS product_image
        FROM 
            products p
        JOIN 
            wishlist w ON p.id = w.product_id
        LEFT JOIN 
            product_images pi ON p.id = pi.product_id AND pi.is_thumbnail = 1
        WHERE 
            w.user_id = :user_id
        ");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("getWishlistByUser error: " . $e->getMessage());
            return false;
        }
    }


}