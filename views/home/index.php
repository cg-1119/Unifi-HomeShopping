<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>쇼핑몰</title>
    <link rel="stylesheet" href="/public/css/bootstrap.css">
</head>

<body>

    <?php
    include 'header.php';
    ?>
    
    <div class="bg-light py-2">
        <div class="container text-center">
            <a href="#" class="text-decoration-none text-dark">상품 카테고리 메뉴</a>
        </div>
    </div>

    <div class="container my-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="검색어를 입력하세요">
                    <button class="btn btn-outline-secondary" type="button">검색</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center">추천 제품 리스트</h2>

        <h2 class="text-center mt-4">상품 리스트</h2>
    </div>

    <?php
    include 'footer.php';
    ?>
</body>

</html>