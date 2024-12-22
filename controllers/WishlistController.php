<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Wishlist.php';

class WishlistController
{
    private $wishlistModel;
    public function __construct()
    {
        $this->wishlistModel = new Wishlist();
    }
    // 찜 추가
    public function addToWishlist()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => '로그인이 필요합니다.']);
            return;
        }
        try {
            $userId = $_SESSION['user']['uid'];
            $productId = $_POST['product_id'] ?? null;

            $result = $this->wishlistModel->setWishlist($userId, $productId);
            echo json_encode(['success' => $result]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    // 찜 제거
    public function removeFromWishlist()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => '로그인이 필요합니다.']);
            return;
        }
        try {
            $userId = $_SESSION['user']['uid'];
            $productId = $_POST['product_id'] ?? null;

            $result = $this->wishlistModel->removeFromWishlist($userId, $productId);
            echo json_encode(['success' => $result]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    // 찜 목록 조회
    public function getWishlist()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => '로그인이 필요합니다.']);
            return;
        }
        try {
            $userId = $_SESSION['user']['uid'];
            $wishlist = $this->wishlistModel->getWishlistByUser($userId);
            echo json_encode(['success' => true, 'wishlist' => $wishlist]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
// 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $controller = new WishlistController();

    switch ($action) {
        case 'add':
            $controller->addToWishlist();
            break;
        case 'remove':
            $controller->removeFromWishlist();
            break;
        default:
            echo json_encode(['success' => false, 'message' => '유효하지 않은 요청입니다.']);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? null;
    $controller = new WishlistController();

    switch ($action) {
        case 'list':
            $controller->getWishlist();
            break;
        default:
            echo json_encode(['success' => false, 'message' => '유효하지 않은 요청입니다.']);
    }
}