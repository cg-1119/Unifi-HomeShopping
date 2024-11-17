<?php
require_once("../models/Login.php");
header('Content-Type: text/html; charset=utf-8');

class LoginController {
    private $loginModel;

    function __construct() {
        $this->loginModel = new Login();
    }

    public function login()
    {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";
        $user = $this->loginModel->login($id, $password);

        if ($user) {
            session_start();
            $_SESSION["user"] = $user;
            echo "<script>location.href = '/views/home/index.php';</script>";
        } else echo '<script>alert("로그인 실패: ID 또는 비밀번호가 올바르지 않습니다."); history.back();</script>';
    }
    public function logout() {
        session_start();
        session_destroy();
        echo "<script>location.href = '/views/home/index.php';</script>";
    }
}
// POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new LoginController();

    if ($_POST['action'] === 'login') {
        $controller->login();
    }
}
// GET
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controller = new LoginController();

    if ($_GET['action'] === 'logout') {
        $controller->logout();
    }
}
?>