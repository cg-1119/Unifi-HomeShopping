<?php
session_start();

$pwResetUser = isset($_SESSION['pw_reset_user']) ? $_SESSION['pw_reset_user'] : null;

if (!$pwResetUser || $pwResetUser['status'] !== 'success') {
    echo "<script>alert('잘못된 접근입니다.'); location.href = '/views/custom/find_pw.php';</script>";
    exit;
}
$id = $pwResetUser['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <title>비밀번호 재설정</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/main/header.php'; ?>
<div class="container">
    <div class="mt-5 d-flex flex-column justify-content-center">
        <div class="border-box">
            <div style="padding:24px; width: 100%;">
                <form class="needs-validation" action="/controllers/UserController.php" method="POST" novalidate>
                    <div><?php echo htmlspecialchars($id); ?>님의 비밀번호 재설정</div>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <label for="pwValidation" class="form-label"></label>
                    <input type="password" name="newPassword" class="form-control" id="pwValidation"
                           aria-describedby="pwValidationFeedback" placeholder="비밀번호" required>
                    <div id="pwValidationFeedback" class="invalid-feedback">비밀번호를 입력하세요.</div>
                    <label for="pwCheckValidation" class="form-label"></label>
                    <input type="password" class="form-control" id="pwCheckValidation"
                           aria-describedby="pwCheckValidationFeedback" placeholder="비밀번호 재입력" required>
                    <div id="pwCheckValidationFeedback" class="invalid-feedback">비밀번호를 입력하세요.</div>
                    <input type="hidden" name="action" value="resetPassword">
                    <button type="submit" class="mt-5 btn btn-secondary" style="width: 100%;">비밀번호 재설정</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/main/footer.php';
?>
<script src="/public/js/custom/inputValidation.js"></script>
</body>
</html>
