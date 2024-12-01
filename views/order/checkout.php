<?php
session_start();

if (!$_SESSION['user']){
    echo "<script>alert('로그인 후 사용 가능합니다.'); location.href = '/views/user/login.php';</script>";
}
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

// 총 금액 계산
foreach ($cart as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>주문 페이지</title>
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <script src="/public/js/custom/order.js" defer></script>
</head>
<body>
<!-- 결제 모달 -->

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/header.php'; ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">주문하기</h1>
    <div class="order-container">
        <!-- 왼쪽 영역 -->
        <div class="order-left">
            <!-- 상품 정보 -->
            <div id="cart-info" class="mb-4">
                <h2>상품 정보</h2>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>이미지</th>
                        <th>상품명</th>
                        <th>가격</th>
                        <th>수량</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($cart as $id => $item): ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($item['thumbnail']); ?>" alt="썸네일"
                                     style="width: 60px; height: 60px;"></td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo number_format($item['price']); ?>원</td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?>개</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- 배송지 정보 -->
            <div id="delivery-info" class="mb-4">
                <h2>배송지 정보</h2>
                <form>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="address" value="1" checked>
                        <label class="form-check-label">
                            기본 배송지 사용: <span id="default-address"><?= htmlspecialchars($user['address']) ?></span>,
                            <span id="default-phone"><?= htmlspecialchars($user['phone']) ?></span>
                        </label>
                    </div>
                    <div class="form-check mt-3">
                        <input type="radio" class="form-check-input" name="address" value="0">
                        <label class="form-check-label">새 배송지 입력:</label>
                        <div id="new-address-fields" class="mt-3">
                            <input type="text" name="address" class="form-control mb-2" placeholder="주소">
                            <input type="text" name="phone" class="form-control" placeholder="연락처">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- 오른쪽 영역 -->
        <div class="order-right">
            <h3>결제 상세</h3>
            <div class="mb-4">
                <p id="totalPrice">총 주문 금액: <strong><?= number_format($totalPrice) ?> 원</strong></p>
                <hr>
            </div>
            <h3>포인트 혜택</h3>
            <div class="mb-4">
                <p>보유 포인트: <strong><?= htmlspecialchars($user['point']) ?> 원</strong></p>
                <label class="form-check-label">사용 포인트</label>
                <input type="number" name="point" class="form-control mb-2"
                       placeholder="사용할 포인트" min="0" max="<?= htmlspecialchars($user['point']) ?>"
                       oninput="pointInputChange(this)">
                <p id="point">적립 예정 포인트: <strong class="text-primary"><?= number_format(ceil(($totalPrice) / 100)) ?> 원</strong>(총 주문 금액의 1%)</p>
            </div>
            <div>
                <hr>
                <p>최종 결제 금액: <strong class="text-success" id="finalPrice"><?= number_format($totalPrice) ?> 원</strong></p>
            </div>
            <button type="button" class="btn btn-primary w-100"
                    data-user="<?= htmlspecialchars($user['uid']) ?>"
                    data-cart="<?= htmlspecialchars(json_encode($cart), ENT_QUOTES, 'UTF-8') ?>"
                    data-finalPrice="<?= number_format($totalPrice) ?>"
                    onclick="createOrder(this)">주문하기
            </button>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/home/footer.php'; ?>
<script>
    // 모달 열기
    var myModal = document.getElementById('staticBackdrop')
    var myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', function () {
        myInput.focus()
    })
</script>
</body>
</html>
