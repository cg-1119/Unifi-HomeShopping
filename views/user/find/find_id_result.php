<?php
session_start();

$findIdResult = isset($_SESSION['find_id_result']) ? $_SESSION['find_id_result'] : null;
unset($_SESSION['find_id_result']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>아이디 찾기</title>
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
</head>

<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/main/header.php'; ?>
<div class="container mt-5">
    <form class="needs-validation" method="POST" action="/controllers/UserController.php" novalidate>
        <div class="mt-5 d-flex flex-column justify-content-center">
            <h2 class="text-center mt-5">결과</h2>
            <div class="border-box">
                <div style="padding:24px; width: 100%;">
                    <?php if ($findIdResult): ?>
                        <?php if ($findIdResult['status'] === 'success'): ?>
                            <p>찾은 아이디: <strong><?php echo htmlspecialchars($findIdResult['id']); ?></strong></p>
                        <?php elseif ($findIdResult['status'] === 'error'): ?>
                            <p><?php echo htmlspecialchars($findIdResult['message']); ?></p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>결과가 없습니다.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mt-2 d-flex justify-content-center" style="width: 100%">
                <a class="nav-link text-secondary" href="../join/agree.php">로그인</a>
                <span class="link-border"></span>
                <a class="nav-link text-secondary" href="find_pw.php">비밀번호 찾기</a>
            </div>
        </div>
    </form>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/main/footer.php';
?>
</body>

</html>