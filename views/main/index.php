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
    <video class="video-background" autoplay muted loop>
            <source src="/public/images/main/page1.mp4" type="video/mp4">
    </video>

    <div class="welcome-container">
        Cg1119 페이지에 오신걸 환영합니다
    </div>

    <div>
        <div class="container text-center">
        </div>
    </div>

    <div class="container my-5">
    </div>

    <?php
    include 'footer.php';
    ?>
</body>
</html>
<?php
ob_end_flush();
?>