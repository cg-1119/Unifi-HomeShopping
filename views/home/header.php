<!-- views/home/header.php -->
<style>
    .navbar {
        position: relative;
    }

    .navbar-brand {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }
</style>
<header>
    <nav class="navbar navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container d-flex justify-content-end">
            <a class="w-100 text-center navbar-brand" href="/views/home/index.php">쇼핑몰</a>
            <div class="d-flex gap-3">
                <a class="nav-link text-white" href="#">로그인</a>
                <a class="nav-link text-white" href="#">회원가입</a>
            </div>
        </div>
    </nav>
</header>