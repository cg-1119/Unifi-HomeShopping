<?php
require_once "../config/database.php";
header('Content-Type: text/html; charset=utf-8');
class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function checkDuplicatePhone($phone)
    {
        $con = $this->db->connect();
        $phone = mysql_real_escape_string($phone);
        $sql = "SELECT * FROM users WHERE phone = '$phone'";
        $result = mysql_query($sql, $con);
        $this->db->close();
        return mysql_num_rows($result) > 0;
    }

    public function registerUser($phone, $id, $pw, $name)
    {
        $con = $this->db->connect();
        $phone = mysql_real_escape_string($phone);
        $id = mysql_real_escape_string($id);
        $pw = mysql_real_escape_string($pw);
        $name = mysql_real_escape_string($name);

        $sql = "INSERT INTO users (phone, id, pw, name) VALUES ('$phone', '$id', '$pw', '$name')";
        $result = mysql_query($sql, $con);
        $this->db->close();
        return $result;
    }

    // find_id
    public function findIdByNameAndPhone($name, $phone)
    {
        $sql = "SELECT id FROM users WHERE name = '$name' AND phone = '$phone'";
        $result = mysql_query($sql, $this->db->connect());
        return mysql_fetch_assoc($result);
    }

    // find_pw
    public function verifyUserForPasswordReset($name, $phone)
    {
        $sql = "SELECT id FROM users WHERE name = '$name' AND phone = '$phone'";
        $result = mysql_query($sql, $this->db->connect());
        return mysql_fetch_assoc($result);
    }

    // pw_update
    public function updatePassword($id, $newPassword)
    {
        $hashedPassword = md5($newPassword);
        $sql = "UPDATE users SET pw = '$hashedPassword' WHERE id = '$id'";
        return mysql_query($sql, $this->db->connect());
    }
}
?>