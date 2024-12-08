<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Order.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';

$orderModel = new Order();
$userModel = new User();

// 취소 사유 매핑
$cancelReason = [
    'change_of_mind' => '단순 변심',
    'wrong_purchase' => '잘못 구매함',
    'add_more_items' => '상품 추가 후 구매 예정',
    'other' => '기타',
];

// 검색 조건
$isProcessed = $_GET['is_processed'] ?? null;

// 페이지네이션 설정
$currentPage = $_GET['page'] ?? 1;
$perPage = 10;
$offset = ($currentPage - 1) * $perPage;

// 취소된 주문 가져오기
$canceledOrders = $orderModel->getCanceledOrders($offset, $perPage, $isProcessed);
$totalCanceledOrders = $orderModel->getTotalCanceledOrderCount($isProcessed);

$totalPages = ceil($totalCanceledOrders / $perPage);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>취소된 주문 관리</title>
    <link rel="stylesheet" href="/public/css/bootstrap.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">취소된 주문 관리</h1>
    <a href="/views/admin/order_management.php" class="btn btn-secondary mb-4">주문 관리로 돌아가기</a>
    <!-- 검색 폼 -->
    <form method="GET" action="canceled_order_management.php" class="mb-4">
        <div class="row d-flex justify-content-center">
            <div class="col-md-4 d-flex align-items-center">
                <select name="is_processed" class="form-select me-4">
                    <option value="">처리 상태 전체</option>
                    <option value="0" <?= $isProcessed === '0' ? 'selected' : '' ?>>처리되지 않음</option>
                    <option value="1" <?= $isProcessed === '1' ? 'selected' : '' ?>>처리 완료</option>
                </select>
                <button type="submit" class="btn btn-primary col-2">검색</button>
            </div>
        </div>
    </form>

    <!-- 취소된 주문 목록 테이블 -->
    <table class="table table-bordered table-striped">
        <thead class="table-danger">
        <tr>
            <th>주문 번호</th>
            <th>사용자 ID</th>
            <th>주문 날짜</th>
            <th>총 금액</th>
            <th>취소 이유</th>
            <th>처리 상태</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($canceledOrders)): ?>
            <?php foreach ($canceledOrders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']) ?></td>
                    <td><?= htmlspecialchars($userModel->getUserByUid($order['user_id'])['id']) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                    <td><?= number_format($order['total_price']) ?>원</td>
                    <td><?= htmlspecialchars($cancelReason[$order['cancel_reason']] ?? '없음') ?></td>
                    <td><?= $order['is_cancelled_by_admin'] ? '<span class="text-success">처리 완료</span>' : '<span class="text-danger">미처리</span>' ?></td>
                    <td>
                        <a href="/views/admin/canceled_order_detail.php?order_id=<?= $order['id'] ?>" class="btn btn-info btn-sm">상세 보기</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">취소된 주문 내역이 없습니다.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- 페이지 네비게이션 -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&is_processed=<?= htmlspecialchars($isProcessed) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
</body>
</html>
