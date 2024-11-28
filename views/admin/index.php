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
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/header.php'; ?>

<div class="container mt-5">
    <h2>관리자 페이지</h2>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">상품 등록</h5>
                    <p class="card-text">카테고리, 상품명, 가격, 상품 설명 내용을 DB에 등록</p>
                    <a href="/views/admin/add_product.php" class="btn btn-primary">상품 등록</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">주문내역 조회</h5>
                    <p class="card-text">주문 완료 처리된 리스트를 DB에서 가져와 출력</p>
                    <a href="/views/admin/order_list.php" class="btn btn-primary">주문내역 조회</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">회원 관리</h5>
                    <p class="card-text">DB에서 회원 리스트 출력</p>
                    <a href="/views/admin/manage_users.php" class="btn btn-primary">회원 관리</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php'; ?>

<script src="/public/js/bootstrap.js"></script>
</body>
</html>
