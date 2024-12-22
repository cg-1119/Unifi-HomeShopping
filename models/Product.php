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
        $pdo = $this->db->connect();

        try {
            $stmt = $pdo->prepare("SELECT id, name, price, category, description FROM products WHERE id = :product_id");
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Product By ID Error: " . $e->getMessage());
            return null;
        }
    }

    public function getProducts($category = null)
    {
        $pdo = $this->db->connect();

        try {
            if ($category) {
                $stmt = $pdo->prepare("
                SELECT 
                    p.id, 
                    p.name, 
                    p.price, 
                    pi.file_path AS image_url
                FROM 
                    products p
                LEFT JOIN 
                    product_images pi
                ON 
                    p.id = pi.product_id AND pi.is_thumbnail = 1
                WHERE 
                    p.category = :category
            ");
                $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            } else {
                $stmt = $pdo->prepare("
                SELECT 
                    p.id, 
                    p.name, 
                    p.price, 
                    pi.file_path AS image_url
                FROM 
                    products p
                LEFT JOIN 
                    product_images pi
                ON 
                    p.id = pi.product_id AND pi.is_thumbnail = 1
            ");
            }

            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 기본 이미지 처리
            foreach ($products as &$product) {
                if (!$product['image_url']) {
                    $product['image_url'] = '/public/images/default.png';
                }
            }

            return $products;
        } catch (PDOException $e) {
            error_log("Get Products Error: " . $e->getMessage());
            return null;
        }
    }

    public function getProductImages($productId)
    {
        $pdo = $this->db->connect();

        try {
            $stmt = $pdo->prepare("
            SELECT 
                file_path AS image_url, 
                is_thumbnail 
            FROM 
                product_images 
            WHERE 
                product_id = :product_id
        ");
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Product Images Error: " . $e->getMessage());
            return null;
        }
    }

    public function addProduct($category, $name, $price, $description)
    {
        $pdo = $this->db->connect();

        try {
            $stmt = $pdo->prepare("INSERT INTO products (category, name, price, description) VALUES (:category, :name, :price, :description)");
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->execute();
            return $pdo->lastInsertId(); // 삽입된 ID 반환
        } catch (PDOException $e) {
            error_log("Add Product Error: " . $e->getMessage());
            return null;
        }
    }

    public function addProductImage($productId, $filePath, $isThumbnail = false)
    {
        $pdo = $this->db->connect();

        try {
            $stmt = $pdo->prepare("INSERT INTO product_images (product_id, file_path, is_thumbnail) VALUES (:product_id, :file_path, :is_thumbnail)");
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':file_path', $filePath, PDO::PARAM_STR);
            $stmt->bindParam(':is_thumbnail', $isThumbnail, PDO::PARAM_BOOL);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Add Product Image Error: " . $e->getMessage());
            return false;
        }
    }

    public function searchProducts($query)
    {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("
              SELECT 
                p.id,   
                p.name, 
                p.price,
                pi.file_path AS product_image
            FROM 
                products p
            LEFT JOIN 
                product_images pi ON p.id = pi.product_id AND pi.is_thumbnail = 1
            WHERE 
                p.name LIKE :query
            ORDER BY 
                p.name ASC
        ");
            $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            error_log("검색 오류: " . $e->getMessage());
            return false;
        }
    }

}

?>