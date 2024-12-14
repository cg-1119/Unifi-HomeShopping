<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/main/header.php';
?>
<div class="container mt-5">
    <div class="d-flex justify-content-center"><h2 class="m-5">약관 동의</div>
    <form method-="GET" action="verify.php">
        <div class="d-flex flex-column justify-content-center">
            <div class="border-box">
                <ul class="list-group">
                    <li class="list-group">
                        <input type="checkbox" id="checkService" hidden>
                        <label for="checkService" class="label-box">
                            <i id="serviceIcon" class="bi bi-check-circle" style="font-size: 1.5rem"></i>
                            <span>홈쇼핑 이용약관</span>
                        </label>
                        <div class="text-box">
                            <p>제1장 총 칙</p>
                            <p>제 1조 (목적)</p>
                            <p> 이 약관은 Cg1119이 제공하는 인터넷 쇼핑몰 서비스(이하 "서비스")의 이용과 관련하여 회사와 이용자의 권리, 의무, 책임사항, 절차 등을 규정함을 목적으로 합니다.</p>
                            <p>제 2조 (용어의 정의)</p>
                            <p>1. "사이트"란 [홈쇼핑 사이트명]이 제공하는 인터넷 쇼핑몰 서비스를 의미합니다.</p>
                            <p>2. "이용자"란 이 약관에 따라 사이트에 접속하여 서비스를 이용하는 회원 및 비회원을 말합니다.</p>
                            <p>3. "회원"이란 사이트에 회원가입을 통해 아이디(ID)와 비밀번호를 부여받아 서비스를 이용하는 자를 의미합니다.</p>
                            <p>4. "상품"이란 회사가 사이트를 통해 판매하는 물품을 의미합니다.</p>
                            <p>제 3조 (약관의 게시 및 개정)</p>
                            <p>1. 이 약관은 사이트 초기 화면에 게시하여 이용자가 확인할 수 있도록 합니다.</p>
                            <p>2. 회사는 관련 법령에 위배되지 않는 범위 내에서 이 약관을 개정할 수 있습니다.</p>
                            <p>3. 약관이 개정될 경우 회사는 개정된 약관을 적용 일자 7일 전부터 사이트에 공지합니다.</p>
                        </div>
                    </li>
                    <li class="list-group">
                        <input type="checkbox" id="checkPrivacy" hidden>
                        <label for="checkPrivacy" class="label-box">
                            <i id="privacyIcon" class="bi bi-check-circle" style="font-size: 1.5rem"></i>
                            <span>개인정보 수집동의</span>
                        </label>
                        <div class="text-box">
                            <p>개인정보보호법에 따라 Cg1119에 회원가입 신청하시는 분께 수집하는 개인정보의 항목, 개인정보의 수집 및 이용목적, 개인정보의 보유 및
                                이용기간, 동의 거부권 및 동의 거부 시 불이익에 관한 사항을 안내 드리오니 자세히 읽은 후 동의하여 주시기 바랍니다.</p>
                        </div>
                    </li>
                    <li class="list-group">
                        <input type="checkbox" id="checkAll" hidden>
                        <label for="checkAll" class="label-box">
                            <i id="checkAllIcon" class="bi bi-check-circle" style="font-size: 1.5rem"></i>
                            <span>전체 동의하기</span>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="box" style="width: 40%;">
                <input class="form-control btn btn-outline-secondary" type="submit" value="다음으로" disabled>
            </div>
        </div>
    </form>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/main/footer.php';
?>
<!-- JavaScript 파일 연결 -->
<script src="/public/js/custom/buttonChange.js"></script>

</body>

</html>