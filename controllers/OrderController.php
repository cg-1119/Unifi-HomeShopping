<?php
require_once $_SERVER['DOCUMENT_ROOT'] . ('/models/Order.php');
require_once $_SERVER['DOCUMENT_ROOT'] . ('/models/OrderDetail.php');

class OrderController
{
    private $orderModel;
    private $orderDetailModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->orderDetailModel = new OrderDetail();
    }

    public function createOrder()
    {
        try {
            $uid = $_POST['uid'] ?? null;
            $address = $_POST['address'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $cart = json_decode($_POST['cart'], true);
            $finalPrice = $_POST["finalPrice"] ?? 0;


            $orderId = $this->orderModel->createOrder($uid, $address, $phone);

            foreach ($cart as $item) $this->orderDetailModel->addOrderDetail($orderId, $item['id'], $item['quantity'], $item['price']);

            $_SESSION['order_id'] = $orderId;
            echo json_encode(['success' => true, 'orderId' => $orderId, 'finalPrice' => $finalPrice], );
        } catch (PDOException $e) {
            error_log("주문 생성 오류: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => '주문 생성 중 오류가 발생했습니다.']);
        }
    }

    public function cancelOrder()
    {
        try {
            $orderId = $_POST['orderId'];
            $this->orderModel->updateOrderStatus($orderId, 'cancelled');
            echo json_encode(['success' => true, 'message' => '주문이 취소되었습니다.']);
        } catch (PDOException $e) {
            error_log("주문 취소 오류" . $e->getMessage());
            echo json_encode(['success' => false, 'message' => '주문이 취소 중 오류가 발생하였습니다.']);
        }
    }
    public function updateOrderStatus()
    {
        try {
            // JSON 데이터를 읽어서 배열로 변환
            $inputData = json_decode(file_get_contents('php://input'), true);

            $orderId = $inputData['order_id'] ?? null;
            $orderStatus = $inputData['status'] ?? null;

            if (!$orderId || !$orderStatus) {
                echo json_encode(['success' => false, 'message' => '유효하지 않은 요청 데이터입니다.']);
                return;
            }

            // Order 모델에서 상태 업데이트
            $this->orderModel->updateOrderStatus($orderId, $orderStatus);

            echo json_encode(['success' => true, 'message' => '주문 상태가 업데이트되었습니다.']);
        } catch (Exception $e) {
            error_log("주문 상태 업데이트 오류: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => '주문 상태 업데이트 중 오류가 발생했습니다.']);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $controller = new OrderController();
    if ($_POST["action"] === "createOrder") $controller->createOrder();
    else if ($_POST["action"] === "cancelOrder") $controller->cancelOrder();

    $inputData = json_decode(file_get_contents('php://input'), true);
    if ($inputData && $inputData['action'] === 'updateOrderStatus' ){
        $controller->updateOrderStatus();
    }
}

?>