<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>리뷰 등록</title>
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card mx-auto shadow-lg" style="width: 100%;">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="m-3">리뷰 작성</h2>
        </div>
        <div class="card-body">
            <form action="/controllers/ProductReviewController.php" method="POST">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($_GET['product_id']) ?>">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($_GET['user_id']) ?>">
                
                <div class="mb-3">
                    <label for="rating" class="form-label">별점</label>
                    <select name="rate" id="rating" class="form-select" required>
                        <option value="">별점 선택</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">내용:</label>
                    <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">사진 업로드(선택):</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                </div>
                <div class="text-center">
                    <button type="submit" name="action" value="addProductReview" class="btn btn-secondary w-100">작성하기</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="/public/js/bootstrap.bundle.min.js"></script>
</body>
</html>
