<?php
ob_start();
if (session_id() == '') {
    session_start();
}
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
        <title>상품 페이지</title>
    </head>
    <body>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/views/home/header.php';
    ?>
    <div class="container">
        <div class="product-container">
            <h2>상품 목록</h2>
            <div class="row mt-4">
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                    <p class="card-text">
                                        가격: <?php echo htmlspecialchars(number_format($product['price'])); ?>원
                                    </p>
                                    <a href="/views/product/detail.php?id=<?php echo htmlspecialchars($product['product_id']); ?>" class="btn btn-primary">자세히 보기</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>등록된 상품이 없습니다.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php';
    ?>
    </body>
    </html>
<?php
ob_end_flush();
?>