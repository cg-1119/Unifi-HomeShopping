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

            // 요청 데이터 추출
            $orderId = $inputData["orderId"] ?? null;
            $paymentMethod = $inputData["paymentMethod"] ?? null;
            $paymentPrice = $inputData["paymentPrice"] ?? null;
            $paymentInfo = $inputData["paymentInfo"] ?? null;

            // 결제 금액 변환 및 검증
            $paymentPrice = preg_replace('/[^\d]/', '', $paymentPrice); // 숫자만 추출
            $paymentPrice = (int)$paymentPrice;

            if ($paymentPrice <= 0) {
                echo json_encode(['success' => false, 'message' => '유효하지 않은 결제 금액입니다.']);
            }

            // 결제 데이터 삽입
            $this->paymentModel->setPayment($orderId, $paymentMethod, $paymentInfo, $paymentPrice);

            // 성공 응답 반환
            $_SESSION['cart'] = '';
            echo json_encode(['success' => true, 'orderId' => $orderId, 'message' => '결제가 성공적으로 처리되었습니다.']);

        } catch (Exception $e) {
            // 예외 처리
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