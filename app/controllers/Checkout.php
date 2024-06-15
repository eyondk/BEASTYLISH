<?php
//  require_once '../public/vendor/autoload.php';
/**
 *  Checkout class
 */
class Checkout extends Controller
{
    public function index()
    {
        // Check if there is checkout data in session storage
        $checkoutData = null;
        if (isset($_SESSION['checkoutData'])) {
            $checkoutData = json_decode($_SESSION['checkoutData'], true);
            unset($_SESSION['checkoutData']); // Clear the session data after retrieving
        }

        // Pass the data to the view
        $this->view('customer/checkout', $checkoutData);
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Decode the JSON data from the request body
            $jsonData = file_get_contents('php://input');
            $requestData = json_decode($jsonData, true);

            if (isset($requestData['selected_items'])) {
                $selectedItems = $requestData['selected_items'];

                // Fetch item details from the database using the new function
                $shopcartModel = new Shopcart;
                $cartItems = $shopcartModel->get_cart_items_by_ids(array_column($selectedItems, 'cart_id'));

                $subtotal = 0;
                foreach ($cartItems as &$item) {
                    $item['cart_qty'] = $selectedItems[array_search($item['cart_id'], array_column($selectedItems, 'cart_id'))]['cart_qty'];
                    $item['subtotal'] = $item['prod_price'] * $item['cart_qty'];
                    $subtotal += $item['subtotal'];
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
                exit;
            } else {
                echo json_encode(['success' => false, 'error' => 'No items selected']);
                exit;
            }
        } else {
            header('Location: ' . ROOT . '/Cart');
            exit;
        }


    }

    public function confirmOrder()
{
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Decode the JSON data from the request body
        $jsonData = file_get_contents('php://input');
        $requestData = json_decode($jsonData, true);

        // Validate required fields
        if (!isset($requestData['order_subtotal'], $requestData['order_total'], $requestData['cus_id'], $requestData['payment_method'])) {
            echo json_encode(['success' => false, 'error' => 'Missing required fields']);
            exit;
        }

        $orderModel = new Checkouts;
        $shopcartModel = new Shopcart;

        try {
            // Check for specific payment methods
            if (in_array($requestData['payment_method'], ['GCASH', 'UNION BANK'])) {
                $client = new \GuzzleHttp\Client();

                $response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
                    'body' => json_encode([
                        'data' => [
                            'attributes' => [
                                'amount' => $requestData['order_total'],
                                'description' => 'Order payment',
                                'remarks' => 'Payment for order ID: ' . $requestData['order_id'] // example remark
                            ]
                        ]
                    ]),
                    'headers' => [
                        'accept' => 'application/json',
                        'authorization' => 'Basic c2tfdGVzdF9NYVVlQzRKTXg1Y3RZZ3Y3S2tnSFpaWmU6',
                        'content-type' => 'application/json',
                    ],
                ]);

                $apiResponse = json_decode($response->getBody(), true);

                // Check if API request was successful
                if ($response->getStatusCode() !== 200 || !isset($apiResponse['data'])) {
                    echo json_encode(['success' => false, 'error' => 'Payment API request failed']);
                    exit;
                }

                // Assume you handle the API response appropriately here
                // e.g., store the payment link or payment status
            }

            // Create the order
            $orderId = $orderModel->createOrder($requestData, $requestData['cart_items']);

            // Clear the cart
            foreach ($requestData['cart_items'] as $item) {
                $shopcartModel->remove_from_cart($item['cart_id']);
            }

            echo json_encode(['success' => true, 'order_id' => $orderId]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    }
}




    


}
