<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';

class Payment
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // 1. 결제 데이터 추가
    public function addPayment($orderId, $paymentMethod, $paymentPrice, $paymentInfo = null)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("INSERT INTO payments (order_id, payment_method, payment_price, payment_info) 
                VALUES (:order_id, :payment_method, :payment_price, :payment_info)");
        $stmt->execute([
            'order_id' => $orderId,
            'payment_method' => $paymentMethod,
            'payment_price' => $paymentPrice,
            'payment_info' => $paymentInfo
        ]);
    }

    // 2. 특정 주문의 결제 정보 조회
    public function getPaymentByOrderId($orderId)
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("SELECT * FROM payments WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. 모든 결제 데이터 조회 (관리자용)
    public function getAllPayments()
    {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("SELECT * FROM payments");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
