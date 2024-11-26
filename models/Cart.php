<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Database.php';

class Cart
{
    private $db;
    public function __construct()
    {
        $this->db = new Database(); // Database 클래스는 PDO 연결 관리
    }
    public function addToCart($userId, $productId, $quantity)
    {
        try {
            // 이미 장바구니에 같은 상품이 있는지 확인
            $query = "SELECT id, quantity FROM cart WHERE user_id = :user_id AND product_id = :product_id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $existingCartItem = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingCartItem) {
                // 이미 존재하면 수량 업데이트
                $newQuantity = $existingCartItem['quantity'] + $quantity;
                $updateQuery = "UPDATE cart SET quantity = :quantity WHERE id = :id";
                $updateStmt = $this->db->connect()->prepare($updateQuery);
                $updateStmt->bindParam(':quantity', $newQuantity, PDO::PARAM_INT);
                $updateStmt->bindParam(':id', $existingCartItem['id'], PDO::PARAM_INT);
                return $updateStmt->execute();
            } else {
                // 새 상품 추가
                $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
                $insertStmt = $this->db->connect()->prepare($insertQuery);
                $insertStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $insertStmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $insertStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                return $insertStmt->execute();
            }
        } catch (Exception $e) {
            return false;
        }
    }
    public function getCartItems($userId)
    {
        try {
            $query = "
                SELECT 
                    cart.id, cart.product_id, cart.quantity, 
                    products.name AS product_name, products.price 
                FROM cart 
                INNER JOIN products ON cart.product_id = products.id 
                WHERE cart.user_id = :user_id
            ";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
    public function deleteCartItem($cartId)
    {
        try {
            $query = "DELETE FROM cart WHERE id = :id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':id', $cartId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 사용자 장바구니 비우기
     */
    public function clearCart($userId)
    {
        try {
            $query = "DELETE FROM cart WHERE user_id = :user_id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 장바구니 항목 업데이트 (수량 변경)
     */
    public function updateCartItem($cartId, $quantity)
    {
        try {
            $query = "UPDATE cart SET quantity = :quantity WHERE id = :id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':id', $cartId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}
