<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
class Order
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // 1. 주문 생성
    public function createOrder($userId, $address, $phone, $totalPrice)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, address, phone, total_price) 
                VALUES (:user_id, :address, :phone, :total_price)");
        $stmt->execute([
            'user_id' => $userId,
            'address' => $address,
            'phone' => $phone,
            'total_price' => $totalPrice
        ]);
        return $pdo->lastInsertId(); // 생성된 주문 ID 반환
    }

    // 2. 주문 상태 업데이트
    public function updateOrderStatus($orderId, $status)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("UPDATE orders SET status = :status WHERE id = :order_id");
        $stmt->execute([
            'status' => $status,
            'order_id' => $orderId
        ]);
    }

    // 3. 배송 상태 업데이트
    public function updateDeliveryStatus($orderId, $deliveryStatus)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("UPDATE orders SET delivery_status = :delivery_status WHERE id = :order_id");
        $stmt->execute([
            'delivery_status' => $deliveryStatus,
            'order_id' => $orderId
        ]);
    }

    // 4. 특정 사용자의 주문 조회
    public function getOrdersByUserId($userId)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_date DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
