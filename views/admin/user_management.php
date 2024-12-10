<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';

$userModel = new User();

// 페이지네이션 설정
$currentPage = $_GET['page'] ?? 1;
$perPage = 10; // 한 페이지당 사용자 수
$offset = ($currentPage - 1) * $perPage;

// 사용자 목록 가져오기
$isActive = $_GET['is_active'] ?? null;
$users = $userModel->getAllUsers($offset, $perPage, $isActive);
$totalUsers = $userModel->getTotalUserCount();

$totalPages = ceil($totalUsers / $perPage);
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
                <select name="is_active" class="form-select me-4">
                    <option value="">전체 사용자</option>
                    <option value="1" <?= $isActive === '1' ? 'selected' : '' ?>>활성 사용자</option>
                    <option value="0" <?= $isActive === '0' ? 'selected' : '' ?>>비활성 사용자</option>
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
                    <td><?= $user['is_active'] ? '<span class="text-success">활성</span>' : '<span class="text-danger">비활성</span>' ?></td>
                    <td>
                        <?php if ($user['is_active']): ?>
                            <a href="/controllers/UserController.php?action=deactivateUser&uid=<?= $user['uid'] ?>" class="btn btn-warning btn-sm" onclick="return confirm('이 사용자를 비활성화 하시겠습니까?')">비활성화</a>
                        <?php else: ?>
                            <span class="text-muted">비활성화됨</span>
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
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&is_active=<?= htmlspecialchars($isActive) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
</body>
</html>
