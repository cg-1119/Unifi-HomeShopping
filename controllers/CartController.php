<?php
session_start();

// 세션에서 장바구니 데이터 가져오기
$cart = $_SESSION['cart'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // AJAX 요청으로 전달된 JSON 데이터 디코딩
    $inputData = json_decode(file_get_contents('php://input'), true);

    // 요청 데이터 확인
    $action = $inputData['action'] ?? null;

    // 장바구니 추가
    if ($action === 'updateCart' && isset($inputData['cart']) && is_array($inputData['cart'])) {
        foreach ($inputData['cart'] as $productId => $item) {
            if (
                isset($item['id'], $item['name'], $item['price'], $item['thumbnail'], $item['quantity']) &&
                is_numeric($item['id']) &&
                is_numeric($item['price']) &&
                is_numeric($item['quantity'])
            ) {
                $cart[$productId] = [
                    'id' => $item['id'],
                    'name' => htmlspecialchars($item['name']),
                    'price' => floatval($item['price']),
                    'thumbnail' => htmlspecialchars($item['thumbnail']),
                    'quantity' => intval($item['quantity']),
                ];
            }
        }
        $_SESSION['cart'] = $cart;

        echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
        exit;
    }

    // 수량 업데이트
    if ($action === 'updateQuantity' && isset($inputData['product_id'], $inputData['quantity'])) {
        $productId = $inputData['product_id'];
        $quantity = intval($inputData['quantity']);

        if (isset($cart[$productId]) && $quantity > 0) {
            $cart[$productId]['quantity'] = $quantity;
            $_SESSION['cart'] = $cart;

            echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => '수량 업데이트 실패']);
        }
        exit;
    }

    // 아이템 삭제
    if ($action === 'remove' && isset($inputData['product_id'])) {
        $productId = $inputData['product_id'];

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $_SESSION['cart'] = $cart;

            echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => '상품 삭제 실패']);
        }
        exit;
    }

    // 장바구니 초기화
    if ($action === 'clear') {
        $cart = [];
        $_SESSION['cart'] = $cart;

        echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
        exit;
    }

    // 유효하지 않은 요청
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => '유효하지 않은 요청입니다.']);
    exit;
}

// 유효하지 않은 메서드
http_response_code(405);
echo json_encode(['success' => false, 'message' => '허용되지 않은 요청 방식입니다.']);
exit;
