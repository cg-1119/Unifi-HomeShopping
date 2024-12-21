<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';

class Point
{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // 포인트 추가
    public function setUserPoint($userId, $paymentPrice) {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("INSERT INTO points (user_id, point) VALUES (:user_id, :point)");
            return $stmt->execute([
                'user_id' => $userId,
                'point' => round($paymentPrice * 0.01)
            ]);
        } catch (PDOException $e) {
            error_log("Point Model setUserPoint Error: " . $e->getMessage());
            return false;
        }
    }
}