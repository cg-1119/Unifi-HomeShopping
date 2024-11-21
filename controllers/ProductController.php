<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Product.php';
header('Content-Type: text/html; charset=utf-8');

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function addProduct()
    {
        $category = isset($_POST['category']) ? trim($_POST['category']) : '';
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';

        // 이미지 업로드
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageName = $_FILES['image']['name'];

            // 이미지 파일 이름에서 공백을 '_'로 변경
            $imageName = str_replace(' ', '_', $imageName);

            // 이미지 저장 경로 설정
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/public/image/';
            $uploadFilePath = $uploadDir . $imageName;

            // 이미지 파일 포멧 확인
            $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
            $fileExtension = pathinfo($imageName, PATHINFO_EXTENSION);
            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                echo "<script>alert('이미지 파일 형식이 올바르지 않습니다. (허용된 형식: jpg, jpeg, png, gif)'); history.back();</script>";
                exit;
            }

            // 업로드 디렉토리가 없는 경우 생성
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            if (move_uploaded_file($imageTmpPath, $uploadFilePath)) {
                $imageUrl = '/public/image/' . $imageName;
            } else {
                echo "<script>alert('이미지 업로드 실패.'); history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('이미지를 선택해주세요.'); history.back();</script>";
            exit;
        }

        // 상품 삽입
        $productId = $this->productModel->addProduct($category, $name, $price, $imageUrl);

        if ($productId) {
            $detailResult = $this->productModel->addProductDetail($productId, $description);
            if ($detailResult) {
                echo "<script>alert('상품이 성공적으로 등록되었습니다.'); location.href = '/views/admin/index.php';</script>";
            } else {
                echo "<script>alert('상품 상세 정보 등록에 실패했습니다. 다시 시도해주세요.'); history.back();</script>";
            }
        } else {
            echo "<script>alert('상품 등록에 실패했습니다. 다시 시도해주세요.'); history.back();</script>";
        }
    }
}

// POST 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new ProductController();
    if ($_POST['action'] == 'addProduct') {
        $controller->addProduct();
    }
}

?>
