<?php
require_once "../models/User.php";
header('Content-Type: text/html; charset=utf-8');

class UserController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    // input
    public function register() {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $pw = isset($_POST['pw']) ? $_POST['pw'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';


        // 전화번호 중복 확인
        if ($this->user->checkDuplicatePhone($phone)) {
            echo "<script>alert('이미 등록된 전화번호입니다.'); history.back();</script>";
            return;
        }

        // 비밀번호 암호화
        $hashed_pw = md5($pw);

        // 회원 정보 등록
        if ($this->user->registerUser($phone, $id, $hashed_pw, $name)) {
            echo "<script>alert('회원가입이 완료되었습니다!'); location.href = '/views/home/index.php';</script>";
        } else {
            echo "<script>alert('회원가입에 실패했습니다. 다시 시도해주세요.'); history.back();</script>";
        }
    }

    // find_id
    public function findId() {
        $name = $_POST['name'];
        $phone = $_POST['phone'];

        $result = $this->user->findIdByNameAndPhone($name, $phone);

        echo $result['id'];

        if ($result) {
            echo "<script>alert('아이디는 " . $result['id'] . "입니다.'); location.href = '/views/user/login.php';</script>";
        } else {
            echo "<script>alert('일치하는 사용자를 찾을 수 없습니다.'); history.back();</script>";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $controller = new UserController();

    if ($_POST['action'] === 'register') {
        $controller->register();
    } else if ($_POST['action'] === 'find_id') {
        $controller->findId();
    }
} else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action'])) {
    $controller = new UserController();

    if ($_GET['action'] === 'find_id') {
        $controller->findId();
    }
}