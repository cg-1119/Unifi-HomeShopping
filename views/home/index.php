<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>쇼핑몰</title>
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container my-3">
        <div class="row justify-content-end">
            <div class="col-md-6">
            </div>
        </div>
    </div>

    <div>
        <div class="container text-center">
            <a href="/views/product/index.php" class="text-decoration-none text-black">상품 리스트</a>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center">추천 제품 리스트</h2>
    </div>

    <?php
    include 'footer.php';
    ?>
</body>
</html>
<?php
ob_end_flush();
?>