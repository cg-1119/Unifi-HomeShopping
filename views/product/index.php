<?php
ob_start();
if (session_id() == '') {
    session_start();
}
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