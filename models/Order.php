<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
class Order
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // 주문 생성
    public function setOrder($uid, $address, $phone) {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, address, phone) 
                VALUES (:user_id, :address, :phone)");
        $stmt->execute([
            'user_id' => $uid,
            'address' => $address,
            'phone' => $phone,
        ]);
        return $pdo->lastInsertId(); // 생성된 주문 ID 반환
    }

    // 주문 상태 업데이트
    public function updateOrderStatus($orderId, $status) {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("UPDATE orders SET status = :status WHERE id = :order_id");
        $stmt->execute([
            'status' => $status,
            'order_id' => $orderId
        ]);
    }

    // 주문 취소 이유 업데이트
    public function updateOrderCancelReason($orderId, $cancel_reason) {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("
            UPDATE orders
            SET cancel_reason = :cancel_reason
            WHERE id = :order_id
        ");
            $stmt->bindParam(':cancel_reason', $cancel_reason, PDO::PARAM_STR);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("updateOrderCancelReason error: " . $e->getMessage());
            return false;
        }
    }

    // 주문 조회
    public function getOrderById($orderId) {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :order_id");
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("getOrderById error: " . $e->getMessage());
            return false;
        }
    }
    // 특정 사용자의 주문 조회
    public function getOrdersByUserid($uid) {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_date DESC");
        $stmt->bindparam(":user_id", $uid);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 관리자용
    // 모든 주문 가져오기
    public function getAllOrders($offset, $limit) {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("
            SELECT 
                o.id, 
                o.user_id, 
                o.order_date,
                o.status,
                o.delivery_status, 
                SUM(od.price * od.quantity) AS total_price
            FROM 
                orders o
            LEFT JOIN 
                order_details od ON o.id = od.order_id
            WHERE 
                o.status != 'cancelled'
            GROUP BY 
                o.id, o.user_id, o.order_date, o.status, o.delivery_status
            ORDER BY 
            o.order_date DESC
            LIMIT :offset, :limit
            ");
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("getAllOrders error: " . $e->getMessage());
            return false;
        }
    }
    // 전체 주문 수 가져오기
    public function getTotalOrderCount() {
        $pdo = $this->db->connect();
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM orders");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    // 배송 상태 기준 주문 가져오기
    public function getOrdersByDeliveryStatus($deliveryStatus, $offset, $limit) {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("
            SELECT 
                o.id, 
                o.user_id, 
                o.order_date,
                o.status,
                o.delivery_status, 
                SUM(od.price * od.quantity) AS total_price
            FROM 
                orders o
            LEFT JOIN 
                order_details od ON o.id = od.order_id
            WHERE 
                o.delivery_status = :delivery_status
            AND o.status != 'cancelled'
            GROUP BY 
                o.id, o.user_id, o.order_date, o.status, o.delivery_status
           ORDER BY 
            o.order_date DESC
            LIMIT :offset, :limit
                ");
            $stmt->bindparam(":delivery_status", $deliveryStatus, PDO::PARAM_STR);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("getOrdersByDeliveryStatus error: " . $e->getMessage());
            return false;
        }
    }
    // 배송 상태별 주문 수 가져오기
    public function getTotalOrderCountByDeliveryStatus($delivery_status) {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM orders WHERE delivery_status = :delivery_status");
        $stmt->bindParam(':delivery_status', $delivery_status, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // 취소된 주문 가져오기
    public function getCanceledOrders($offset, $limit, $isProcessed = null) {
        $pdo = $this->db->connect();
        try {
            $sql = "
            SELECT 
                o.id, 
                o.user_id, 
                o.order_date,
                o.cancel_reason,
                o.is_cancelled_by_admin,
                SUM(od.price * od.quantity) AS total_price
            FROM 
                orders o
            LEFT JOIN 
                order_details od ON o.id = od.order_id
            WHERE 
                o.status = 'cancelled'
        ";

            // 검색 조건 추가
            if ($isProcessed !== null) {
                $sql .= " AND o.is_cancelled_by_admin = :is_processed";
            }

            $sql .= "
            GROUP BY 
                o.id, o.user_id, o.order_date, o.cancel_reason, o.is_cancelled_by_admin
            ORDER BY 
                o.order_date DESC
            LIMIT :offset, :limit
        ";

            $stmt = $pdo->prepare($sql);

            // 바인딩
            if ($isProcessed !== null) {
                $stmt->bindParam(':is_processed', $isProcessed, PDO::PARAM_BOOL);
            }
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("getCanceledOrders error: " . $e->getMessage());
            return false;
        }
    }
    // 총 취소된 주문 수 가져오기
    public function getTotalCanceledOrderCount($isProcessed) {
        $pdo = $this->db->connect();
        try {
            $query = "SELECT COUNT(*) FROM orders WHERE status = 'cancelled'";
            if ($isProcessed !== null) {
                $query .= " AND is_cancelled_by_admin = :is_processed";
            }

            $stmt = $pdo->prepare($query);

            if ($isProcessed !== null) {
                $stmt->bindParam(':is_processed', $isProcessed, PDO::PARAM_INT);
            }

            $stmt->execute();
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("getTotalCanceledOrderCount error: " . $e->getMessage());
            return false;
        }
    }
    // 배송 상태 업데이트
    public function updateDeliveryStatus($orderId, $deliveryStatus) {
        $pdo = $this->db->connect();
        $stmt = $pdo->prepare("UPDATE orders SET delivery_status = :delivery_status WHERE id = :order_id");
        $stmt->execute([
            'delivery_status' => $deliveryStatus,
            'order_id' => $orderId
        ]);
    }
    // 취소 처리
    public function updatecancellation($orderId) {
        $pdo = $this->db->connect();
        try {
            $stmt = $pdo->prepare("UPDATE orders SET is_cancelled_by_admin = 1 WHERE id = :order_id");
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("cancellationProcess error: " . $e->getMessage());
            return false;
        }
    }
}
