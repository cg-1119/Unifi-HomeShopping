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
        try
        {
            $userId = $_POST['userId'] ?? null;
            $address = $_POST['address'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $cart = json_decode($_POST['cart'], true);


            $orderId = $this->orderModel->createOrder($userId, $address, $phone);

            foreach ($cart as $item) $this->orderDetailModel->addOrderDetail($item['orderId'], $item['name'], $item['price'], $item['quantity']);

            echo json_encode(['success' => true, 'orderId' => $orderId]);
        } catch (PDOException $e) {
            error_log("주문 생성 오류: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => '주문 생성 중 오류가 발생했습니다.']);
        }
    }

    public function cancelOrder()
    {
        try
        {
            $orderId = $_POST['orderId'];
            $this->orderModel->updateOrderStatus($orderId, 'cancelled');
            echo json_encode(['success' => true, 'message' => '주문이 취소되었습니다.']);
        } catch (PDOException $e) {
            error_log("주문 취소 오류" . $e->getMessage());
            echo json_encode(['success' => false, 'message' => '주문이 취소 중 오류가 발생하였습니다.']);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $controller = new OrderController();
    if ($_POST["action"] === "createOrder") $controller->createOrder();
    else if ($_POST["action"] === "cancelOrder") $controller->cancelOrder();
}
?>