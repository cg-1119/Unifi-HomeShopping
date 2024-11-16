<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>회원가입 정보 입력</title>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center m-5">
        <a class="navbar-brand mx-auto text-decoration-none text-white bg-dark py-2 px-4 rounded"
           href="/views/home/index.php"
           style="font-size: 1.5rem; font-weight: bold;">
            Cg1119 HomeShopping
        </a>
    </div>
    <form method="POST" action="/controllers/UsersController.php" class="needs-validation" novalidate>
        <div class="mt-5 d-flex flex-column justify-content-center">
            <div class="box">
                <ul class="list-group">
                    <!-- ID -->
                    <li class="list-group mb-3">
                        <label for="idValidation" class="form-label"></label>
                        <input type="text" name="id" class="form-control" id="idValidation"
                               aria-describedby="idValidationFeedback" placeholder="아이디" required>
                        <div id="idValidationFeedback" class="invalid-feedback">아이디를 입력하세요.</div>
                    </li>
                    <!-- Password -->
                    <li class="list-group mb-3">
                        <label for="pwValidation" class="form-label"></label>
                        <input type="password" name="pw" class="form-control" id="pwValidation"
                               aria-describedby="pwValidationFeedback" placeholder="비밀번호" required>
                        <div id="pwValidationFeedback" class="invalid-feedback">비밀번호를 입력하세요.</div>
                    </li>
                    <!-- PasswordCheck -->
                    <li class="list-group mb-3">
                        <label for="pwCheckValidation" class="form-label"></label>
                        <input type="password" class="form-control" id="pwCheckValidation"
                               aria-describedby="pwCheckValidationFeedback" placeholder="비밀번호 재입력" required>
                        <div id="pwCheckValidationFeedback" class="invalid-feedback">비밀번호를 입력하세요.</div>
                    </li>
                    <!-- Name -->
                    <li class="list-group mb-3">
                        <label for="nameValidation" class="form-label"></label>
                        <input type="text" name="name" class="form-control" id="nameValidation"
                               aria-describedby="nameValidationFeedback" placeholder="이름" required>
                        <div id="nameValidationFeedback" class="invalid-feedback">이름을 입력하세요.</div>
                    </li>
                    <!-- Phone -->
                    <li class="list-group mb-3">
                        <label for="phoneValidation" class="form-label"></label>
                        <input type="text" name="phone" class="form-control" id="phoneValidation"
                               aria-describedby="phoneValidationFeedback" placeholder="전화번호" required>
                        <div id="phoneValidationFeedback" class="invalid-feedback">전화번호를 입력하세요.</div>
                    </li>
                </ul>
            </div>
            <div class="box">
                <!-- Submit Button -->
                <input type="hidden" name="action" value="register">
                <button class="btn btn-secondary" type="submit">제출하기</button>
            </div>
        </div>
    </form>
</div>
<?php
include '../../home/footer.php';
?>
<!-- JavaScript 파일 연결 -->
<script src="/public/js/input.js"></script>
</body>
</html>