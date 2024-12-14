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
    <div class="header-container">
        <span id="target" class="headerText">Cg1119에 오신 것을 환영합니다</span>
    </div>
</div>
<div class="section">
    <img src="/public/images/main/page2.jpg" class="background">
    <div class="header-container">
        <span class="headerText">상품 설명</span>
    </div>
    <div class="product-intro">
        <div class="product-item">
            <h2>클라우드 게이트웨이</h2>
            <img src="/public/images/icons/icon-cloud-gateways.svg" alt="UniFi Cloud Gateways" class="category-icon" style="width: 50%;">
            <p>강력하고 효율적인 네트워크 관리를 위한 클라우드 기반 솔루션. 언제 어디서나 연결 상태를 제어하세요.</p>
        </div>
        <div class="product-item">
            <h2>스위칭</h2>
            <img src="/public/images/icons/icon-switching.svg" alt="switching" class="category-icon" style="width: 36%;">
            <p>초고속 네트워크 전환을 지원하는 유비쿼티 스위치. 안정적인 데이터 전송과 유연한 관리 옵션 제공.</p>
        </div>
        <div class="product-item">
            <h2>와이파이</h2>
            <img src="/public/images/icons/icon-wifi.svg" alt="wifi" class="category-icon" style="width: 18%;">
            <p>최상의 커버리지와 성능을 자랑하는 Wi-Fi 솔루션. 끊김 없는 인터넷 경험을 제공합니다.</p>
        </div>
    </div>
</div>
<div class="section">
    <img src="/public/images/main/page3.jpg" class="background">
    <div class="header-container">
        <span class="headerText">상품 추천</span>
    </div>
    <div class="product-intro">
        <div class="product-item">
            <h2>Dream Machine Pro Max</h2>
            <img src="/uploads/products/6/udm-pro-max-1.png" alt="Dream Machine Pro Max">
        </div>
        <div class="product-item">
            <h2>Standard 24 PoE</h2>
            <img src="/uploads/products/12/usw-24-poe-1.png" alt="Standard 24 PoE">
        </div>
        <div class="product-item">
            <h2>U7 Pro</h2>
            <img src="/uploads/products/1/u7-pro.png" alt="U7 Pro">
        </div>
    </div>
</div>
</body>
<script src="/public/js/custom/main.js"></script>
<script src="https://unpkg.com/type-hangul"></script>
<script>
    var $target = document.querySelector('#target');
    $target.addEventListener('th.afterType', function (e) {
        console.log(e.detail.progress);
    });
    TypeHangul.type('#target', { intervalType: 50});
</script>
</html>