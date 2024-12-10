<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Login.php';
header('Content-Type: text/html; charset=utf-8');

class LoginController{
    private $loginModel;

    public function __construct() {
        $this->loginModel = new Login();
    }

    public function login() {
        $id = isset($_POST["id"]) ? htmlspecialchars(trim($_POST["id"])) : "";
        $password = isset($_POST["password"]) ? htmlspecialchars(trim($_POST["password"])) : "";
        $user = $this->loginModel->login($id, $password);
        if ($user) {
            session_start();
            $_SESSION['user'] = $user;
            echo "<script>location.href = '../views/main/index.php';</script>";
        } else {
            echo '<script>alert("로그인 실패: ID 또는 비밀번호가 올바르지 않습니다."); history.back();</script>';
        }
    }
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $cart = $_SESSION['cart'] ?? [];
        session_destroy();
        $_SESSION['cart'] = $cart;

        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
    }
}

// POST 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new LoginController();

    if ($_POST['action'] === 'login') {
        $controller->login();
    }
    else if ($_POST['action'] === 'logout') {
        $controller->logout();
    }
}
?>
