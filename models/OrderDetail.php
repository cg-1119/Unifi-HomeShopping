<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';

class OrderDetail
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // 1. 주문 상세 추가
    public function addOrderDetail($orderId, $productId, $quantity, $price)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) 
                VALUES (:order_id, :product_id, :quantity, :price)");
        $stmt->execute([
            'order_id' => $orderId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $price
        ]);
    }

    // 2. 특정 주문의 상세 정보 조회
    public function getOrderDetailsByOrderId($orderId)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("SELECT * FROM order_details WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. 모든 주문 상세 조회 (관리자용)
    public function getAllOrderDetails()
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("SELECT * FROM order_details");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
