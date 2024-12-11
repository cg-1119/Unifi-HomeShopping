<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>쇼핑몰</title>
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/main.css">
</head>

<body>
<header>
    <?php include 'header.php'; ?>
</header>
<div class="section">
    <video class="background" autoplay muted loop>
        <source src="/public/images/main/page1.mp4" type="video/mp4">
    </video>
</div>
<div id="welcomeContainer" class="welcome-container">
    <span id="welcomeText">Cg1119에 오신 것을 환영합니다</span>
</div>
<div class="section">
    <img src="/public/images/main/page2.jpg" class="background">
    <div class="product-intro">
        <div class="product-item">
            <h2>클라우드 게이트</h2>
            <p>강력하고 효율적인 네트워크 관리를 위한 클라우드 기반 솔루션. 언제 어디서나 연결 상태를 제어하세요.</p>
        </div>
        <div class="product-item">
            <h2>스위칭</h2>
            <p>초고속 네트워크 전환을 지원하는 유비쿼티 스위치. 안정적인 데이터 전송과 유연한 관리 옵션 제공.</p>
        </div>
        <div class="product-item">
            <h2>와이파이</h2>
            <p>최상의 커버리지와 성능을 자랑하는 Wi-Fi 솔루션. 끊김 없는 인터넷 경험을 제공합니다.</p>
        </div>
    </div>
</div>
<div class="section">
    <img src="/public/images/main/page3.jpg" class="background">
</div>


<script src="/public/js/custom/main.js"></script>
</body>
</html>