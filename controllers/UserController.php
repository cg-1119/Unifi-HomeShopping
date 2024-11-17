<?php
require_once "../models/User.php";
header('Content-Type: text/html; charset=utf-8');

class UserController {
    private $users;

    public function __construct() {
        $this->users = new User();
    }

    public function register() {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $pw = isset($_POST['pw']) ? $_POST['pw'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';


        // 전화번호 중복 확인
        if ($this->users->checkDuplicatePhone($phone)) {
            echo "<script>alert('이미 등록된 전화번호입니다.'); history.back();</script>";
            return;
        }

        // 비밀번호 암호화
        $hashed_pw = md5($pw);

        // 회원 정보 등록
        if ($this->users->registerUser($phone, $id, $hashed_pw, $name)) {
            echo "<script>alert('회원가입이 완료되었습니다!'); location.href = '/views/home/index.php';</script>";
        } else {
            echo "<script>alert('회원가입에 실패했습니다. 다시 시도해주세요.'); history.back();</script>";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $controller = new UserController();

    if($_POST['action'] === 'register') {
        $controller->register();
    }
}
?>