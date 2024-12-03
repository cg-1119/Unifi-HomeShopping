<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

if(!$_SESSION['user']) {
    echo "<script>alert('로그인 후 사용 가능합니다.'); location.href ='/views/home/index.php';</script>";
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <title>마이 페이지</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">마이 페이지</h2>

    <h5 class="mb-2">내 정보</h5>
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <p class="card-text"><strong>안녕하세요 <?=$user['id']?>님</strong><br></p>
                <p><strong>보유 포인트: <?php echo number_format($user['point']); ?>원</strong></p>
            </div>
            <a href="/views/user/setting.php"  class="btn btn-secondary">기본 배송지 수정</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">찜한 목록</h5>
            <ul class="list-group">
                <!-- 예시 데이터 -->
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    상품 A
                    <span class="badge bg-primary rounded-pill">₩50,000</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php'; ?>
</body>
</html>

