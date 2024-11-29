<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    $action = $_POST['action'] ?? null;

    if ($action === 'updateCart') {
        $cart = json_decode(file_get_contents('php://input'), true)['cart'] ?? null;

        if ($cart) {
            $_SESSION['cart'] = $cart;
            echo json_encode(['message' => '장바구니가 업데이트되었습니다.']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => '장바구니 데이터가 올바르지 않습니다.']);
        }
    }
}
?>