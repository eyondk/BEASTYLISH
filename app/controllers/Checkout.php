<?php
require_once '../public/vendor/autoload.php';

class Checkout extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === null) {
            header('Location: home/login');
            exit();
        }

        $checkoutData = $_SESSION['checkoutData'] ?? null;
        if ($checkoutData) {
            $checkoutData = json_decode($checkoutData, true);
            unset($_SESSION['checkoutData']);
        }

        $this->view('customer/checkout', $checkoutData);
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonData = file_get_contents('php://input');
            $requestData = json_decode($jsonData, true);

            if (isset($requestData['selected_items'])) {
                $selectedItems = $requestData['selected_items'];
                $shopcartModel = new Shopcart();
                $cartItems = $shopcartModel->get_cart_items_by_ids(array_column($selectedItems, 'cart_id'));

                $subtotal = 0;
                foreach ($cartItems as &$item) {
                    $itemIndex = array_search($item['cart_id'], array_column($selectedItems, 'cart_id'));
                    if ($itemIndex !== false) {
                        $item['cart_qty'] = $selectedItems[$itemIndex]['cart_qty'];
                        $item['subtotal'] = $item['prod_price'] * $item['cart_qty'];
                        $subtotal += $item['subtotal'];
                    }
                }

                $delivery_fee = 90;
               
                $total = $subtotal + $delivery_fee;

                $data = [
                    'cart_items' => $cartItems,
                    'subtotal' => $subtotal,
                    'delivery_fee' => $delivery_fee,
                    'discount' => $discount,
                    'total' => $total,
                ];

                $_SESSION['checkoutData'] = json_encode($data);
                echo json_encode(['success' => true, 'data' => $data]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No items selected']);
            }
        } else {
            header('Location: ' . ROOT . '/Cart');
            exit;
        }
    }

    public function confirmOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonData = file_get_contents('php://input');
            $requestData = json_decode($jsonData, true);

            if (!isset($requestData['order_subtotal'], $requestData['order_total'], $requestData['cus_id'], $requestData['payment_method'], $requestData['pstat_id'])) {
                echo json_encode(['success' => false, 'error' => 'Missing required fields']);
                exit;
            }

            $orderModel = new Checkouts();
            $shopcartModel = new Shopcart();

            try {
                if ($requestData['payment_method'] === 'COD' ||$requestData['payment_method'] === 'MEET UP' ) {
                    $orderId = $orderModel->createOrder($requestData, $requestData['cart_items']);
                    foreach ($requestData['cart_items'] as $item) {
                        $shopcartModel->remove_from_cart($item['cart_id']);
                    }

                    echo json_encode(['success' => true, 'order_id' => $orderId]);
                } else if ($requestData['payment_method'] === 'PAYPAL') {
                    $requestData['pstat_id'] = 2;
                    $orderId = $orderModel->createOrder($requestData, $requestData['cart_items']);
                    foreach ($requestData['cart_items'] as $item) {
                        $shopcartModel->remove_from_cart($item['cart_id']);
                    }
                    echo json_encode(['success' => true, 'message' => 'Proceeding with PayPal payment']);
                } else if (in_array($requestData['payment_method'], ['GCASH', 'UNION BANK'])) {
                    $client = new \GuzzleHttp\Client();
                    $response = $client->post('https://api.paymongo.com/v1/links', [
                        'json' => [
                            'data' => [
                                'attributes' => [
                                    'amount' => $requestData['order_total'] * 100,
                                    'description' => 'Order payment',
                                    'remarks' => 'Payment for order ID: 1'
                                ]
                            ]
                        ],
                        'headers' => [
                            'accept' => 'application/json',
                            'authorization' => 'Basic c2tfdGVzdF9NYVVlQzRKTXg1Y3RZZ3Y3S2tnSFpaWmU6',
                            'content-type' => 'application/json',
                        ],
                    ]);

                    $apiResponse = json_decode($response->getBody(), true);
                    $checkoutUrl = $apiResponse['data']['attributes']['checkout_url'] ?? null;
                    $paymentLinkId = $apiResponse['data']['id'] ?? null;

                    if ($checkoutUrl) {
                        $_SESSION['paymentLinkId'] = $paymentLinkId;
                        echo json_encode(['success' => true, 'checkout_url' => $checkoutUrl]);
                    } else {
                        throw new Exception('Checkout URL not found in response');
                    }
                } else {
                    throw new Exception('Unsupported payment method');
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
        }
    }

    public function paymentConfirmation()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $paymentLinkId = $_SESSION['paymentLinkId'] ?? null;

            if (!$paymentLinkId) {
                error_log("Payment link ID not found in session.");
                echo json_encode(['success' => false, 'error' => 'Payment link ID not found in session']);
                exit;
            }

            $client = new \GuzzleHttp\Client();

            try {
                $response = $client->request('GET', 'https://api.paymongo.com/v1/links/' . $paymentLinkId, [
                    'headers' => [
                        'accept' => 'application/json',
                        'authorization' => 'Basic c2tfdGVzdF9NYVVlQzRKTXg1Y3RZZ3Y3S2tnSFpaWmU6',
                    ],
                ]);

                $apiResponse = json_decode($response->getBody(), true);
                $paymentStatus = $apiResponse['data']['attributes']['status'] ?? null;

                if ($paymentStatus === 'paid') {
                    $orderModel = new Checkouts();
                    $orderId = $orderModel->createOrder($_SESSION['checkoutData'], $_SESSION['cart_items']);
                    $orderModel->updateOrderStatus($orderId, 'paid');

                    $shopcartModel = new Shopcart();
                    foreach ($_SESSION['cart_items'] as $item) {
                        $shopcartModel->remove_from_cart($item['cart_id']);
                    }

                    echo json_encode(['success' => true, 'message' => 'Order status updated to paid']);
                } else {
                    error_log("Payment not confirmed. Status: " . $paymentStatus);
                    echo json_encode(['success' => false, 'error' => 'Payment not confirmed']);
                }
            } catch (Exception $e) {
                error_log("Error checking payment status: " . $e->getMessage());
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
        }
    }
}
