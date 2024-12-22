<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';

class Point
{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // 포인트 추가
    public function addUserPoint($userId, $orderId, $paymentPrice, $type) {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("INSERT INTO points (user_id, order_id, point, type) VALUES (:user_id, :order_id, :point, :type)");
            return $stmt->execute([
                'user_id' => $userId,
                'order_id' => $orderId,
                'point' => round($paymentPrice * 0.01),
                'type' => $type
            ]);
        } catch (PDOException $e) {
            error_log("Point Model setUserPoint Error: " . $e->getMessage());
            return false;
        }
    }
    // 포인트 차감
    public function reducePoint($userId, $orderId, $point, $type) {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("INSERT INTO points (user_id, order_id, point, type) VALUES (:user_id, :order_id, :point, :type)");
            return $stmt->execute([
                'user_id' => $userId,
                'order_id' => $orderId,
                'point' => -$point,
                'type' => $type
            ]);
        } catch (PDOException $e) {
            error_log("Point Model usePoint Error: " . $e->getMessage());
            return false;
        }
    }
    // 특정 유저의 총 포인트 조회
    public function getUserPoint($userId) {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("SELECT COALESCE(SUM(point), 0) AS total_points FROM points WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_points'] ?? 0;
        } catch (PDOException $e) {
            error_log("Point Model getUserPoint Error: " . $e->getMessage());
            return false;
        }
    }
    // 특정 유저의 포인트 내역 조회
    public function getUserPointInfo($userId) {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("SELECT * FROM points WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            error_log("Point Model getUserPointInfo Error: " . $e->getMessage());
            return false;
        }
    }
    // 특정 주문 적립 포인트 조회
    public function getPointByOrderId($orderId) {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("SELECT point FROM points WHERE order_id = :order_id");
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['point'] ?? 0;
        } catch (PDOException $e) {
            error_log("Point Model getPointByOrderId Error: " . $e->getMessage());
            return false;
        }
    }
}