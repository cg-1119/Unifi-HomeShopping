<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Login.php';
header('Content-Type: text/html; charset=utf-8');

class LoginController{
    private $loginModel;

    public function __construct() {
        $this->loginModel = new Login();
    }

    // 로그인 메서드
    public function login() {
        // POST 데이터 확인 및 필터링
        $id = isset($_POST["id"]) ? htmlspecialchars(trim($_POST["id"])) : "";
        $password = isset($_POST["password"]) ? htmlspecialchars(trim($_POST["password"])) : "";


        // 로그인 처리
        $user = $this->loginModel->login($id, $password);

        if ($user) {
            session_start();
            $_SESSION["user"] = $user;

            echo "<script>location.href = '/views/home/index.php';</script>";
        } else {
            echo '<script>alert("로그인 실패: ID 또는 비밀번호가 올바르지 않습니다."); history.back();</script>';
        }
    }

    // 로그아웃 메서드
    public function logout() {
        session_start();

        // 세션이 시작되지 않았을 경우
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}

// POST 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new LoginController();

    if ($_POST['action'] === 'login') {
        $controller->login();
    }
}
// GET 요청 처리
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controller = new LoginController();

    if ($_GET['action'] === 'logout') {
        $controller->logout();
    }
}
?>
