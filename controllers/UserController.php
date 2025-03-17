<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';
header('Content-Type: text/html; charset=utf-8');

class UserController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    // 사용자 등록
    public function register()
    {
        $id = $_POST['id'] ?? null;
        $pw = $_POST['pw'] ?? null;
        $name = $_POST['name'] ?? null;
        $email = $_POST['email'] ?? null;
        $phone = $_POST['phone'] ?? null;
        $address = $_POST['address'] ?? null;

        // 개인정보 중복 확인
        if ($this->userModel->checkDuplicate($id, $phone)) {
            echo "<script>alert('아이디나 전화번호가 중복됩니다! 다시 입력해 주세요.'); history.back();</script>";
            return;
        }

        // 비밀번호 암호화
        $hashed_pw = hash('sha256', $pw);

        if ($this->userModel->setUser($id, $hashed_pw, $name, $email, $phone, $address)) {
            echo "<script>alert('회원가입이 완료되었습니다!'); location.href = '/views/user/login.php';</script>";
        } else {
            echo "<script>alert('회원가입에 실패했습니다. 다시 시도해주세요.'); history.back();</script>";
        }
    }
    // 주소 변경
    public function modifyUserAddress()
    {
        $uid = $_POST['uid'] ?? null;
        $address = $_POST['address'] ?? null;

        if ($this->userModel->setUserAddressByUid($uid, $address)) {
            echo "<script>alert('배송지 수정이 완료되었습니다!'); location.href = '/views/user/setting.php';</script>";
        } else {
            echo "<script>alert('수정에 실패했습니다. 다시 시도해주세요.'); history.back();</script>";
        }
    }

    // 아이디 찾기
    public function requestFindId()
    {
        $name = $_POST['name'] ?? null;
        $phone = $_POST['phone'] ?? null;
        // 입력값 검증
        $result = $this->userModel->queryToFindId($name, $phone);
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

    // 비밀번호 초기화를 위한 정보 조회
    public function requestPwReset()
    {
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? null;

        // 사용자 확인
        if ($this->userModel->queryToResetPw($id, $name)) {
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

    // 비밀번호 초기화
    public function resetPassword()
    {
        $id = $_POST['id'] ?? null;
        $newPassword = $_POST['newPassword'] ?? null;

        // 비밀번호 업데이트
        if ($this->userModel->updatePassword($id, $newPassword)) {
            session_start();
            unset($_SESSION['pw_reset_user']);

            echo "<script>alert('비밀번호가 성공적으로 재설정되었습니다.'); location.href = '/views/user/login.php';</script>";
        } else {
            echo "<script>alert('비밀번호 재설정에 실패했습니다. 다시 시도해주세요.'); history.back();</script>";
        }
    }

    // 유저 활성화 관리
    public function setActivateUser()
    {
        $uid = $_GET['uid'];
        $activateStatus = $_GET['$activateStatus'];
        try {
            $success = $this->userModel->setActivateUser($uid, $activateStatus);
            if ($success) {
                header('Location: /views/admin/user_management.php');
            }
            exit;
        } catch (Exception $e) {
            error_log("UserController setActivateUser Error: " . $e->getMessage());
            echo "<script>alert('유저 활성화 상태 오류가 발생했습니다.'); history.go(0);</script>";
        }

    }
}

// 요청 처리
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller = new UserController();

    switch ($_POST['action']) {
        case 'register': $controller->register(); break;
        case 'requestFindId': $controller->requestFindId(); break;
        case 'requestPwReset': $controller->requestPwReset(); break;
        case 'resetPassword': $controller->resetPassword(); break;
        case 'modifyUserAddress': $controller->modifyUserAddress(); break;
        default: die ("유효하지 않는 요청입니다.");
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $controller = new UserController();

    if ($_GET['action'] === 'setActivateUser')
        $controller->setActivateUser();
}
?>
