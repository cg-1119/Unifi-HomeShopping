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
    <form method-="GET" action="#" class="needs-validation" novalidate>
        <div class="mt-5 d-flex flex-column justify-content-center">
            <div class="border-box">
                <ul class="list-group">
                    <li class="list-group">
                        <label for="idValidation" class="form-label"></label>
                        <input type="text" class="form-control is-invalid" id="idValidation" aria-describedby="idValidationFeedback" placeholder="아이디" required>
                        <div id="idValidationFeedback" class="invalid-feedback">
                            아이디를 입력하세요.
                        </div>
                    </li>
                    <li class="list-group">
                        <label for="psValidation" class="form-label"></label>
                        <input type="password" class="form-control is-invalid" id="psValidation" aria-describedby="psValidationFeedback" placeholder="비밀번호" required>
                        <div id="psValidationFeedback" class="invalid-feedback">
                            비밀번호를 입력하세요.
                        </div>
                    </li>
                    <li class="list-group">
                        <label for="nameValidation" class="form-label"></label>
                        <input type="text" class="form-control is-invalid" id="nameValidation" aria-describedby="nameValidationFeedback" placeholder="이름" required>
                        <div id="nameValidationFeedback" class="invalid-feedback">
                            이름을 입력하세요.
                        </div>
                    </li>
                    <li class="list-group">
                        <label for="phoneValidation" class="form-label"></label>
                        <input type="text" class="form-control is-invalid" id="phoneValidation" aria-describedby="phoneValidationFeedback" placeholder="전화번호" required>
                        <div id="idValidationFeedback" class="invalid-feedback">
                            전화번호를 입력하세요.
                        </div>
                    </li>
                    <li class="list-group">
                        <label for="zipValidation" class="form-label"></label>
                        <input type="text" class="form-control is-invalid" id="zipValidation" aria-describedby="zipValidationFeedback" placeholder="집주소" required>
                        <div id="idValidationFeedback" class="invalid-feedback">
                            집주소를 입력하세요.
                        </div>
                    </li>
                    <li class="list-group">
                        <button class="btn btn-primary" type="submit">제출하기</button>
                    </li>
                </ul>
            </div>
        </div>
    </form>
</div>
<?php
include '../../home/footer.php';
?>
<script src="/public/js/input.js"></script>
<script>

</script>
</body>
</html>