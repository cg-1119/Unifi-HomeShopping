<?php
session_start();

$cart = $_SESSION['cart'] ?? [];
$isCartEmpty = empty($cart);
echo '<pre>';
print_r($_SESSION['cart']);
echo '</pre>';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <title>장바구니</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">장바구니</h2>

    <?php if($isCartEmpty): ?>
    <div class="">
        <p>장바구니가 비어 있습니다.</p>
        <a href="/views/product/index.php" class="btn btn-primary">쇼핑 계속하기</a>
    </div>
    <?php else: ?>
    <div id="cart-container"    >
        <table class="table">
            <thead>
            <tr>
                <th>상품 ID</th>
                <th>상품명</th>
                <th>가격</th>
                <th>수량</th>
                <th>합계</th>
                <th>작업</th>
            </tr>
            </thead>
            <tbody id="cart-table-body">
            <!-- cart json 데이터 기반으로 테이블을 생성-->
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <h4>총 금액: <span id="total-price" class="text-danger">0원</span></h4>
            <button onclick="clearCart()" class="btn btn-warning">장바구니 비우기</button>
        </div>

        <div class="mt-3">
            <a href="/order/checkout.php" class="btn btn-success w-100">주문하기</a>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php'; ?>
<script src="/public/js/custom/cart.js"></script>
</body>
</html>