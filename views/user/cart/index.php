<?php
session_start();

// updateCart
$data = json_decode(file_get_contents('php://input'), true);
$cart = $_SESSION['cart'] ?? [];
$totalPrice = 0;

if (!$cart) {
    // Update cart based on incoming data
    if (isset($data['cart'])) {
        foreach ($data['cart'] as $productId => $item) {
            $cart[$productId] = [
                'id' => $item['id'],
                'name' => htmlspecialchars($item['name']),
                'price' => floatval($item['price']),
                'thumbnail' => htmlspecialchars($item['thumbnail']),
                'quantity' => intval($item['quantity']),
            ];
        }
        $_SESSION['cart'] = $cart;
    }

    // 요청 처리
    $action = $data['action'] ?? null;
    $productId = $data['product_id'] ?? null;

    if ($action === 'updateQuantity' && $productId && isset($data['quantity'])) {
        $quantity = intval($data['quantity']);
        if (isset($cart[$productId]) && $quantity > 0) {
            $cart[$productId]['quantity'] = $quantity;
        }
    } elseif ($action === 'remove' && $productId) {
        unset($cart[$productId]);
    } elseif ($action === 'clear') {
        $cart = [];
    }

    $_SESSION['cart'] = $cart;
}
// 총 금액 계산
foreach ($cart as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

?>
<!DOCTYPE html>
<html lang="ko">
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

    <?php if (empty($cart)): ?>
        <div class="text-center">
            <p>장바구니가 비어 있습니다.</p>
            <a href="/views/product/index.php" class="btn btn-primary">쇼핑 계속하기</a>
        </div>
    <?php else: ?>
        <table class="table">
            <thead>
            <tr class="text-center">
                <th>상품명</th>
                <th>가격</th>
                <th>수량</th>
                <th>합계</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cart as $id => $item): ?>
                <tr>
                    <td class="border-end">
                        <a href="/views/product/detail.php?id=<?php echo htmlspecialchars($item['id']); ?>"
                           style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                            <img src="<?php echo htmlspecialchars($item['thumbnail']); ?>" alt="썸네일"
                                 style="width: 60px; height: 60px; margin-right: 10px;">
                            <span><?php echo htmlspecialchars($item['name']); ?></span>
                        </a>
                    </td>
                    <td class="text-center align-middle border-end"><?php echo number_format($item['price']); ?>원</td>
                    <td class="align-middle border-end">
                        <input
                                type="number"
                                value="<?php echo htmlspecialchars($item['quantity']); ?>"
                                min="1"
                                class="form-control form-control-sm"
                                style="width: 80px;"
                                onchange="updateQuantity(<?php echo htmlspecialchars($id); ?>, this.value)"
                        >
                    </td>
                    <td class="text-center align-middle"><?php echo number_format($item['price'] * $item['quantity']); ?>원</td>
                    <td class="text-center align-middle">
                        <button class="btn btn-sm btn-danger"
                                onclick="removeFromCart(<?php echo htmlspecialchars($id); ?>)">삭제
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <h4>총 금액: <span id="total-price" class="text-danger"><?php echo number_format($totalPrice); ?>원</span></h4>
            <button class="btn btn-warning" onclick="clearCart()">장바구니 비우기</button>
        </div>

        <div class="mt-3">
            <a href="/views/order/checkout.php" class="btn btn-success w-100">주문하기</a>
        </div>
    <?php endif; ?>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php'; ?>
<script src="/public/js/custom/cart.js"></script>
</body>
</html>
