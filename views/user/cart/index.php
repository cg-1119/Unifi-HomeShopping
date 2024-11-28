<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/CartController.php';
session_start();

// 로그인 확인
if (!isset($_SESSION['user'])) {
    echo "<script>alert('로그인이 필요합니다.'); location.href='/views/user/login.php';</script>";
    exit;
}

// 장바구니 데이터 가져오기
$cartController = new CartController();
$cartItems = $cartController->viewCart();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <title>장바구니</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">장바구니</h2>

    <?php if (empty($cartItems)): ?>
        <p>장바구니가 비어 있습니다.</p>
        <a href="/views/home/index.php" class="btn btn-primary">쇼핑 계속하기</a>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>상품명</th>
                <th>가격</th>
                <th>수량</th>
                <th>총 금액</th>
                <th>삭제</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?>
                        <img src="<?php echo $item['image_url']?>" style="width: 50px; height: auto;"></td>
                    <td><?php echo number_format($item['price']); ?>원</td>
                    <td>
                        <form action="/controllers/CartController.php" method="POST" class="d-flex">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control me-2" style="width: 80px;">
                            <button type="submit" class="btn btn-sm btn-secondary">수량 변경</button>
                        </form>
                    </td>
                    <td><?php echo number_format($item['price'] * $item['quantity']); ?>원</td>
                    <td>
                        <form action="/controllers/CartController.php" method="POST">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">삭제</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <h4>총 금액:
                <span class="text-danger">
                    <?php
                    $totalPrice = array_reduce($cartItems, function ($sum, $item) {
                        return $sum + ($item['price'] * $item['quantity']);
                    }, 0);
                    echo number_format($totalPrice) . '원';
                    ?>
                </span>
            </h4>
            <form action="/controllers/CartController.php" method="POST">
                <input type="hidden" name="action" value="clear">
                <button type="submit" class="btn btn-warning">장바구니 비우기</button>
            </form>
        </div>

        <div class="mt-3">
            <a href="/order/checkout.php" class="btn btn-success w-100">주문하기</a>
        </div>
    <?php endif; ?>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php'; ?>
</body>
</html>
