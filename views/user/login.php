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

    <div class="mt-5 d-flex justify-content-center">
        <h1>로그인</h1>
    </div>
    <div class="d-flex justify-content-center login-box">
        <div style="padding:24px; width: 100%;">
            <input type="text" class="mb-4 form-control " name="" id="" placeholder="이름" />
            <input type="text" class="mb-4 form-control" name="" id="" placeholder="비밀번호" />
            <input type="submit" class="form-control" value="로그인">
            <div class="mt-2 d-flex justify-content-center" style="width: 100%">
                <a class="nav-link text-secondary" href="#">회원가입</a>
                <span class="link-border"></span>
                <a class="nav-link text-secondary" href="#">아이디 찾기</a>
                <span class="link-border"></span>
                <a class="nav-link text-secondary" href="#">비밀번호 찾기</a>
            </div>
            <div class="mt-5 text-bg-danger" id="id_error_msg" style="display: none">아이디를 잘못 입력하셨습니다.</div>
            <div class="mt-5 text-bg-danger" id="id_error_msg" style="display: none">비밀번호를 잘못 입력하셨습니다.</div>
        </div>
    </div>



    <?php
    include '../home/footer.php';
    ?>
</body>

</html>