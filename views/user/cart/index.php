<?php
session_start();

// updateCart
$data = json_decode(file_get_contents('php://input'), true);
$cart = $_SESSION['cart'] ?? [];
$totalPrice = 0;
if ($data) {
    foreach ($data['cart'] as $productId => $item) {
        $cart[$productId] = [
            'id' => $item['id'],
            'name' => htmlspecialchars($item['name']),
            'price' => floatval($item['price']),
            'thumbnail' => htmlspecialchars($item['thumbnail']),
            'quantity' => intval($item['quantity']),
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $productId = $_POST['product_id'] ?? null;

    // 수량 업데이트
    if ($action === 'updateQuantity' && $productId && isset($_POST['quantity'])) {
        $quantity = intval($_POST['quantity']);
        if (isset($cart[$productId]) && $quantity > 0) {
            $cart[$productId]['quantity'] = $quantity;
        }
    } // 상품 삭제
    elseif ($action === 'remove' && $productId) unset($cart[$productId]);
    // 장바구니 비우기
    elseif ($action === 'clear') $cart = [];

    // 세션 업데이트
    $_SESSION['cart'] = $cart;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
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
            <tr>
                <th>썸네일</th>
                <th>상품명</th>
                <th>가격</th>
                <th>수량</th>
                <th>합계</th>
                <th>작업</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cart as $id => $item): ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($item['thumbnail']); ?>" alt="썸네일"
                             style="width: 60px; height: 60px;"></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo number_format($item['price']); ?>원</td>
                    <td>
                        <input
                                type="number"
                                value="<?php echo htmlspecialchars($item['quantity']); ?>"
                                min="1"
                                class="form-control form-control-sm"
                                style="width: 80px;"
                                onchange="updateQuantity(<?php echo htmlspecialchars($id); ?>, this.value)"
                        >
                    </td>
                    <td><?php echo number_format($item['price'] * $item['quantity']); ?>원</td>
                    <td>
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
