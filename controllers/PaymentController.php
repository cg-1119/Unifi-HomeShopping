<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/Payment.php";
header('Content-Type: text/html; charset=utf-8');
class PaymentController
{
    private $paymentModel;
    public function __construct()
    {
        $this->paymentModel = new Payment();
    }

    public function addPayment()
    {
        try {
            $inputData = json_decode(file_get_contents('php://input'), true);

            if (!$inputData) {
                echo json_encode(['success' => false, 'message' => '요청 데이터가 잘못되었습니다.']);
            }

            $orderId = $inputData["orderId"] ?? null;
            $userId = $inputData["userId"] ?? null;
            $paymentPrice = $inputData["paymentPrice"] ?? null;
            $point = $inputData["point"] ?? null;
            $paymentMethod = $inputData["paymentMethod"] ?? null;
            $paymentInfo = $inputData["paymentInfo"] ?? null;

            // 금액 숫자만 추출
            $paymentPrice = preg_replace('/[^\d]/', '', $paymentPrice);

            if ($paymentPrice <= 0) {
                echo json_encode(['success' => false, 'message' => '유효하지 않은 결제 금액입니다.']);
            }
            // 결제 저장 및 주문 상태 변경
            $this->paymentModel->setPayment($orderId, $paymentMethod, $paymentInfo, $paymentPrice);
            $this->paymentModel->setOrderStatus($orderId, 'completed');
            // 포인트 모델 생성
            require_once $_SERVER['DOCUMENT_ROOT'] . "/models/Point.php";
            $pointModel = new Point();
            $pointModel->addUserPoint($userId, $orderId, $paymentPrice, 'purchase');
            // 포인트를 사용 했을 때
            if($point) {
                preg_replace('/[^\d]/', '', $point);
                $pointModel->reducePoint($userId, $orderId, $point, 'use');
                $_SESSION['user']['point'] = $pointModel->getUserPoint($userId);
            }

            // 세션 초기화
            if (session_status() === PHP_SESSION_NONE)
                session_start();
            unset($_SESSION['cart']);

            echo json_encode(['success' => true, 'orderId' => $orderId, 'message' => '결제가 성공적으로 처리되었습니다.']);

        } catch (Exception $e) {
            error_log("addPayment error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => '결제 처리 중 오류가 발생했습니다.']);
        }
    }
    public function getPaymentByOrderId($orderId)
    {
        try {
            return $this->paymentModel->getPaymentByOrderId($orderId);
        } catch (Exception $e){
            error_log("getPaymentByOrderId error: " . $e->getMessage());
            return null;
        }
    }
    public function getAllPayments()
    {
        try {
            $payments = $this->paymentModel->getAllPayments();
            return $payments;
        } catch (Exception $e){
            error_log("getAllPayments error: " . $e->getMessage());
            return null;
        }
    }
}

// 요청 처리
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($data)) {
    $controller = new PaymentController();

    if ($data['action'] === 'addPayment') {
        $controller->addPayment();
    }
}