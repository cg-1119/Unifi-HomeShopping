<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';

$userModel = new User();

// 페이지네이션 설정
$currentPage = $_GET['page'] ?? 1;
$range = 10; // 한 페이지당 사용자 수
$offset = ($currentPage - 1) * $range;

// 사용자 목록 가져오기
$activateStatus = $_GET['activate_status'] ?? '';
if (!$activateStatus) {
    $users = $userModel->getAllUsers($offset, $range);
    $totalUsers = $userModel->getTotalUserCount();
} else {
    $users = $userModel->getActivateStatusUsers($offset, $range, $activateStatus);
    $totalUsers = $userModel->getTotalActivateStatusUserCount($activateStatus);
}
$totalPages = ceil($totalUsers / $range);

$startPage = floor(($currentPage - 1) / $range) * $range + 1;
$endPage = min($startPage + $range - 1, $totalPages);
$prevRange = $startPage - 1;
$nextRange = $endPage + 1;
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>사용자 관리</title>
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">사용자 관리</h1>
    <a href="/views/admin/index.php" class="btn btn-secondary mb-4">뒤로 가기</a>

    <!-- 검색 폼 -->
    <form method="GET" action="user_management.php" class="mb-4">
        <div class="row d-flex justify-content-center">
            <div class="col-md-4 d-flex align-items-center">
                <select name="activate_status" class="form-select me-4">
                    <option value="">전체 사용자</option>
                    <option value="activate" <?= $activateStatus === 'activate' ? 'selected' : '' ?>>활성 사용자</option>
                    <option value="deactivate" <?= $activateStatus === 'deactivate' ? 'selected' : '' ?>>비활성 사용자</option>
                </select>
                <button type="submit" class="btn btn-primary col-2">검색</button>
            </div>
        </div>
    </form>

    <!-- 사용자 목록 테이블 -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>UID</th>
            <th>아이디</th>
            <th>이름</th>
            <th>이메일</th>
            <th>전화번호</th>
            <th>포인트</th>
            <th>상태</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user):
                if(!$user['point']) $user['point'] = 0?>
                <tr>
                    <td><?= htmlspecialchars($user['uid']) ?></td>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone']) ?></td>
                    <td><?= number_format($user['point']) ?> P</td>
                    <td><?= $user['activate_status'] == 'activate' ? '<span class="text-success">활성</span>' : '<span class="text-danger">비활성</span>' ?></td>
                    <td>
                        <?php if ($user['activate_status'] == 'activate'): ?>
                            <a href="/controllers/UserController.php?action=setActivateUser&uid=<?= $user['uid'] ?>&$activateStatus=deactivate" class="btn btn-secondary btn-sm" onclick="return confirm('이 사용자를 비활성화 하시겠습니까?')">비활성화</a>
                        <?php else: ?>
                            <a href="/controllers/UserController.php?action=setActivateUser&uid=<?= $user['uid'] ?>&$activateStatus=activate" class="btn btn-primary btn-sm" onclick="return confirm('이 사용자를 활성화 하시겠습니까?')">활성화</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">사용자가 없습니다.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- 페이지 네비게이션 -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $startPage > 1 ? '' : 'disabled' ?>">
                <a class="page-link" href="?page=<?= max(1, $prevRange) ?>activate_status=<?= htmlspecialchars($activateStatus) ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&activate_status=<?= htmlspecialchars($activateStatus) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $endPage < $totalPages ? '' : 'disabled' ?>">
                <a class="page-link" href="?page=<?= min($totalPages, $nextRange) ?>&activate_status=<?= htmlspecialchars($activateStatus) ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
</body>
</html>
