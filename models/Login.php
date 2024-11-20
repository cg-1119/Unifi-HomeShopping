<?php
require_once$_SERVER['DOCUMENT_ROOT'] . "/config/database.php";
class Login
{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function login($id, $password) {
        // 데이터베이스 연결
        $con = $this->db->connect();

        // SQL Injection 방지를 위한 Prepared Statement 사용
        $hashedPassword = md5($password); // 비밀번호 해싱
        $stmt = $con->prepare("SELECT * FROM users WHERE id = ? AND pw = ?");
        $stmt->bind_param("ss", $id, $hashedPassword); // 파라미터 바인딩

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $stmt->close();
            $this->db->close();
            return $user; // 사용자 정보 반환
        } else {
            $stmt->close();
            $this->db->close();
            return null; // 로그인 실패
        }
    }

    // Admin 로그인 함수
    /*public function adminLogin($id, $password) {
        $con = $this->db->connect();

        // SQL Injection 방지를 위한 Prepared Statement 사용
        $hashedPassword = md5($password); // 비밀번호 해싱
        $stmt = $con->prepare("SELECT * FROM admins WHERE id = ? AND pw = ?");
        $stmt->bind_param("ss", $id, $hashedPassword); // 파라미터 바인딩

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            $stmt->close();
            $this->db->close();
            return $admin; // 관리자 정보 반환
        } else {
            $stmt->close();
            $this->db->close();
            return null; // 인증 실패
        }
    }*/
}
?>
