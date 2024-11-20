<!-- connect header.php -->
<script src="/public/js/user/validation.js" defer>
    function confirmLogout() {
        if (window.confirm('정말 로그아웃 하시겠습니까?')) window.location.href = '/controllers/LoginController.php?action=logout';
        else history.back();
    }
</script>
<link rel="stylesheet" href="/public/css/custom-style.css">

<header>
    <nav class="navbar navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container d-flex justify-content-end">
            <a class="navbar-brand mx-auto" href="/views/home/index.php" style="font-weight: bold;">Cg1119
                Homeshopping</a>
            <div class="d-flex gap-3">
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- 로그인 상태 -->
                    <span class="nav-link text-white">안녕하세요, <?php echo htmlspecialchars($_SESSION['user']['id']); ?>님!</span>
                    <a class="nav-link text-white" href="#" onclick="confirmLogout()">로그아웃</a>
                <?php else: ?>
                    <!-- 비로그인 상태 -->
                    <a class="nav-link text-white" href="/views/user/login.php">로그인</a>
                    <a class="nav-link text-white" href="/views/user/join/agree.php">회원가입</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>
