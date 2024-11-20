<?php
require_once$_SERVER['DOCUMENT_ROOT'] . "/config/database.php";
class Login
{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function login($id, $password) {
        $con = $this->db->connect();

        $hashedPassword = hash('sha256', $password);
        $stmt = $con->prepare("SELECT id, name, phone FROM users WHERE id = ? AND pw = ?");
        $stmt->bind_param("ss", $id, $hashedPassword);

        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($retrievedId, $retrievedName, $retrievedPhone);
            $stmt->fetch();

            // 사용자 정보 배열 생성
            $user = array(
                'id' => $retrievedId,
                'name' => $retrievedName,
                'phone' => $retrievedPhone
            );
            $stmt->close();
            $this->db->close();

            return $user;
        } else {
            $stmt->close();
            $this->db->close();
            return null;
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
