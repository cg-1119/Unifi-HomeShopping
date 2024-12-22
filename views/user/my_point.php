<?php
date_default_timezone_set('Asia/Seoul');
if (session_status() == PHP_SESSION_NONE)
    session_start();

if (!$_SESSION['user'])
    echo "<script>alert('로그인 후 사용 가능합니다.'); location.href ='../main/index.php';</script>";

$userId = $_SESSION['user']['uid'];

// 페이지네이션 설정
$currentPage = $_GET['page'] ?? 1;
$perPage = 10; // 한 페이지에 표시할 주문 수
$offset = ($currentPage - 1) * $perPage;

// 포인트 내역 추출
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Point.php';
$pointModel = new Point();

$points = $pointModel->getUserPointInfo($userId, $offset, $perPage);
$total = $pointModel->getTotalUserPointInfo($userId);

$totalPages = ceil($total / $perPage);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <title>포인트</title>
</head>
<body>
<div class="container mb-5">
    <h1 class="text-center">포인트 내역</h1>
    <!-- 포인트 내역 테이블 -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
            <tr class="text-center">
                <th>번호</th>
                <th>포인트 유형</th>
                <th>포인트</th>
                <th>주문 번호</th>
                <th>생성 날짜</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($points)): ?>
                <?php foreach ($points as $index => $point): ?>
                    <tr class="text-center">
                        <td><?= $offset + $index + 1 ?></td>
                        <td>
                            <?php
                            switch ($point['type']) {
                                case 'purchase': echo '상품 구매'; break;
                                case 'review': echo '리뷰 작성'; break;
                                case 'use': echo '포인트 사용'; break;
                                case 'cancel': echo '구매 취소'; break;
                                default: echo '기타'; break;
                            }
                            ?>
                        </td>
                        <td class="<?= $point['point'] >= 0 ? 'text-success' : 'text-danger' ?>">
                            <?= number_format($point['point']) ?> 원
                        </td>
                        <td><?= $point['order_id'] ?? '-' ?></td>
                        <td><?= htmlspecialchars($point['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">포인트 내역이 없습니다.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- 페이지 네비게이션 -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
</body>
</html>