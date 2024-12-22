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
            $stmt = $pdo->prepare(
                "SELECT u.uid, u.id, u.name, u.email, u.phone, u.address, u.is_admin, 
                    COALESCE(SUM(p.point), 0) AS point
             FROM users u
             LEFT JOIN points p ON u.uid = p.user_id
             WHERE u.id = :id AND u.pw = :pw
             GROUP BY u.uid"
            );
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':pw', $hashedPassword, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ?: null;

        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return null;
        }
    }
}
?>
