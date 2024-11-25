<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getProductById($productId)
    {
        $con = $this->db->connect();
        $stmt = $con->prepare("SELECT product_id, name, price, category, description FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($productId, $productName, $productPrice, $productCategory, $productDescription);
        if ($stmt->fetch()) {
            $product = array(
                'product_id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'category' => $productCategory,
                'description' => $productDescription,
            );
        } else {
            $product = null;
        }
        $stmt->close();
        $con->close();
        return $product;
    }
    public function getProducts($category = null)
    {
        $con = $this->db->connect();

        if ($category) {
            $stmt = $con->prepare("
            SELECT 
                p.product_id, 
                p.name, 
                p.price, 
                pi.file_path AS image_url
            FROM 
                products p
            LEFT JOIN 
                product_images pi
            ON 
                p.product_id = pi.product_id AND pi.is_thumbnail = 1
            WHERE 
                p.category = ?
        ");
            $stmt->bind_param("s", $category);
        } else {
            $stmt = $con->prepare("
            SELECT 
                p.product_id, 
                p.name, 
                p.price, 
                pi.file_path AS image_url
            FROM 
                products p
            LEFT JOIN 
                product_images pi
            ON 
                p.product_id = pi.product_id AND pi.is_thumbnail = 1
        ");
        }

        $stmt->execute();
        $stmt->store_result();
        $products = array();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($productId, $name, $price, $imageUrl);
            while ($stmt->fetch()) {
                $products[] = array(
                    'product_id' => $productId,
                    'name' => $name,
                    'price' => $price,
                    'image_url' => $imageUrl ?: '/public/images/default.png'
                );
            }
        }

        $stmt->close();
        $con->close();
        return $products;
    }
    public function getProductImages($productId)
    {
        // 데이터베이스 연결
        $con = $this->db->connect();

        // SQL 쿼리: 특정 product_id에 연결된 이미지 목록 가져오기
        $stmt = $con->prepare("
        SELECT 
            file_path AS image_url, 
            is_thumbnail 
        FROM 
            product_images 
        WHERE 
            product_id = ?
    ");
        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        // 상품 ID 바인딩
        $stmt->bind_param("i", $productId);

        // 쿼리 실행
        $stmt->execute();

        // 결과 저장
        $stmt->store_result();
        $stmt->bind_result($imageUrl, $isThumbnail);

        // 결과를 배열로 변환
        $images = array();
        while ($stmt->fetch()) {
            $images[] = array(
                'image_url' => $imageUrl,
                'is_thumbnail' => $isThumbnail
            );
        }

        // 리소스 해제 및 연결 종료
        $stmt->close();
        $con->close();

        return $images;
    }



    public function addProduct($category, $name, $price, $description)
    {
        $con = $this->db->connect();
        $stmt = $con->prepare("INSERT INTO products (category, name, price, description) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }
        $stmt->bind_param("ssds", $category, $name, $price, $description);
        $stmt->execute();
        if (!$stmt->affected_rows) {
            die("Execute failed: " . $stmt->error);
        }
        $productId = $stmt->insert_id;
        $stmt->close();
        $con->close();
        return $productId;
    }

    public function addProductImage($productId, $filePath, $isThumbnail = false)
    {
        $con = $this->db->connect();
        $stmt = $con->prepare("INSERT INTO product_images (product_id, file_path, is_thumbnail) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        }

        $stmt->bind_param("isi", $productId, $filePath, $isThumbnail);
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        $stmt->close();
        $con->close();
        return true;
    }
}
?>