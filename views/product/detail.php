<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Product.php';
header('Content-Type: text/html; charset=utf-8');

$productModel = new Product();

// 상품 ID 가져오기
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 상품 정보 가져오기
$product = $productModel->getProductById($productId);
if (!$product) {
    echo "<script>alert('존재하지 않는 상품입니다.'); location.href='/product/index.php';</script>";
    exit;
}

// 상품 이미지 가져오기
$productImages = $productModel->getProductImages($productId);
$thumbnail = null;
$additionalImages = array();

// 이미지 분류
foreach ($productImages as $image) {
    if ($image['is_thumbnail']) {
        $thumbnail = $image['image_url'];
    } else {
        $additionalImages[] = $image['image_url'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <style>
        .product-header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .product-thumbnail {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid #ddd;
            margin-right: 20px;
        }
        .product-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .product-info h1 {
            font-size: 1.8rem;
            font-weight: bold;
            margin: 0;
            color: #333;
        }
        .product-info .product-slug {
            font-size: 1rem;
            color: #666;
            margin-top: 5px;
        }
    </style>
    <title><?php echo htmlspecialchars($product['name']); ?></title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/header.php'; ?>

<div class="container">
    <!-- 상단 헤더 섹션 -->
    <div class="product-header row align-items-center">
        <!-- 썸네일 이미지 -->
        <div class="col-auto">
            <div class="product-thumbnail">
                <img src="<?php echo $thumbnail; ?>" alt="대표 이미지">
            </div>
        </div>
        <!-- 상품 정보 -->
        <div class="col">
            <div class="product-info">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <div class="product-slug">
                    <?php echo htmlspecialchars(str_replace(' ', '-', $product['name'])); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="product-detail-container row mt-4">
        <!-- 왼쪽 추가 이미지 섹션 -->
        <div class="col-md-4">
            <div class="additional-images">
                <?php foreach ($additionalImages as $image): ?>
                    <img src="<?php echo $image; ?>" class="img-fluid mb-2" alt="추가 이미지" onclick="document.querySelector('.product-thumbnail img').src = this.src;">
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 오른쪽 설명 섹션 -->
        <div class="col-md-8">
            <div class="product-description">
                <div class="description-content">
                    <?php echo $product['description']; // HTML 태그 유지 ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php'; ?>
<script src="/public/js/bootstrap.js"></script>
</body>
</html>