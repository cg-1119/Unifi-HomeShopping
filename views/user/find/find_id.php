<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>아이디 찾기</title>
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
</head>

<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/main/header.php'; ?>
<div class="container">
    <form class="needs-validation" method="POST" action="/controllers/UserController.php" novalidate>
        <div class="mt-5 d-flex flex-column justify-content-center">
            <div class="border-box">
                <div style="padding:24px; width: 100%;">
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
                    <input class ="form-control" type="hidden" name="action" value="requestFindId">
                    <button type="submit" class="mt-5 btn btn-secondary" style="width: 100%;">아이디 찾기</button>
                </div>
            </div>
            <div class="d-flex justify-content-center" style="width: 100%">
                <a class="nav-link text-secondary" href="find_pw.php">비밀번호 찾기</a>
            </div>
        </div>
    </form>
</div>

<script src="/public/js/custom/validation.js"></script>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/main/footer.php';
?>
</body>

</html>