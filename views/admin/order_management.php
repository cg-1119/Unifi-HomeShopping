<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Order.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';

$orderModel = new Order();
$userModel = new User();

// 페이지네이션 설정
$currentPage = $_GET['page'] ?? 1;
$perPage = 10; // 한 페이지에 표시할 주문 수
$offset = ($currentPage - 1) * $perPage;

// 검색 정보 조회
$delivery_status = $_GET['delivery_status'] ?? '';

if (!$delivery_status) {
    $orders = $orderModel->getAllOrders($offset, $perPage);
    $totalOrders = $orderModel->getTotalOrderCount();
} else {
    $orders = $orderModel->getOrdersByDeliveryStatus($delivery_status, $offset, $perPage);
    $totalOrders = $orderModel->getTotalOrderCountByDeliveryStatus($delivery_status);
}

$totalPages = ceil($totalOrders / $perPage);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>주문 관리</title>
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">주문 관리</h1>
    <div class="d-flex justify-content-between">
        <a href="index.php" class="btn btn-secondary mb-4">뒤로 가기</a>
        <a href="/views/admin/canceled_order_management.php" class="btn btn-danger mb-4">취소된 주문 관리</a>
    </div>
    <!-- 검색 폼 -->
    <form method="GET" action="order_management.php" class="mb-4">
        <div class="row d-flex justify-content-center">
            <div class="col-md-4 d-flex align-items-center">
                <select name="delivery_status" class="form-select me-4">
                    <option value="">전체 상태</option>
                    <option value="pending" <?= $delivery_status === 'pending' ? 'selected' : '' ?>>대기 중</option>
                    <option value="shipped" <?= $delivery_status === 'shipped' ? 'selected' : '' ?>>배송 중</option>
                    <option value="delivered" <?= $delivery_status === 'delivered' ? 'selected' : '' ?>>배송 완료</option>
                </select>
                <button type="submit" class="btn btn-primary col-2">검색</button>
            </div>
        </div>
    </form>

    <!-- 주문 목록 테이블 -->
    <h5>전체 주문</h5>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>주문 번호</th>
            <th>사용자 ID</th>
            <th>주문 날짜</th>
            <th>배송 상태</th>
            <th>총 금액</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']) ?></td>
                    <td><?= htmlspecialchars($userModel->getUserByUid($order['user_id'])['id']) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                    <td>
                        <?= htmlspecialchars($order['delivery_status'] === 'pending' ? '대기 중' : ($order['delivery_status'] === 'shipped' ? '배송 중' : '배송 완료')) ?>
                    </td>
                    <td><?= number_format($order['total_price']) ?>원</td>
                    <td>
                        <a href="/views/admin/order_detail.php?order_id=<?= $order['id'] ?>" class="btn btn-info btn-sm">상세 보기</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">주문 내역이 없습니다.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- 페이지 네비게이션 -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&delivery_status=<?= htmlspecialchars($delivery_status) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
</body>
</html>
