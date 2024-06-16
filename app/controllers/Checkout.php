<?php
require_once '../public/vendor/autoload.php';

class Checkout extends Controller
{
    public function index()
    {
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
                $discount = 100;
                $total = $subtotal + $delivery_fee - $discount;

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
    header('Access-Control-Allow-Origin: http://localhost:3000/'); // Allow all domains
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Allowed methods
    header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allowed headers

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Decode the JSON data from the request body
        $jsonData = file_get_contents('php://input');
        $requestData = json_decode($jsonData, true);

        // Validate required fields
        if (!isset($requestData['order_subtotal'], $requestData['order_total'], $requestData['cus_id'], $requestData['payment_method'])) {
            echo json_encode(['success' => false, 'error' => 'Missing required fields']);
            exit;
        }

        $orderModel = new Checkouts();
        $shopcartModel = new Shopcart();

        try {
            if ($requestData['payment_method'] === 'COD') {
                // Handle Cash on Delivery logic here
                $orderId = $orderModel->createOrder($requestData, $requestData['cart_items']);

                // Clear the cart
                foreach ($requestData['cart_items'] as $item) {
                    $shopcartModel->remove_from_cart($item['cart_id']);
                }

                echo json_encode(['success' => true, 'order_id' => $orderId]);
            } else if (in_array($requestData['payment_method'], ['GCASH', 'UNION BANK'])) {
                // Process payment through the GCASH API
                $client = new \GuzzleHttp\Client();
                $response = $client->post('http://localhost/my-proxy-server/proxy.php', [
                    'json' => [
                        'data' => [
                            'attributes' => [
                                'amount' => $requestData['order_total'] * 100, // Amount in cents
                                'description' => 'Order payment',
                                'remarks' => 'Payment for order ID: ' . $orderId
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
                error_log(print_r($apiResponse, true)); // Log the API response for debugging

                $checkoutUrl = $apiResponse['data']['attributes']['checkout_url'] ?? null;

                if ($checkoutUrl) {
                    header('Location: ' . $checkoutUrl);
                } else {
                    // Handle the case where checkout URL is null or missing
                    error_log('Checkout URL not found in response');
                    echo json_encode(['success' => false, 'error' => 'Checkout URL not available']);
                }
            } else {
                throw new Exception('Unsupported payment method');
            }
        } catch (Exception $e) {
            // Log the error for debugging
            error_log('Error processing order: ' . $e->getMessage());
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    }
}


}
?>
