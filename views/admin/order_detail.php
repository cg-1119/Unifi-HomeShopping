<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/OrderDetail.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Order.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';

$orderId = $_GET['order_id'] ?? null;

$orderDetailModel = new OrderDetail();
$orderModel = new Order();
$userModel = new User();

// 주문 정보 가져오기
$orderDetails = $orderDetailModel->getOrderDetailsByOrderId($orderId);
$order = $orderModel->getOrderById($orderId);
$user = $userModel->getUserByUid($order['user_id']);

// 총 금액
$totalPrice = 0;
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <title>주문 상세보기</title>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">주문 상세보기</h1>
    <a href="/views/admin/order_management.php" class="btn btn-secondary mb-3">뒤로 가기</a>

    <!-- 주문 기본 정보 -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>주문 정보</h5>
        </div>
        <div class="card-body">
            <p><strong>주문 번호:</strong> <?= htmlspecialchars($order['id']) ?></p>
            <p><strong>사용자 ID:</strong> <?= htmlspecialchars($user['id']) ?></p>
            <p><strong>주소:</strong> <?= htmlspecialchars($order['address']) ?></p>
            <p><strong>전화번호:</strong> <?= htmlspecialchars($order['phone']) ?></p>
            <p><strong>주문 날짜:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
            <!-- 배송 상태 변경 -->
            <form method="POST" action="/controllers/OrderController.php">
                <label for="delivery_status"><strong>배송 상태:</strong></label>
                <select name="delivery_status" id="delivery_status" class="form-select mb-3" onchange="this.form.submit()">
                    <option value="pending" <?= $order['delivery_status'] === 'pending' ? 'selected' : '' ?>>대기 중</option>
                    <option value="shipped" <?= $order['delivery_status'] === 'shipped' ? 'selected' : '' ?>>배송 중</option>
                    <option value="delivered" <?= $order['delivery_status'] === 'delivered' ? 'selected' : '' ?>>배송 완료</option>
                </select>
                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']) ?>">
                <input type="hidden" name="action" value="updateDeliveryStatus">
            </form>
        </div>
    </div>

    <!-- 주문 상세 정보 -->
    <div class="card">
        <div class="card-header">
            <h5>주문 상품 정보</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($orderDetails)): ?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>이미지</th>
                        <th>상품명</th>
                        <th>가격</th>
                        <th>수량</th>
                        <th>합계</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($orderDetails as $item): ?>
                        <?php $totalPrice += $item['price'] * $item['quantity']; ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars($item['product_image'] ?? '/default-thumbnail.jpg') ?>"
                                     alt="상품 이미지" style="width: 60px; height: 60px;">
                            </td>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td><?= number_format($item['price']) ?>원</td>
                            <td><?= htmlspecialchars($item['quantity']) ?>개</td>
                            <td><?= number_format($item['price'] * $item['quantity']) ?>원</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="text-end">
                    <strong>총 금액: <?= number_format($totalPrice) ?>원</strong>
                </div>
            <?php else: ?>
                <p>주문에 대한 상세 정보가 없습니다.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
