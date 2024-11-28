<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';
header('Content-Type: text/html; charset=utf-8');

class UserController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    // views/custom/join/input
    public function register() {
        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $pw = isset($_POST['pw']) ? trim($_POST['pw']) : '';
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

        // 전화번호 중복 확인
        if ($this->user->checkDuplicatePhone($phone)) {
            echo "<script>alert('이미 등록된 전화번호입니다.'); history.back();</script>";
            return;
        }

        // 비밀번호 암호화
        $hashed_pw = hash('sha256', $pw);

        if ($this->user->registerUser($id, $hashed_pw, $name, $email, $phone)) {
            echo "<script>alert('회원가입이 완료되었습니다!'); location.href = '/views/user/login.php';</script>";
        } else {
            echo "<script>alert('회원가입에 실패했습니다. 다시 시도해주세요.'); history.back();</script>";
        }
    }

    // views/custom/find/find_id_result
    public function requestFindId() {
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $result = $this->user->queryToFindId($name, $phone);

        if ($result) {
            session_start();
            $_SESSION['find_id_result'] = array(
                'status' => 'success',
                'id' => $result['id']
            );
        } else {
            session_start();
            $_SESSION['find_id_result'] = array(
                'status' => 'error',
                'message' => '일치하는 사용자를 찾을 수 없습니다.'
            );
        }

        header("Location: /views/user/find/find_id_result.php");
        exit;
    }

    // views/custom/find_pw
    public function requestPwReset()
    {
        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';

        // 사용자 확인
        if ($this->user->queryToResetPw($id, $name)) {
            session_start();
            $_SESSION['pw_reset_user'] = array(
                'status' => 'success',
                'id' => $id
            );

            header("Location: /views/user/find/reset_password.php");
            exit;
        } else {
            echo "<script>alert('일치하는 사용자를 찾을 수 없습니다.'); history.back();</script>";
            exit;
        }
    }
    // views/custom/reset_password
    public function resetPassword() {
        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $newPassword = isset($_POST['newPassword']) ? trim($_POST['newPassword']) : '';

        // 비밀번호 업데이트
        if ($this->user->updatePassword($id, $newPassword)) {
            session_start();
            unset($_SESSION['pw_reset_user']);

            echo "<script>alert('비밀번호가 성공적으로 재설정되었습니다.'); location.href = '/views/user/login.php';</script>";
        } else {
            echo "<script>alert('비밀번호 재설정에 실패했습니다. 다시 시도해주세요.'); history.back();</script>";
        }
    }
}

// 요청 처리
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $controller = new UserController();

    if ($_POST['action'] === 'register')
        $controller->register();
    else if ($_POST['action'] === 'requestFindId')
        $controller->requestFindId();
    else if ($_POST['action'] === 'requestPwReset')
        $controller->requestPwReset();
    else if ($_POST['action'] === 'resetPassword')
        $controller->resetPassword();

} else if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action'])) {
    $controller = new UserController();
}
?>
