<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

if(!$_SESSION['user']) {
    echo "<script>alert('로그인 후 사용 가능합니다.'); location.href ='/views/home/index.php';</script>";
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <title>수정</title>
</head>

<body>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/home/header.php';
?>
<div class="container">
    <div class="d-flex justify-content-center"><h2>수정</div>
    <a href="/views/user/mypage.php" class="btn btn-secondary mb-4">뒤로 가기</a>
    <form method="POST" action="/controllers/UserController.php" class="" novalidate>
        <div class="d-flex flex-column justify-content-center">
            <div class="border-box">
                <ul class="list-group">
                    <li class="list-group-item">
                        현재 배송지 : <?= htmlspecialchars($user['address'])?>
                    </li>
                    <li class="list-group-item">
                        <label class="form-label">새 배송지</label>
                        <input type="text" class="form-control" name="address" placeholder="배송지 입력">
                    </li>
                </ul>
            </div>
            <div class="box" style="width: 40%;">
                <input type="hidden" name="uid" value="<?= $user['uid']?>">
                <button class="btn btn-outline-secondary" type="submit" name="action" value="modifyUserAddress">변경하기</button>
            </div>
        </div>
    </form>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php';
?>
</body>

</html>