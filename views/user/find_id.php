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
    <form class="needs-validation" method="POST" action="/controllers/UserController.php?action=find_id" novalidate>
        <div class="mt-5 d-flex flex-column justify-content-center">
            <div class="border-box">
                <div style="padding:24px; width: 100%;">
                    <div>
                        
                    </div>
                    <div class="has-validation">
                        <input type="text" class="form-control " name="name" id="nameValidation"
                               placeholder="이름"
                               required>
                        <div class="invalid-feedback">
                            이름을 입력해 주세요.
                        </div>
                    </div>
                    <div class="has-validation">
                        <input type="text" class="mt-4 form-control" name="phone" id="phoneValidation"
                               placeholder="전화번호" required>
                        <div class="invalid-feedback">
                            전화번호를 입력해 주세요.
                        </div>
                    </div>
                    <input class ="form-control" type="hidden" name="action" value="find_id">
                    <button type="submit" class="mt-5 btn btn-secondary" style="width: 100%;">아이디 찾기</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="../../public/js/user/login.js"></script>
<?php
include '../home/footer.php';
?>
</body>

</html>