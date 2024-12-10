<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <title>관리자 페이지</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/main/header.php'; ?>

<div class="container mt-5">
    <h2>관리자 페이지</h2>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">상품 등록</h5>
                    <p class="card-text">카테고리, 상품명, 가격, 상품 설명 내용 등록</p>
                    <a href="/views/admin/add_product.php" class="btn btn-primary">상품 등록</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">주문내역 관리</h5>
                    <p class="card-text">주문 배송 상태 처리 및 취소된 주문 처리</p>
                    <a href="/views/admin/order_management.php" class="btn btn-primary">주문 관리</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">회원 관리</h5>
                    <p class="card-text">회원 정보 조회 및 관리</p>
                    <a href="/views/admin/user_management.php" class="btn btn-primary">회원 관리</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/main/footer.php'; ?>

<script src="/public/js/bootstrap.js"></script>
</body>
</html>
