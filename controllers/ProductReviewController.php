<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/ProductReview.php';
header('Content-Type: text/html; charset=utf-8');

class ProductReviewController
{
    private $productReviewModel;

    public function __construct()
    {
        $this->productReviewModel = new ProductReview();
    }

    public function addProductReview()
    {
        // 입력 검증
        $productId = (int)$_POST['product_id'] ?? null;
        $userId = (int)$_POST['user_id'] ?? null;
        $rate = (int)$_POST['rate'] ?? null;
        $content = $_POST['content'] ?? null;

        if (!$productId || !$userId || !$rate || !$content) {
            die(json_encode(['error' => 'Invalid input. Please fill out the form correctly.']));
        }

        // 리뷰 저장을 먼저 시도하여 ID 생성
        $imagePath = null;
        $newReviewId = $this->productReviewModel->createEmptyReview($productId, $userId, $rate, $content);

        if (!$newReviewId) {
            die(json_encode(['error' => 'Failed to create review entry.']));
        }

        // 이미지 업로드 핸들링
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/reviews/' . $newReviewId . '/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = uniqid() . '-' . basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $imagePath = '/uploads/reviews/' . $newReviewId . '/' . $fileName;
                // 이미지 경로를 업데이트
                $this->productReviewModel->updateImagePath($newReviewId, $imagePath);
            } else {
                die(json_encode(['error' => 'Failed to upload the image.']));
            }
        }

        echo "<script>alert('상품이 성공적으로 등록되었습니다.'); window.close();</script>";
    }
}

// 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new ProductReviewController();

    if ($_POST['action'] === 'addProductReview') {
        $controller->addProductReview();
    }
}

