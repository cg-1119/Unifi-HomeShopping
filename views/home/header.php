<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>
<!-- connect header.php -->
<link rel="stylesheet" href="/public/css/custom-style.css">

<header>
    <nav class="navbar navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container d-flex justify-content-end">
            <a class="navbar-brand mx-auto" href="/views/home/index.php" style="font-weight: bold;">Cg1119
                Homeshopping</a>
            <div class="d-flex gap-3">
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- 로그인 상태 -->
                    <span class="nav-link text-white">안녕하세요, <?php echo htmlspecialchars($user['id']); ?>님!</span>
                    <a href="#" id="logout-link" class="nav-link text-white">로그아웃</a>
                <?php else: ?>
                    <!-- 비로그인 상태 -->
                    <a class="nav-link text-white" href="/views/user/login.php">로그인</a>
                    <a class="nav-link text-white" href="/views/user/join/agree.php">회원가입</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<script>
    document.getElementById('logout-link').addEventListener('click', function(event) {
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
                        // 로그아웃 후 메인 페이지로 리다이렉트
                        window.location.href = '/views/home/index.php';
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
