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
        $stmt = $con->prepare("SELECT id, name, phone, is_admin FROM users WHERE id = ? AND pw = ?");
        $stmt->bind_param("ss", $id, $hashedPassword);

        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($retrievedId, $retrievedName, $retrievedPhone, $retrievedIsAdmin);
            $stmt->fetch();

            // 사용자 정보 배열 생성
            $user = array(
                'id' => $retrievedId,
                'name' => $retrievedName,
                'phone' => $retrievedPhone,
                'is_admin' => $retrievedIsAdmin
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
}
?>
