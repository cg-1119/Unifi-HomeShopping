<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
class Order
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // 주문 생성
    public function setOrder($uid, $address, $phone)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, address, phone) 
                VALUES (:user_id, :address, :phone)");
        $stmt->execute([
            'user_id' => $uid,
            'address' => $address,
            'phone' => $phone,
        ]);
        return $pdo->lastInsertId(); // 생성된 주문 ID 반환
    }

    // 주문 상태 업데이트
    public function getOrderStatus($orderId, $status)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("UPDATE orders SET status = :status WHERE id = :order_id");
        $stmt->execute([
            'status' => $status,
            'order_id' => $orderId
        ]);
    }

    // 배송 상태 업데이트
    public function updateDeliveryStatus($orderId, $deliveryStatus)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("UPDATE orders SET delivery_status = :delivery_status WHERE id = :order_id");
        $stmt->execute([
            'delivery_status' => $deliveryStatus,
            'order_id' => $orderId
        ]);
    }

    // 특정 사용자의 주문 조회
    public function getOrdersByUserId($userId)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_date DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
