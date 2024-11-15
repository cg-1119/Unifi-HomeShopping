<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
</head>

<body>
<div class="d-flex justify-content-center m-5">
    <a class="navbar-brand mx-auto text-decoration-none text-white bg-dark py-2 px-4 rounded"
       href="/views/home/index.php"
       style="font-size: 1.5rem; font-weight: bold;">
        Cg1119 HomeShopping
    </a>
</div>
<div class="d-flex justify-content-center border-box">
    <div style="padding:24px; width: 100%;">
        <form class="needs-validation" method="POST" novalidate>
            <div class="has-validation">
                <input type="text" class="mb-4 form-control " name="username" id="nameValidation" placeholder="ID" required>
                <div class="invalid-feedback">
                    이름을 입력해 주세요.
                </div>
            </div>
            <div class="has-validation">
                <input type="password" class="mb-4 form-control" name="password" id="psValidation" placeholder="비밀번호" required>
                <div class="invalid-feedback">
                    비밀번호를 입력해 주세요.
                </div>
            </div>
            <input type="submit" class="form-control" value="로그인">
        </form>
        <div class="mt-2 d-flex justify-content-center" style="width: 100%">
            <a class="nav-link text-secondary" href="join/agree.php">회원가입</a>
            <span class="link-border"></span>
            <a class="nav-link text-secondary" href="#">아이디 찾기</a>
            <span class="link-border"></span>
            <a class="nav-link text-secondary" href="#">비밀번호 찾기</a>
        </div>
    </div>
</div>


<?php
include '../home/footer.php';
?>
</body>

</html>