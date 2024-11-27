<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/Database.php";

class Login
{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function login($id, $password) {
        $pdo = $this->db->connect();

        try {
            $hashedPassword = hash('sha256', $password); // 비밀번호 해싱 (SHA-256)
            $stmt = $pdo->prepare("SELECT id, name, phone, is_admin FROM users WHERE id = :id AND pw = :pw");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':pw', $hashedPassword, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC); // 사용자 정보 가져오기
            return $user ?: null;

        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return null;
        }
    }
}
?>
