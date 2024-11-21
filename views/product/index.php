<?php
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Product.php';
header('Content-Type: text/html; charset=utf-8');

$productModel = new Product();
$products = $productModel->getProducts();
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
        <div class="justify-content-center">카테고리 넣을 예정</div>
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
            <?php if (is_array($products) && count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col">
                        <div class="card product-card"
                             onclick="location.href='/views/product/detail.php?id=<?php echo htmlspecialchars($product['product_id']); ?>'">
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="card-img-top"
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
                <p>등록된 상품이 없습니다.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php'; ?>

    <script src="/public/js/bootstrap.js"></script>
    </body>
    </html>
<?php
ob_end_flush();
?>