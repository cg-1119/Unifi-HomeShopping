<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Seoul');

session_start();
if (!$_SESSION['user']) {
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

    <h5 class="mb-4">내 정보</h5>
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <p class="card-text"><strong>안녕하세요 <?= $user['id'] ?>님</strong><br></p>
                <p><strong>보유 포인트: <?php echo number_format($point); ?>원</strong></p>
            </div>
            <a href="/views/user/setting.php" class="btn btn-secondary">기본 배송지 수정</a>
        </div>
    </div>

    <h5 class="card-title mb-4">찜한 목록</h5>
    <div class="card mb-4">
        <div class="card-body">
            <ul class="list-group">
                미구현
            </ul>
        </div>
    </div>

    <h5 class="card-title mb-4">주문 내역</h5>
    <div class="card mb-4">
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <h6>주문 번호: <?= htmlspecialchars($order['id']) ?></h6>
                            <p>주문 날짜: <?= date('Y년 m월 d일', strtotime($order['order_date'])) ?></p>
                            <a href="/views/user/my_orders.php?order_id=<?= htmlspecialchars($order['id']) ?>"
                               style="text-decoration: none; color: inherit;">
                                <p class="<?= $order['status'] === 'cancelled' ? 'text-danger' : 'text-primary' ?>">
                                    <?php
                                    if ($order['status'] === 'cancelled') {
                                        echo '주문 취소';
                                    } else {
                                        switch ($order['delivery_status']) {
                                            case 'pending':
                                                echo '배송 대기 중';
                                                break;
                                            case 'shipped':
                                                echo '배송 중';
                                                break;
                                            case 'delivered':
                                                echo '배송 완료';
                                                break;
                                            default:
                                                echo '알 수 없음';
                                                break;
                                        }
                                    }
                                    ?>
                                </p>
                                <p class="text-success">상세보기 ></p></a>
                        </li>
                        <?php foreach ($order['details'] as $detail): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex">
                                    <img src="<?= htmlspecialchars($detail['product_image'] ?? '/default-thumbnail.jpg') ?>"
                                         alt="상품 이미지" style="width: 60px; height: 60px; margin-right: 10px;">
                                    <div>
                                        <p><?= htmlspecialchars($detail['product_name']) ?></p>
                                        <p><?= number_format($detail['price']) ?>원
                                            x <?= htmlspecialchars($detail['quantity']) ?>개</p>
                                    </div>
                                </div>
                                <span><?= number_format($detail['price'] * $detail['quantity']) ?>원</span>
                            </li>
                        <?php endforeach; ?>
                        <li class="list-group-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <?php if ($order['delivery_status'] === 'pending' && $order['status'] === 'completed'): ?>
                                    <button
                                            type="button"
                                            class="btn btn-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#cancelOrderModal"
                                            onclick="setOrderId(<?= htmlspecialchars($order['id']) ?>)">
                                        주문 취소
                                    </button>
                                <?php endif; ?>
                                <strong class="ms-auto">총 금액: <?= number_format(array_sum(array_map(function ($item) {
                                        return $item['price'] * $item['quantity'];
                                    }, $order['details']))) ?>원
                                </strong>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>주문 내역이 없습니다.</p>
        <?php endif; ?>
    </div>
</div>
<!-- 주문 취소 확인 모달 -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <form method="POST" action="/controllers/OrderController.php" id="cancelOrderForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelOrderModalLabel">주문 취소 확인</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>취소 사유를 선택하세요:</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cancel_reason" id="reasonChangeMind"
                               value="change_of_mind" required>
                        <label class="form-check-label" for="reasonChangeMind">단순 변심</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cancel_reason" id="reasonWrongPurchase"
                               value="wrong_purchase" required>
                        <label class="form-check-label" for="reasonWrongPurchase">잘못 구매함</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cancel_reason" id="reasonAddItems"
                               value="add_more_items" required>
                        <label class="form-check-label" for="reasonAddItems">상품을 더 추가하고 구매 예정</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cancel_reason" id="reasonOther" value="other"
                               required>
                        <label class="form-check-label" for="reasonOther">기타</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="order_id" id="modalOrderId">
                    <input type="hidden" name="action" value="cancelOrder">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                    <button type="submit" class="btn btn-danger">확인</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php'; ?>
</body>
<script>
    function setOrderId(orderId) {
        document.getElementById('modalOrderId').value = orderId;
    }
</script>
</html>

