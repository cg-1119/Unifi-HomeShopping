<?php
session_start();
$orderId = $_GET['order_id'] ?? null;
$paymentPrice = $_GET['payment_price'] ?? null;
if (!$orderId && !$paymentPrice) {
    die('유효하지 않은 접근입니다.');
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>결제하기</title>
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/custom-style.css">
    <style>
        .hidden { display: none; } /* 동적으로 보이지 않게 하기 위한 스타일 */
    </style>
    <script>
        // 결제 수단 변경 시 입력 필드 표시 제어
        function togglePaymentFields(selectedMethod) {
            // 모든 입력 필드 숨기기
            document.getElementById('card-fields').classList.add('hidden');
            document.getElementById('phone-fields').classList.add('hidden');
            document.getElementById('account-fields').classList.add('hidden');

            // 선택한 결제 수단의 필드만 표시
            if (selectedMethod === 'card') {
                document.getElementById('card-fields').classList.remove('hidden');
            } else if (selectedMethod === 'phone') {
                document.getElementById('phone-fields').classList.remove('hidden');
            } else if (selectedMethod === 'account') {
                document.getElementById('account-fields').classList.remove('hidden');
            }
        }
        function submitPayment() {
            const form = document.getElementById('paymentForm');
            const formData = new FormData(form);

            // AJAX 요청
            fetch('/controllers/PaymentController.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.close();
                    } else {
                        alert('결제 실패: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('결제 처리 오류:', error);
                });
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">결제하기</h1>
    <form id="paymentForm">
        <!-- 결제 수단 선택 -->
        <div class="mb-4">
            <h3>결제 수단</h3>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="paymentMethod" value="card" id="card" checked onclick="togglePaymentFields('card')">
                <label class="form-check-label" for="card">카드 결제</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="paymentMethod" value="phone" id="phone" onclick="togglePaymentFields('phone')">
                <label class="form-check-label" for="phone">휴대폰 결제</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="paymentMethod" value="account" id="account" onclick="togglePaymentFields('account')">
                <label class="form-check-label" for="account">계좌 결제</label>
            </div>
        </div>

        <!-- 카드 결제 입력 필드 -->
        <div id="card-fields" class="mb-4">
            <h4>카드 결제 정보</h4>
            <div class="mb-3">
                <label for="card-number" class="form-label">카드 번호 / CVV</label>
                <input type="text" name="paymentInfo" id="card-number" class="form-control" placeholder="카드 번호 입력">
            </div>
        </div>

        <!-- 휴대폰 결제 입력 필드 -->
        <div id="phone-fields" class="hidden mb-4">
            <h4>휴대폰 결제 정보</h4>
            <div class="mb-3">
                <label for="phone-number" class="form-label">휴대폰 번호</label>
                <input type="text" name="paymentInfo" id="phone-number" class="form-control" placeholder="휴대폰 번호 입력">
            </div>
        </div>

        <!-- 계좌 결제 입력 필드 -->
        <div id="account-fields" class="hidden mb-4">
            <h4>계좌 결제 정보</h4>
            <div class="mb-3">
                <label for="account-number" class="form-label">계좌 번호</label>
                <input type="text" name="paymentInfo" id="account-number" class="form-control" placeholder="계좌 번호 입력">
            </div>
        </div>

        <!-- 제출 버튼 -->
        <div class="text-center">
            <input type="hidden" name="orderId" value="<?= $orderId?>">
            <input type="hidden" name="paymentPrice" value="<?= $paymentPrice?>">
            <input type="hidden" name="action" value="addPayment">
            <button type="button" class="btn btn-primary" onclick="submitPayment()">결제 완료</button>
        </div>
    </form>
</div>
</body>
</html>

