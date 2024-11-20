<?php
require_once$_SERVER['DOCUMENT_ROOT'] . "/config/database.php";

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // 사용자 등록
    public function registerUser($id, $pw, $name, $phone) {
        $con = $this->db->connect();

        $stmt = $con->prepare("INSERT INTO users (id, pw, name, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $id, $pw, $name, $phone);
        $result = $stmt->execute();

        $stmt->close();
        $this->db->close();

        return $result;
    }
    // 전화번호 중복 체크
    public function checkDuplicatePhone($phone) {
        $con = $this->db->connect();

        $stmt = $con->prepare("SELECT phone FROM users WHERE phone = ?");
        $stmt->bind_param("s", $phone); // 파라미터 바인딩
        $stmt->execute();

        $stmt->bind_result($retrievedPhone);
        $isDuplicate = false;

        if ($stmt->fetch()) {
            $isDuplicate = true;
        }

        $stmt->close();
        $this->db->close();

        return $isDuplicate;
    }

    // 아이디 찾기
    public function queryToFindId($name, $phone) {
        $con = $this->db->connect();

        $stmt = $con->prepare("SELECT id FROM users WHERE name = ? AND phone = ?");
        $stmt->bind_param("ss", $name, $phone);
        $stmt->execute();

        $stmt->bind_result($id);
        $result = null;

        if ($stmt->fetch()) {
            $result = array('id' => $id);
        }

        $stmt->close();
        $this->db->close();

        return $result;
    }

    // 비밀번호 찾기
    public function queryToResetPw($id, $name) {
        $con = $this->db->connect();

        $stmt = $con->prepare("SELECT id FROM users WHERE id = ? AND name = ?");
        $stmt->bind_param("ss", $id, $name);
        $stmt->execute();

        $stmt->bind_result($retrievedId);
        $result = null;

        if ($stmt->fetch()) {
            $result = array('id' => $retrievedId);
        }

        $stmt->close();
        $this->db->close();

        return $result;
    }

    public function updatePassword($id, $newPassword) {
        $con = $this->db->connect();

        // 비밀번호 해싱 (SHA-256)
        $hashedPassword = hash('sha256', $newPassword);

        // 비밀번호 업데이트
        $stmt = $con->prepare("UPDATE users SET pw = ? WHERE id = ?");
        $stmt->bind_param("ss", $hashedPassword, $id);
        $result = $stmt->execute();

        $stmt->close();
        $this->db->close();

        return $result;
    }
}
?>
