<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/OrderDetail.php';

$orderDetailModel = new Orderdetail();

$orderId = $_GET['orderId'] ?? null;
if (!$orderId) {
    echo "<script>alert('유효하지 않은 접근입니다.'); location.href = '../main/index.php';</script>";
    exit;
}

// 주문 상세 정보 가져오기
$orderDetails = $orderDetailModel->getOrderDetailsByOrderId($orderId);
$totalPrice = 0;
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>결제 완료</title>
    <link rel="stylesheet" href="/public/css/bootstrap.css">
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/main/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">결제가 성공적으로 완료되었습니다!</h1>
    <p class="text-center">주문 번호: <?= htmlspecialchars($orderId) ?></p>

    <!-- 주문 상품 정보 -->
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>상품명</th>
            <th>가격</th>
            <th>수량</th>
            <th>합계</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orderDetails as $item): ?>
            <?php
            // 데이터 매핑 및 기본값 설정
            $productImage = isset($item['product_image']) ? $item['product_image'] : '/default-thumbnail.jpg'; // 기본 이미지
            $productName = isset($item['product_name']) ? $item['product_name'] : '알 수 없는 상품';
            $price = isset($item['price']) ? $item['price'] : 0;
            $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
            ?>
            <tr>
                <td><img src="<?php echo htmlspecialchars($productImage); ?>" alt="썸네일"
                         style="width: 60px; height: 60px;"></td>
                <td><?php echo htmlspecialchars($productName); ?></td>
                <td><?php echo number_format($price); ?>원</td>
                <td><?php echo htmlspecialchars($quantity); ?>개</td>
                <td><?php echo number_format($price * $quantity); ?>원</td>
            </tr>
        <?php $totalPrice += $price * $quantity?>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <p>최종 결제 금액: <strong class="text-success" id="finalPrice"><?= number_format($totalPrice) ?> 원</strong></p>
    </div>
    <div class="text-center mt-5">
        <a href="/views/main/index.php" class="btn btn-primary">홈으로 돌아가기</a>
        <a href="/views/user/mypage.php" class="btn btn-secondary">주문 내역 보기</a>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/main/footer.php'; ?>
</body>
</html>
