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

    // 주문 생성
    public function createOrder()
    {
        try {
            $uid = $_POST['uid'] ?? null;
            $address = $_POST['address'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $cart = json_decode($_POST['cart'], true);
            $finalPrice = $_POST["finalPrice"] ?? 0;
            // 주문 등록
            $orderId = $this->orderModel->setOrder($uid, $address, $phone);
            // 주문 상세 정보 등록
            foreach ($cart as $item) $this->orderDetailModel->setOrderDetail($orderId, $item['id'], $item['quantity'], $item['price']);
            // 주문 정보 json 전달
            echo json_encode(['success' => true, 'orderId' => $orderId, 'userId' => $uid, 'finalPrice' => $finalPrice]);
        } catch (PDOException $e) {
            error_log("OrderController createOrder Exception: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => '주문 생성 중 오류가 발생했습니다.']);
            echo "<script>alert('주문 생성 중 오류가 발생했습니다.')</script>";
        }
    }

    // 주문 상태 업데이트
    public function updateOrderStatus()
    {
        try {
            // json 입력
            $inputData = json_decode(file_get_contents('php://input'), true);

            $orderId = $inputData['order_id'] ?? null;
            $orderStatus = $inputData['status'] ?? null;
            // 유효성 검증
            if (!$orderId || !$orderStatus) {
                echo json_encode(['success' => false, 'message' => '유효하지 않은 요청 데이터입니다.']);
                return;
            }
            // 주문 상태 업데이트
            $this->orderModel->updateOrderStatus($orderId, $orderStatus);
            echo json_encode(['success' => true, 'message' => '주문 상태가 업데이트되었습니다.']);
        } catch (Exception $e) {
            error_log("OrderController updateOrderStatus Exception: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => '주문 상태 업데이트 중 오류가 발생했습니다.']);
            echo "<script>alert('주문 상태 업데이트 중 오류가 발생했습니다.')</script>";
        }
    }

    // 사용자 주문 내역 조회
    public function showUserOrders($uid)
    {
        try {
            // 사용자 주문 조회
            $orders = $this->orderModel->getOrdersByUserid($uid);
            // 사용자 주문 상세 정보 조회
            foreach ($orders as $key => $order) {
                $orderDetails = $this->orderDetailModel->getOrderDetailsByOrderId($order['id']);
                $orders[$key]['details'] = $orderDetails; // 배열의 특정 키에 추가
            }
            // 주문 정보 세션에 업데이트
            $_SESSION['orders'] = $orders;
            header('Location: /views/user/mypage.php');
            exit;
        } catch (PDOException $e) {
            error_log('OrderController showUserOrders Exception: ', $e->getMessage());
            exit;
        }
    }

    // 주문 취소
    public function cancelOrder()
    {
        try {
            $orderId = $_POST['order_id'];
            $cancel_reason = $_POST['cancel_reason'] ?? null;
            // 주문 상태 업데이트
            $this->orderModel->updateOrderStatus($orderId, 'cancelled');
            $this->orderModel->updateOrderCancelReason($orderId, $cancel_reason);
            echo "<script>alert('주문이 취소되었습니다.'); location.href = '/controllers/OrderController.php?action=myPage';</script>";
        } catch (PDOException $e) {
            error_log("주문 취소 오류" . $e->getMessage());
            echo json_encode(['success' => false, 'message' => '주문이 취소 중 오류가 발생하였습니다.']);
            echo "<script>alert('유효하지 않은 요청입니다.'); history.back();</script>";
        }
    }


    // 관리자용
    // 배달 상태 업데이트
    public function updateDeliveryStatus()
    {
        try {
            $orderId = $_POST['order_id'] ?? null;
            $status = $_POST['delivery_status'] ?? null;
            // 배달 상태 업데이트
            $this->orderModel->updateDeliveryStatus($orderId, $status);
            header("Location: /views/admin/order_detail.php?order_id=$orderId");
        } catch (PDOException $e) {
            error_log("OrderController updateDeliveryStatus Exception: " . $e->getMessage());
            exit;
        }
    }

    public function processOrderCancellation()
    {
        $orderId = $_POST['order_id'] ?? null;
        if ($this->orderModel->updatecancellation($orderId))
            echo "<script>alert('취소 처리가 완료되었습니다.'); location.href = '../views/admin/canceled_order_management.php';</script>";
        else
            echo "<script>alert('취소 처리 중 오류가 발생했습니다.'); history.back();</script>";
    }
}

// 요청 처리
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $controller = new OrderController();
    if ($_POST["action"] === "createOrder") $controller->createOrder();
    else if ($_POST["action"] === "cancelOrder") $controller->cancelOrder();
    else if ($_POST["action"] === "updateDeliveryStatus") $controller->updateDeliveryStatus();
    else if ($_POST["action"] === "processCancellation") $controller->processOrderCancellation();

    $inputData = json_decode(file_get_contents('php://input'), true);
    if ($inputData && $inputData['action'] === 'updateOrderStatus') {
        $controller->updateOrderStatus();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $controller = new OrderController();
    if ($_GET['action'] === 'myPage') {
        session_start();
        $controller->showUserOrders($_SESSION['user']['uid']);
    }
}
?>