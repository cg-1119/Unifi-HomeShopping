<?php
session_start();
date_default_timezone_set('Asia/Seoul');
if (!isset($_SESSION['user'])) {
    header('Location: /views/user/login.php');
    exit;
}

// 주문 정보
foreach ($_SESSION['orders'] as $order) {
    if ($order['id'] === (int)$_GET['order_id']) {
        $orderDetails = $order;
    }
}
if (!isset($orderDetails)) {
    echo "<script>alert('유효하지 않은 접근입니다.'); location.href='/views/user/mypage.php';</script>";
    exit;
}
$totalPrice = 0;

// 결제 정보
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Payment.php';
$paymentModel = new Payment();
$payment = $paymentModel->getPaymentByOrderId($orderDetails['id']);


// 배송 상태 함수
function renderDeliveryStatus($currentStatus) {
    $statuses = [
        'pending' => ['icon' => 'bi-calendar2-event-fill', 'label' => '대기 중'],
        'shipped' => ['icon' => 'bi-truck', 'label' => '배송 중'],
        'delivered' => ['icon' => 'bi-check-circle-fill', 'label' => '배송 완료']
    ];

    $output = '<div class="d-flex justify-content-around align-items-center">';

    foreach ($statuses as $status => $data) {
        $isActive = ($status === $currentStatus);
        $color = $isActive ? 'color: green;' : 'color: gray;';
        $output .= '
            <div class="text-center">
                <i class="bi ' . $data['icon'] . '" style="font-size: 2rem; ' . $color . '"></i>
                <p>' . $data['label'] . '</p>
            </div>
        ';

        // 상태 사이에 선 추가 (마지막 아이콘 제외)
        if ($status !== 'delivered') {
            $output .= '<div style= "width: 100px; height: 2px; background-color: ' . ($isActive ? 'green' : 'gray') . '; position: relative; top: -20px;"></div>';
        }
    }

    $output .= '</div>';
    return $output;
}
// 리뷰 확인
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/ProductReview.php';
$productReview = new ProductReview();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <title>주문 상세 정보</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/main/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center m-5">주문 상세 정보</h2>

    <!-- 주문 상품 정보 -->
    <ul class="list-group">
        <?php foreach ($orderDetails['details'] as $detail):
            $price = $detail['price'] * $detail['quantity'];
            $totalPrice += $price ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="/views/product/detail.php?id=<?= htmlspecialchars($detail['product_id']) ?>"
                   style="text-decoration: none; color: inherit;">
                    <div class="d-flex">
                        <img src="<?= htmlspecialchars($detail['product_image'] ?? '/default-thumbnail.jpg') ?>"
                             alt="상품 이미지" style="width: 80px; height: 80px; margin-right: 20px;">
                        <div>
                            <h6><?= htmlspecialchars($detail['product_name']) ?></h6>
                            <p>가격: <?= number_format($detail['price']) ?>원</p>
                            <p>수량: <?= htmlspecialchars($detail['quantity']) ?>개</p>
                        </div>
                    </div>
                </a>
                <strong><?= number_format($price) ?>원</strong>
            </li>
            <?php if ($orderDetails['delivery_status'] === 'delivered'): ?>

            <?php $hasReviewed = $productReview->hasUserReviewedProduct($detail['product_id'], $_SESSION['user']['uid']);?>

            <?php if (!$hasReviewed): ?>
                <li class="list-group-item">
                    <a href="javascript:void(0);"
                       onclick="openReviewWindow('<?= htmlspecialchars($detail['product_id'])?>', '<?= htmlspecialchars($_SESSION['user']['uid'])?>');">
                        <button type="button" class="btn btn-success btn-sm">리뷰 작성</button>
                    </a>
                </li>
            <?php endif ?>
        <?php endif ?>
        <?php endforeach; ?>
    </ul>
    <p style="text-align-last: end">총 금액: <strong class="text-success" id="finalPrice"><?= number_format($totalPrice) ?>
            원</strong></p>

    <!-- 결제 정보 -->
    <div class="card mt-4 mb-4">
        <div class="card-header">
            <h5>결제 정보</h5>
        </div>
        <div class="card-body">
            <p><strong>결제 방법:</strong> <?= htmlspecialchars($payment['payment_method'] ?? '정보 없음') ?></p>
            <p><strong>결제 금액:</strong> <?= number_format($payment['payment_price'] ?? 0) ?>원</p>
            <p><strong>결제 날짜:</strong> <?= date('Y년 m월 d일', strtotime($payment['payment_date'])) ?></p>
        </div>
    </div>

    <!-- 배송 상태 -->
    <?php if ($orderDetails['status'] !== 'cancelled'): ?>
        <div class="mt-4">
            <h2 class="text-center">배송 상태</h2>
            <div class="d-flex justify-content-around">
                <?= renderDeliveryStatus($orderDetails['delivery_status']) ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="text-center mt-5">
        <a href="/views/user/mypage.php" class="btn btn-primary">마이페이지로 돌아가기</a>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/main/footer.php'; ?>
</body>
<script>
    function openReviewWindow(productId, userId) {
        // 새 창 열기
        const reviewWindow = window.open(
            `add_review.php?product_id=${productId}&user_id=${userId}`,
            'ReviewWindow',
            'width=400,height=600,resizable=no,scrollbars=yes'
        );

        // 일정 간격으로 새 창 상태를 확인
        const interval = setInterval(() => {
            if (reviewWindow.closed) {
                clearInterval(interval); // Interval 제거
                location.reload(); // 페이지 새로고침
            }
        }, 500); // 500ms 간격으로 확인
    }
</script>
</html>
