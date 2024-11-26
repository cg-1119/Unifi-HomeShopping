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
    <div class="d-flex justify-content-center mb-4">
        <a href="index.php" class="btn btn-primary mx-2 <?php echo is_null($selectedCategory) ? 'active' : ''; ?>">전체</a>
        <a href="index.php?category=wifi" class="btn btn-primary mx-2 <?php echo $selectedCategory === 'wifi' ? 'active' : ''; ?>">와이파이</a>
        <a href="index.php?category=gateway" class="btn btn-primary mx-2 <?php echo $selectedCategory === 'gateway' ? 'active' : ''; ?>">게이트웨이</a>
        <a href="index.php?category=accessories" class="btn btn-primary mx-2 <?php echo $selectedCategory === 'accessories' ? 'active' : ''; ?>">악세서리</a>
    </div>

    <!-- 상품 목록 -->
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
        <?php if (is_array($products) && count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="card product-card"
                         onclick="location.href='/views/product/detail.php?id=<?php echo htmlspecialchars($product['product_id']); ?>'">
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
