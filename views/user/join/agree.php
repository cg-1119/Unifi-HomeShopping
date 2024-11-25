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
include $_SERVER['DOCUMENT_ROOT'] . '/views/home/header.php';
?>
<div class="container">
    <form method-="GET" action="verify.php">
        <div class="mt-5 d-flex flex-column justify-content-center">
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
                            <p>제1조 【목적】</p>
                            <p> 본 약관은 Cg1119 Homeshopping(이하 &quot;회사&quot;로 표기)가 제공하는 온라인 도서판매 쇼핑몰(이하 &quot;쇼핑몰&quot;로
                                표기)의 회원 가입에 있어서
                                회사와 회원간 권리의무에 관한 사항, 서비스 이용조건과 절차 및 기타 필요한 사항을 규정함을 목적으로 합니다.</p>
                            <p>제2조 【용어의 정의】</p>
                            <p>본 약관에서 사용하는 용어의 정의는 다음과 같습니다.</p>
                        </div>
                    </li>
                    <li class="list-group">
                        <input type="checkbox" id="checkPrivacy" hidden>
                        <label for="checkPrivacy" class="label-box">
                            <i id="privacyIcon" class="bi bi-check-circle" style="font-size: 1.5rem"></i>
                            <span>개인정보 수집동의</span>
                        </label>
                        <div class="text-box">
                            <p>개인정보보호법에 따라 Cg1119 Homeshopping에 회원가입 신청하시는 분께 수집하는 개인정보의 항목, 개인정보의 수집 및 이용목적, 개인정보의 보유 및
                                이용기간,
                                동의 거부권 및 동의 거부 시 불이익에 관한 사항을 안내 드리오니 자세히 읽은 후 동의하여 주시기 바랍니다.</p>
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
            <div class="box">
                <div style="padding:24px; width: 100%; flex-direction: column;">
                    <input class="form-control btn btn-outline-secondary" type="submit" value="다음으로" disabled>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php';
?>
<!-- JavaScript 파일 연결 -->
<script src="/public/js/user/buttonChange.js"></script>

</body>

</html>