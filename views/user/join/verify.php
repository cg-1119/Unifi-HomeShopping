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
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/main/header.php';
?>
<div class="container mt-5">
    <div class="d-flex justify-content-center"><h2 class="mt-5">정보 입력</div>
    <form method="POST" action="/controllers/UserController.php" class="needs-validation" novalidate>
        <div class="mt-5 d-flex flex-column justify-content-center">
            <div class="box">
                <ul class="list-group">
                    <!-- 아이디 -->
                    <li class="list-group mb-3">
                        <label for="idValidation" class="form-label"></label>
                        <input type="text" name="id" class="form-control" id="idValidation"
                               aria-describedby="idValidationFeedback" placeholder="아이디" required>
                        <div id="idValidationFeedback" class="invalid-feedback">아이디를 입력하세요.</div>
                    </li>
                    <!-- 비밀번호 -->
                    <li class="list-group mb-3">
                        <label for="pwValidation" class="form-label"></label>
                        <input type="password" name="pw" class="form-control" id="pwValidation"
                               aria-describedby="pwValidationFeedback" placeholder="비밀번호" required>
                        <div id="pwValidationFeedback" class="invalid-feedback">비밀번호를 입력하세요.</div>
                    </li>
                    <!-- 비밀번호 확인 -->
                    <li class="list-group mb-3">
                        <label for="pwCheckValidation" class="form-label"></label>
                        <input type="password" class="form-control" id="pwCheckValidation"
                               aria-describedby="pwCheckValidationFeedback" placeholder="비밀번호 재입력" required>
                        <div id="pwCheckValidationFeedback" class="invalid-feedback">비밀번호를 입력하세요.</div>
                    </li>
                    <!-- 이름 -->
                    <li class="list-group mb-3">
                        <label for="nameValidation" class="form-label"></label>
                        <input type="text" name="name" class="form-control" id="nameValidation"
                               aria-describedby="nameValidationFeedback" placeholder="이름" required>
                        <div id="nameValidationFeedback" class="invalid-feedback">이름을 입력하세요.</div>
                    </li>
                    <!-- 이메일 -->
                    <li class="list-group mb-3">
                        <label for="emailValidation" class="form-label"></label>
                        <div class="input-group mb-2">
                            <input type="text" name="email" class="form-control" id="emailValidation"
                                   aria-describedby="emailValidationFeedback" placeholder="이메일" required>
                            <div id="autocomplete-list" class="autocomplete-list d-none"></div>
                            <div id="emailValidationFeedback" class="invalid-feedback">이메일을 입력하세요.</div>
                    </li>
                    <!-- 전화번호 -->
                    <li class="list-group mb-3">
                        <label for="phoneValidation" class="form-label"></label>
                        <input type="text" name="phone" class="form-control" id="phoneValidation"
                               aria-describedby="phoneValidationFeedback" placeholder="전화번호" required>
                        <div id="phoneValidationFeedback" class="invalid-feedback">전화번호를 입력하세요.</div>
                    </li>
                    <!-- 주소 -->
                    <li class="list-group mb-3">
                        <label for="addressValidation" class="form-label"></label>
                        <input type="text" name="address" class="form-control" id="addressValidation" placeholder="주소" required>
                        <div id="addressValidationFeedback" class="invalid-feedback">주소를 입력하세요.</div>
                    </li>
                    <input type="button" class="btn btn-secondary" onclick="searchPostcode()" value="주소 찾기" style="width: 20%">
                    <p>상세 주소가 존재하면 주소 뒤에 기입</p>
                </ul>
            </div>
            <div class="box">
                <!-- Submit Button -->
                <input type="hidden" name="action" value="register">
                <button class="btn btn-secondary" type="submit">회원가입</button>
            </div>
        </div>
    </form>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/main/footer.php';
?>
<!-- JavaScript 파일 연결 -->
<script src="/public/js/custom/inputValidation.js"></script>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    function searchPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                var roadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 참고 항목 변수

                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                    extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }
                document.getElementById("addressValidation").value = roadAddr;

            }
        }).open();
    }
</script>
</body>
</html>