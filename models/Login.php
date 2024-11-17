<?php
require_once "../config/database.php";
class Login
{
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

    public function login($id, $password) {
        $con = $this->db->connect();
        $id = mysql_real_escape_string($id);
        $hashedPassword = md5($password);

        $sql = "SELECT * FROM users WHERE id = '$id' AND pw = '$hashedPassword'";
        $result = mysql_query($sql, $con);

        if($result && mysql_num_rows($result) > 0) {
            $user = mysql_fetch_assoc($result);
            $this->db->close();
            return $user;
        } else {
            $this->db->close();
            return null;
        }
    }
    // Admin
    public function adminLogin($id, $password) {
        $con = $this->db->connect();
        $id = mysql_real_escape_string($id);
        $hashedPassword = md5($password);

        $sql = "SELECT * FROM admins WHERE id = '$id' AND pw = '$hashedPassword'";
        $result = mysql_query($sql, $con);

        if ($result && mysql_num_rows($result) > 0) {
            $admin = mysql_fetch_assoc($result);
            $this->db->close();
            return $admin; // 관리자 정보 반환
        } else {
            $this->db->close();
            return null; // 인증 실패
        }
    }
}