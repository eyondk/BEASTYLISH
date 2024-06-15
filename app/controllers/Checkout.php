<?php
require_once '../public/vendor/autoload.php';

class Checkout extends Controller
{
    public function index()
    {
        // Check if there is checkout data in session storage
        $checkoutData = $_SESSION['checkoutData'] ?? null;
        if ($checkoutData) {
            $checkoutData = json_decode($checkoutData, true);
            unset($_SESSION['checkoutData']); // Clear the session data after retrieving
        }

        // Pass the data to the view
        $this->view('customer/checkout', $checkoutData);
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Decode the JSON data from the request body
            $jsonData = file_get_contents('php://input');
            $requestData = json_decode($jsonData, true);

            if (isset($requestData['selected_items'])) {
                $selectedItems = $requestData['selected_items'];

                // Fetch item details from the database using the new function
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

                // Store the data in session storage and return success response
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
                $response = $client->post('https://api.paymongo.com/v1/links', [
                    'json' => [
                        'data' => [
                            'attributes' => [
                                'amount' => 10000, // Amount in cents (Php 100.00)
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

                if ($checkoutUrl) {
                    header('Location: ' . $checkoutUrl);
                    exit;   
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

}

