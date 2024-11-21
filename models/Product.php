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
        $stmt = $con->prepare("SELECT product_id, name, price, image_url, category FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($productId, $productName, $productPrice, $productImage, $productCategory);
        if ($stmt->fetch()) {
            $product = array(
                'product_id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'image_url' => $productImage,
                'category' => $productCategory
            );
        } else {
            $product = null;
        }
        $stmt->close();
        $con->close();
        return $product;
    }

    public function getProductDetailsById($productId)
    {
        $con = $this->db->connect();
        $stmt = $con->prepare("SELECT description, option_name, option_value FROM product_details WHERE product_id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $details = array();
        while ($row = $result->fetch_assoc()) {
            $details[] = $row;
        }
        $stmt->close();
        $con->close();
        return $details;
    }

    public function getProducts($category = null)
    {
        $con = $this->db->connect();
        if ($category) {
            $stmt = $con->prepare("SELECT product_id, name, price, image_url FROM products WHERE category = ?");
            $stmt->bind_param("s", $category);
        } else {
            $stmt = $con->prepare("SELECT product_id, name, price, image_url FROM products");
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
                    'image_url' => $imageUrl
                );
            }
        }

        $stmt->close();
        $con->close();
        return $products;
    }

    public function addProduct($category, $name, $price, $imageUrl)
    {
        $con = $this->db->connect();
        $stmt = $con->prepare("INSERT INTO products (category, name, price, image_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $category, $name, $price, $imageUrl);
        $stmt->execute();
        $productId = $stmt->insert_id;
        $stmt->close();
        $con->close();
        return $productId;
    }

    public function addProductDetail($productId, $description)
    {
        $con = $this->db->connect();
        $stmt = $con->prepare("INSERT INTO product_details (product_id, description) VALUES (?, ?)");
        $stmt->bind_param("is", $productId, $description);
        $result = $stmt->execute();
        $stmt->close();
        $con->close();
        return $result;
    }
}

?>