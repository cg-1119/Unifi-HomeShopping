<?php
require_once "../config/database.php";
class User{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // 전화번호 중복 체크
    public function checkDuplicatePhone($phone) {
        $con = $this->db->connect();

        // Prepared Statement 사용
        $stmt = $con->prepare("SELECT * FROM users WHERE phone = ?");
        $stmt->bind_param("s", $phone); // 파라미터 바인딩
        $stmt->execute();
        $result = $stmt->get_result();

        $isDuplicate = $result->num_rows > 0; // 중복 여부 확인

        $stmt->close();
        $this->db->close();
        return $isDuplicate;
    }

    // 사용자 등록
    public function registerUser($phone, $id, $pw, $name) {
        $con = $this->db->connect();

        // Prepared Statement 사용
        $stmt = $con->prepare("INSERT INTO users (phone, id, pw, name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $phone, $id, $pw, $name); // 파라미터 바인딩
        $result = $stmt->execute(); // 쿼리 실행

        $stmt->close();
        $this->db->close();
        return $result; // 성공 여부 반환
    }
}
?>

