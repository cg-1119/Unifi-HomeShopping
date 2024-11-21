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
<header>
    <div class="d-flex justify-content-center m-5">
        <a class="navbar-brand mx-auto text-decoration-none text-white bg-dark py-2 px-4 rounded"
           href="/views/home/index.php"
           style="font-size: 1.5rem; font-weight: bold;">
            Cg1119 HomeShopping
        </a>
    </div>
</header>
<div class="container">
    <form class="needs-validation" method="POST" action="/controllers/LoginController.php" novalidate>
        <div class="mt-5 d-flex flex-column justify-content-center">
            <div class="border-box">
                <div style="padding:24px; width: 100%;">
                    <div class="has-validation">
                        <input type="text" class="form-control " name="id" id="idValidation"
                               placeholder="ID"
                               required>
                        <div class="invalid-feedback">
                            아이디를 입력해 주세요.
                        </div>
                    </div>
                    <div class="has-validation">
                        <input type="password" class="mt-4 form-control" name="password" id="pwValidation"
                               placeholder="비밀번호" required>
                        <div class="invalid-feedback">
                            비밀번호를 입력해 주세요.
                        </div>
                    </div>
                    <input class ="form-control" type="hidden" name="action" value="login">
                    <button type="submit" class="mt-5 btn btn-secondary" style="width: 100%;">로그인</button>
                </div>
            </div>
        </div>
    </form>
    <div class="mt-2 d-flex justify-content-center" style="width: 100%">
        <a class="nav-link text-secondary" href="join/agree.php">회원가입</a>
        <span class="link-border"></span>
        <a class="nav-link text-secondary" href="find/find_id.php">아이디 찾기</a>
        <span class="link-border"></span>
        <a class="nav-link text-secondary" href="find/find_pw.php">비밀번호 찾기</a>
    </div>
</div>

<script src="../../public/js/user/validation.js"></script>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php';
?>
</body>

</html>