<?php
session_start();

// 관리자 로그인 여부 확인
if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
    echo "<script>alert('관리자만 접근할 수 있습니다.'); location.href = '/views/home/index.php';</script>";
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
    <title>상품 등록</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/header.php'; ?>

<div class="container mt-5">
    <h2>상품 등록</h2>
    <form action="/controllers/ProductController.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="category">카테고리</label>
            <input type="text" class="form-control" id="category" name="category" required>
        </div>
        <div class="form-group mt-3">
            <label for="name">상품명</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group mt-3">
            <label for="price">가격</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group mt-3">
            <label for="description">상품 설명</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="form-group mt-3">
            <label for="image">상품 이미지</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-primary mt-4" name="action" value="addProduct">상품 등록</button>
    </form>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php'; ?>

<script src="/public/js/bootstrap.js"></script>
</body>
</html>
