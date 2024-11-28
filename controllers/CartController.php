<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Cart.php';
header('Content-Type: text/html; charset=utf-8');

class CartController {
    private $cartModel;

    public function __construct() {
        $this->cartModel = new Cart();
    }

    // 장바구니에 상품 추가
    public function addToCart() {
        if (!isset($_SESSION)) session_start();

        $uid = $_SESSION['user']['uid'];
        $productId = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : 0;
        $quantity = isset($_POST["quantity"]) ? intval($_POST["quantity"]) : 1;

        if ($productId <= 0 || $quantity <= 0) {
            echo "<script>alert('잘못된 요청입니다.'); history.back();</script>";
            exit;
        }

        // 장바구니 추가
        $result = $this->cartModel->addToCart($uid, $productId, $quantity);

        if ($result) {
            echo "<script>alert('장바구니에 추가되었습니다.'); location.href='../views/user/cart/index.php';</script>";
        } else {
            echo "<script>alert('장바구니 추가에 실패했습니다.'); history.back();</script>";
        }
    }

    // 장바구니 조회
    public function viewCart() {
        if (!isset($_SESSION)) session_start();

        $uid = $_SESSION['user']['uid'];
        $cartItems = $this->cartModel->getCartItems($uid);

        return $cartItems;
    }

    // 장바구니 항목 삭제
    public function deleteCartItem() {
        if (!isset($_SESSION)) session_start();

        $cartId = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;

        if ($cartId <= 0) {
            echo "<script>alert('잘못된 요청입니다.'); history.back();</script>";
            exit;
        }

        $result = $this->cartModel->deleteCartItem($cartId);

        if ($result) {
            echo "<script>alert('장바구니 항목이 삭제되었습니다.'); location.href='/views/user/cart/index.php;</script>";
        } else {
            echo "<script>alert('장바구니 항목 삭제에 실패했습니다.'); history.back();</script>";
        }
    }
    // 수량 업데이트
    public function updateCartItem() {
        if (!isset($_SESSION)) session_start();

        $result = $this->cartModel->updateCartItem($_POST["cart_id"], $_POST["quantity"]);
        if ($result) echo "<script>location.href = '/views/user/cart/index.php';</script>";
        else echo "<script>alert('장바구니 개수 업데이트 실패.'); history.back();</script>";
    }

    // 장바구니 비우기
    public function clearCart() {
        if (!isset($_SESSION)) session_start();

        $uid = $_SESSION['user']['uid'];
        $result = $this->cartModel->clearCart($uid);

        if ($result) {
            echo "<script>alert('장바구니가 비워졌습니다.'); location.href='/cart/index.php';</script>";
        } else {
            echo "<script>alert('장바구니 비우기에 실패했습니다.'); history.back();</script>";
        }
    }
}

// POST 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new CartController();

    if ($_POST['action'] === 'add') {
        $controller->addToCart();
    } elseif ($_POST['action'] === 'delete') {
        $controller->deleteCartItem();
    } elseif ($_POST['action'] === 'clear') {
        $controller->clearCart();
    } elseif ($_POST['action'] === 'update') {
        $controller->updateCartItem();
    }
}
?>
