<?php
header('Content-Type: text/html; charset=utf-8');

session_start();
if(!$_SESSION['user']) {
    echo "<script>alert('로그인 후 사용 가능합니다.'); location.href ='/views/home/index.php';</script>";
}
$user = $_SESSION['user'];
$point = $user['point'] ?? 0;

$orders = $_SESSION['orders'];
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
                <p><strong>보유 포인트: <?php echo number_format($point); ?>원</strong></p>
            </div>
            <a href="/views/user/setting.php"  class="btn btn-secondary">기본 배송지 수정</a>
        </div>
    </div>

    <h5 class="card-title">찜한 목록</h5>
    <div class="card mb-4">
        <div class="card-body">
            <ul class="list-group">
                미구현
            </ul>
        </div>
    </div>

    <h5 class="card-title">주문 내역</h5>
    <div class="card mb-4">
        <div class="card-body">
    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <h6>주문 번호: <?= htmlspecialchars($order['id']) ?></h6>
                            <p>주문 날짜: <?= htmlspecialchars($order['order_date']) ?></p>
                        </li>
                        <?php foreach ($order['details'] as $detail): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex">
                                    <img src="<?= htmlspecialchars($detail['product_image'] ?? '/default-thumbnail.jpg') ?>"
                                         alt="상품 이미지" style="width: 60px; height: 60px; margin-right: 10px;">
                                    <div>
                                        <p><?= htmlspecialchars($detail['product_name']) ?></p>
                                        <p><?= number_format($detail['price']) ?>원 x <?= htmlspecialchars($detail['quantity']) ?>개</p>
                                    </div>
                                </div>
                                <span><?= number_format($detail['price'] * $detail['quantity']) ?>원</span>
                            </li>
                        <?php endforeach; ?>
                        <li class="list-group-item mb-3">
                            <div class="text-end mb-3">
                                <strong>총 금액: <?= number_format(array_sum(array_map(function($item) {
                                        return $item['price'] * $item['quantity'];
                                    }, $order['details']))) ?>원</strong>
                            </div>
                        </li>
                    </ul>
        <?php endforeach; ?>
    <?php else: ?>
        <p>주문 내역이 없습니다.</p>
    <?php endif; ?>
        </div>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php'; ?>
</body>
</html>

