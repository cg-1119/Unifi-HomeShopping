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
$point = $user['point'] ?? 0;
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
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/main/header.php'; ?>
<!-- 결제 모달 -->
<div class="modal fade" id="checkoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">결제 정보</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- 결제 수단 선택 -->
                <h6>결제 수단</h6>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="paymentCard" value="card" checked onclick="togglePaymentFields('card')">
                        <label class="form-check-label" for="paymentCard">카드 결제</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="paymentPhone" value="phone" onclick="togglePaymentFields('phone')">
                        <label class="form-check-label" for="paymentPhone">휴대폰 결제</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="paymentAccount" value="account" onclick="togglePaymentFields('account')">
                        <label class="form-check-label" for="paymentAccount">계좌 결제</label>
                    </div>
                </div>

                <!-- 결제 필드 -->
                <div id="cardFields" class="payment-fields">
                    <label for="cardNumber" class="form-label">카드 번호</label>
                    <input type="text" id="cardNumber" class="form-control" placeholder="카드 번호를 입력하세요">
                </div>
                <div id="phoneFields" class="payment-fields d-none">
                    <label for="phoneNumber" class="form-label">휴대폰 번호</label>
                    <input type="text" id="phoneNumber" class="form-control" placeholder="휴대폰 번호를 입력하세요">
                </div>
                <div id="accountFields" class="payment-fields d-none">
                    <label for="accountNumber" class="form-label">계좌 번호</label>
                    <input type="text" id="accountNumber" class="form-control" placeholder="계좌 번호를 입력하세요">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                <button type="button" class="btn btn-primary"
                        data-user="<?= htmlspecialchars($user['uid']) ?>"
                        data-cart="<?= htmlspecialchars(json_encode($cart), ENT_QUOTES, 'UTF-8') ?>"
                        data-finalPrice="<?= number_format($totalPrice) ?>"
                        onclick="createOrderPayment(this);">
                        결제 완료
                </button>
            </div>
        </div>
    </div>
</div>


<div id="orderData" style="display: none;"></div>

<div class="container mt-5">
    <h1 class="text-center m-5">주문하기</h1>
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
                <p>보유 포인트: <strong><?php echo number_format($point) ?> 원</strong></p>
                <label class="form-check-label">사용 포인트</label>
                <input type="number" name="point" class="form-control mb-2"
                       placeholder="사용할 포인트" min="0" max="<?= htmlspecialchars($point) ?>"
                       oninput="pointInputChange(this)">
                <p id="point">적립 예정 포인트: <strong class="text-primary"><?= number_format(ceil(($totalPrice) / 100)) ?> 원</strong>(총 주문 금액의 1%)</p>
            </div>
            <div>
                <hr>
                <p>최종 결제 금액: <strong class="text-success" id="finalPrice"><?= number_format($totalPrice) ?> 원</strong></p>
            </div>
            <button type="button" class="btn btn-primary w-100"
                    data-bs-toggle="modal" data-bs-target="#checkoutModal">주문하기
            </button>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/main/footer.php'; ?>
</body>
</html>