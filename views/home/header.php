<?php
if (session_id() == '') {
    session_start();
    $user = $_SESSION['user'] ?? null;
}
?>
<!-- connect header.php -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="/public/js/bootstrap.bundle.js"></script>
<script src="/public/js/custom/cart.js"></script>
<header>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="nav-link" href="/views/home/index.php" style="font-weight: bold;">Cg1119</a>
            <div class="d-flex gap-3 align-items-center">
                <?php if (isset($_SESSION['user'])): ?>
                    <?php if ($_SESSION['user']['is_admin'] == 1): ?>
                        <!-- 관리자 로그인 -->
                        <span class="nav-link">안녕하세요 관리자님!</span>
                        <a href="/views/admin/index.php" class="nav-link">관리자 페이지</a>
                        <a href="#" id="logout-link" class="nav-link">로그아웃</a>
                    <?php else: ?>
                        <!-- 일반 사용자 로그인 -->
                        <div class="dropdown-item-text">환영합니다! <?php echo $_SESSION['user']['id'] ?>님</div>
                        <div class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle" style="font-size: 24px;"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="/controllers/OrderController.php?action=myPage">마이페이지</a></li>
                                <li><a class="dropdown-item" href="/views/user/cart/index.php" onclick="updateCart()">장바구니</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" id="logout-link">로그아웃</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- 비로그인 상태 -->
                    <div class="dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle" style="font-size: 24px;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="/views/user/login.php">로그인</a></li>
                            <li><a class="dropdown-item" href="/views/user/cart/index.php" onclick="updateCart()">장바구니</a></li>
                            <li><a class="dropdown-item" href="/views/user/join/agree.php">회원가입</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<script>
    document.getElementById('logout-link').addEventListener('click', function (event) {
        event.preventDefault();

        const confirmLogout = confirm("정말 로그아웃 하시겠습니까?");
        if (confirmLogout) {
            // 로그아웃 POST 요청
            fetch('/controllers/LoginController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'action': 'logout'
                })
            })
                .then(response => {
                    if (response.ok) {
                        location.href = '/views/home/index';
                    } else {
                        alert("로그아웃 처리에 실패했습니다. 다시 시도해주세요.");
                    }
                })
                .catch(error => {
                    console.error('로그아웃 요청 오류:', error);
                    alert("로그아웃 중 오류가 발생했습니다. 다시 시도해주세요.");
                });
        }
    });
</script>
