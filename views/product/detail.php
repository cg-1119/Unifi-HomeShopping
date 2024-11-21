<?php
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Product.php';
header('Content-Type: text/html; charset=utf-8');

$productModel = new Product();
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = $productModel->getProductById($productId);
$productDetail = $productModel->getProductDetailById($productId);

if (!$product) {
    echo "<script>alert('상품을 찾을 수 없습니다.'); history.back();</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <title><?php echo htmlspecialchars($product['name']); ?> - 상품 상세 정보</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
        </div>
        <div class="col-md-6">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p>가격: <?php echo htmlspecialchars(number_format($product['price'])); ?>원</p>
            <p>카테고리: <?php echo htmlspecialchars($product['category']); ?></p>
            <hr>
            <h4>상품 설명</h4>
            <p><?php echo nl2br(htmlspecialchars($productDetail['description'])); ?></p>
            <button class="btn btn-primary mt-3">장바구니에 추가</button>
        </div>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php'; ?>

<script src="/public/js/bootstrap.js"></script>
</body>
</html>
<?php
ob_end_flush();
?>