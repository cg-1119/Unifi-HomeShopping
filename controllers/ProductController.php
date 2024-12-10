<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Product.php';
header('Content-Type: application/json; charset=utf-8');

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

        // 상품 삽입
        $productId = $this->productModel->addProduct($category, $name, $price, $description);
        if (!$productId) {
            echo "<script>alert('상품 등록에 실패했습니다. 다시 시도해주세요.'); history.back();</script>";
            return;
        }

        // 썸네일 이미지 처리
        if (!$this->uploadThumbnail($productId)) {
            echo "<script>alert('썸네일 업로드에 실패했습니다. 다시 시도해주세요.'); history.back();</script>";
            return;
        }

        // 상품 설명 이미지 처리
        if (!$this->uploadDescriptionImages($productId)) {
            echo "<script>alert('상품 설명 이미지 업로드에 실패했습니다. 다시 시도해주세요.'); history.back();</script>";
            return;
        }

        echo "<script>alert('상품이 성공적으로 등록되었습니다.'); location.href = '/views/admin/index.php';</script>";
    }

    private function uploadThumbnail($productId)
    {
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $thumbnailTmp = $_FILES['thumbnail']['tmp_name'];
            $thumbnailName = basename($_FILES['thumbnail']['name']);
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/products/$productId/";

            // 디렉토리 생성
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $thumbnailPath = $uploadDir . $thumbnailName;

            // 파일 이동
            if (move_uploaded_file($thumbnailTmp, $thumbnailPath)) {
                $thumbnailUrl = "/uploads/products/$productId/$thumbnailName";
                return $this->productModel->addProductImage($productId, $thumbnailUrl, true);
            } else {
                error_log("Failed to upload thumbnail: " . $thumbnailName);
                return false;
            }
        }

        error_log("No thumbnail file uploaded or upload error.");
        return false;
    }

    private function uploadDescriptionImages($productId)
    {
        if (isset($_FILES['descriptionImages'])) {
            $uploadedFiles = $_FILES['descriptionImages'];
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/products/$productId/";

            // 디렉토리 생성
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($uploadedFiles['tmp_name'] as $index => $tmpName) {
                if ($uploadedFiles['error'][$index] === UPLOAD_ERR_OK) {
                    $fileName = basename($uploadedFiles['name'][$index]);
                    $filePath = $uploadDir . $fileName;

                    // 파일 이동
                    if (move_uploaded_file($tmpName, $filePath)) {
                        $fileUrl = "/uploads/products/$productId/$fileName";
                        $this->productModel->addProductImage($productId, $fileUrl, false);
                    } else {
                        error_log("Failed to upload description image: " . $fileName);
                        return false;
                    }
                }
            }
            return true;
        }
        error_log("No description images uploaded.");
        return true; // 설명 이미지는 필수가 아니므로 true 반환
    }
    public function searchProducts() {
        if (!isset($_GET['query'])) {
            http_response_code(400);
            echo json_encode(['error' => '검색어가 제공되지 않았습니다.']);
            return;
        }

        $query = trim($_GET['query']);
        if (empty($query)) {
            echo json_encode([]); // 검색어가 없을 때
            return;
        }

        try {
            $products = $this->productModel->searchProducts($query);
            echo json_encode($products);
        } catch (Exception $e) {
            error_log('컨트롤러 검색 중 오류 발생: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => '서버 내부 오류.']);
        }
    }


}


// 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new ProductController();
    if ($_POST['action'] == 'addProduct') {
        $controller->addProduct();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controller = new ProductController();
    if ($_GET['action'] == 'search')
        $controller->searchProducts();
}
?>
