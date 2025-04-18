<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>비밀번호 찾기</title>
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
</head>

<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/main/header.php'; ?>
<div class="container mt-5">
    <form class="needs-validation" method="POST" action="/controllers/UserController.php" novalidate>
        <div class="mt-5 d-flex flex-column justify-content-center">
            <h2 class="text-center mt-5">비밀번호 찾기</h2>
            <div class="border-box">
                <div style="padding:24px; width: 100%;">
                    <p>비밀번호를 찾으시려면, 재설정 하셔야합니다.</p>
                    <p>정보를 입력해 주세요.</p>
                    <div class="has-validation">
                        <input type="text" class="form-control " name="id" id="idValidation"
                               placeholder="ID"
                               required>
                        <div class="invalid-feedback">
                            아이디를 입력해 주세요.
                        </div>
                    </div>
                    <div class="has-validation">
                        <input type="text" class="mt-4 form-control" name="name" id="nameValidation"
                               placeholder="이름" required>
                        <div class="invalid-feedback">
                            이름을 입력해 주세요.
                        </div>
                    </div>
                    <input class ="form-control" type="hidden" name="action" value="requestPwReset">
                    <button type="submit" class="mt-5 btn btn-secondary" style="width: 100%;">입력</button>
                </div>
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