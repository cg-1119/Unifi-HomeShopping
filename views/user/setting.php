<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

if(!$_SESSION['user']) {
    echo "<script>alert('로그인 후 사용 가능합니다.'); location.href ='../main/index.php';</script>";
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <title>수정</title>
</head>

<body>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/main/header.php';
?>
<div class="container">
    <div class="d-flex justify-content-center"><h2>수정</div>
    <a href="/views/user/mypage.php" class="btn btn-secondary mb-4">뒤로 가기</a>
    <form method="POST" action="/controllers/UserController.php" class="" novalidate>
        <div class="d-flex flex-column justify-content-center">
            <div class="border-box">
                <ul class="list-group">
                    <li class="list-group-item">
                        현재 배송지 : <?= htmlspecialchars($user['address'])?>
                    </li>
                    <li class="list-group-item">
                        <label class="form-label">새 배송지 <input type="button" class="btn btn-secondary" onclick="searchPostcode()" value="주소 찾기"></label>
                        <input type="text" class="form-control" id="roadAddress" name="address" placeholder="배송지 입력 (도로명주소)">
                    </li>
                </ul>
            </div>
            <div class="box" style="width: 40%;">
                <input type="hidden" name="uid" value="<?= $user['uid']?>">
                <button class="btn btn-outline-secondary" type="submit" name="action" value="modifyUserAddress">변경하기</button>
            </div>
        </div>
    </form>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/main/footer.php';
?>
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
                document.getElementById("roadAddress").value = roadAddr;

            }
        }).open();
    }
</script>
</body>

</html>