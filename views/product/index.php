<?php
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Product.php';
header('Content-Type: text/html; charset=utf-8');

$productModel = new Product();

// 선택된 카테고리 가져오기
$selectedCategory = isset($_GET['category']) ? trim($_GET['category']) : null;
$products = $productModel->getProducts($selectedCategory);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <title>상품 목록</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/header.php'; ?>

<div class="container mt-5">
    <!-- 카테고리 필터 -->
    <div class="d-flex justify-content-center align-items-center mb-4 flex-wrap">
        <div class="text-center mx-3">
            <a href="?category=" class="nav-link">
                <img src="/public/images/icons/icon-all.svg" alt="UniFi Cloud Gateways" class="category-icon" style="width: 50px;">
                <span>전체</span>
            </a>
        </div>
        <div class="text-center mx-3">
            <a href="?category=gateway" class="nav-link">
                <img src="/public/images/icons/icon-cloud-gateways.svg" alt="UniFi Cloud Gateways" class="category-icon" style="width: 130px;">
                <span>클라우드 게이트웨이</span>
            </a>
        </div>
        <div class="text-center mx-3">
            <a href="?category=switching" class="nav-link">
                <img src="/public/images/icons/icon-switching.svg" alt="Switching" class="category-icon" style="width: 80px;">
                <span>스위칭</span>
            </a>
        </div>
        <div class="text-center mx-3">
            <a href="?category=wifi" class="nav-link">
                <img src="/public/images/icons/icon-wifi.svg" alt="WiFi" class="category-icon" style="width: 60px;">
                <span>와이파이</span>
            </a>
        </div>
        <div class="text-center mx-3">
            <a href="?category=accessories" class="nav-link">
                <img src="/public/images/icons/icon-accessories.svg" alt="Accessories" class="category-icon" style="width: 80px;">
                <span>악세서리</span>
            </a>
        </div>
    </div>



    <!-- 상품 목록 -->
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
        <?php if (is_array($products) && count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="card product-card"
                         onclick="location.href='/views/product/detail.php?id=<?php echo htmlspecialchars($product['id']); ?>'">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>"
                             class="card-img-top"
                             alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text text-center">
                                가격: <?php echo htmlspecialchars(number_format($product['price'])); ?>원
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center">
                <p>등록된 상품이 없습니다.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php'; ?>
</body>
</html>
<?php
ob_end_flush();
?>
