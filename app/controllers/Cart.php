<?php

class Cart extends Controller
{
    public function index()
    {
        if (isset($_SESSION['timeout']) && isset($_SESSION['last_activity'])) {
           
            if (time() - $_SESSION['last_activity'] > $_SESSION['timeout']) {
               
                session_unset(); // Unset all session variables
                session_destroy(); // Destroy the session
                header('Location: ' . ROOT . '/login');
                exit();
            } else {
                // Update last activity time
                $_SESSION['last_activity'] = time();
            }
        } else {
            // If timeout and last activity are not set, set them
            $_SESSION['timeout'] = 1800; // 1800 seconds = 30 minutes
            $_SESSION['last_activity'] = time();
        }
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === null) {
            // Redirect to the login page
            header('Location: home/login'); // Adjust the path as needed for your application
            exit();
        }
        
        $cart = new Shopcart();
        
        // $cus_id = $_SESSION['cus_id']; // Assuming customer ID is stored in session after login
        $cus_id = $_SESSION['user_id'];
        print_r($cus_id);
        $cart_items = $cart->get_cart_items($cus_id);
        
        $subtotal = 0;
        foreach ($cart_items as $item) {
            $subtotal += $item['prod_price'] * $item['cart_qty'];
        }
        $customerModel = new Customer();
        $customerCity = $customerModel->getCustomerCity($cus_id);
        
        $deliveryFee = $this->calculateDeliveryFee($customerCity);

        $total = $subtotal + $deliveryFee;// Add delivery fee and subtract discount
        
        $this->view('customer/cart', [
            'cart_items' => $cart_items,
            'subtotal' => $subtotal,
            'deliveryFee' => $deliveryFee,
            'total' => $total
        ]);
    }

    private function calculateDeliveryFee($cityName) {
        $feePerCity = [
            'Cebu City' => 100,
            'Mandaue City' => 150,
            'LAPU-LAPU CITY' => 120,
            // Add more cities and corresponding fees as needed
        ];

        $defaultFee = 90.00;
        
        // Return the fee for the specific city or the default fee if the city is not listed
        return isset($feePerCity[$cityName]) ? $feePerCity[$cityName] : $defaultFee;
    }

    
    // public function add()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         header('Content-Type: application/json'); // Ensure the response is JSON

    //         $input = json_decode(file_get_contents('php://input'), true);

    //         if (!isset($input['product_id']) || !isset($input['cart_qty'])) {
    //             echo json_encode(['success' => false, 'message' => 'Invalid input']);
    //             exit;
    //         }

    //         $cart = new Shopcart();
    //         $cus_id = 1; // Replace with actual customer ID

    //         $cartData = [
    //             'cart_qty' => $input['cart_qty'],
    //             'cart_status' => 'active',
    //             'cus_id' => $cus_id, // Replace with actual customer ID
    //             'prod_id' => $input['product_id']
    //         ];

    //         $added = $cart->add_to_cart($cartData);
    //         if ($added) {
    //             echo json_encode(['success' => true, 'message' => 'Product added to cart successfully.']);
    //         } else {
    //             echo json_encode(['success' => false, 'message' => 'Failed to add product to cart.']);
    //         }
    //         exit;
    //     }

    //     // If not a POST request, return an error response
    //     header('Content-Type: application/json');
    //     echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    // }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json'); // Ensure the response is JSON

            $input = json_decode(file_get_contents('php://input'), true);

            if (!isset($input['product_id']) || !isset($input['cart_qty'])) {
                echo json_encode(['success' => false, 'message' => 'Invalid input']);
                exit;
            }

            $cart = new Shopcart();

            $cus_id = $_SESSION['user_id']; // Replace with actual customer ID

            $cartData = [
                'cart_qty' => $input['cart_qty'],
                'cart_status' => 'active',
                'cus_id' => $cus_id, // Replace with actual customer ID
                'prod_id' => $input['product_id']
            ];

            $added = $cart->add_to_cart($cartData);
            if ($added) {
                echo json_encode(['success' => true, 'message' => 'Product added to cart successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add product to cart.']);
            }
            exit;
        }

        // If not a POST request, return an error response
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit;
    }


    public function update()
    {
        header('Content-Type: application/json'); // Ensure the response is JSON
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cart = new Shopcart();
            $cus_id = $_SESSION['user_id'];
    
            // Get the JSON input
            $input = json_decode(file_get_contents('php://input'), true);
    
            if (!isset($input['cart_id']) || !isset($input['cart_qty'])) {
                echo json_encode(['success' => false, 'message' => 'Invalid input']);
                exit;
            }
    
            $cart_id = $input['cart_id'];
            $cart_qty = $input['cart_qty'];
    
            $updated = $cart->update_cart_item($cart_id, $cart_qty);
            if ($updated) {
                echo json_encode(['success' => true, 'message' => 'Cart item updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update cart item.']);
            }
            exit;
        }
    
        // If not a POST request, return an error response
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit;
    }
    

    public function remove()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json'); // Ensure the response is JSON

            $input = json_decode(file_get_contents('php://input'), true);

            if (!isset($input['cart_id'])) {
                echo json_encode(['success' => false, 'message' => 'Invalid input']);
                exit;
            }

            $cart = new Shopcart();
            $cus_id = $_SESSION['user_id'];

            $cart_id = $input['cart_id'];

            $removed = $cart->remove_from_cart($cart_id);
            if ($removed) {
                echo json_encode(['success' => true, 'message' => 'Cart item removed successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove cart item.']);
            }
            exit;
        }

        // If not a POST request, return an error response
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit;
    }

    public function quantity()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        header('Content-Type: application/json'); // Ensure the response is JSON

        $input = json_decode(file_get_contents('php://input'), true);

        $product_id = $input['product_id'] ?? null;
        $cus_id = $_SESSION['user_id'];

        if ($product_id === null) {
            echo json_encode(['success' => false, 'message' => 'Product ID is required']);
            exit;
        }

        $cart = new Shopcart();
        $quantity = $cart->get_cart_quantity($cus_id, $product_id);
        

        // Debugging statement to verify server-side behavior
        error_log("Product ID: $product_id, Quantity: $quantity");

        echo json_encode(['success' => true, 'quantity' => $quantity]);
        exit;
    }

    // If not a POST request, return an error response
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    
    exit;
}


public function remove_all()
{
    header('Content-Type: application/json'); 

  
    $cus_id = $_SESSION['user_id'];

    $cart = new Shopcart();
    $removed = $cart->remove_all_from_cart($cus_id);

    if ($removed) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to remove all items']);
    }
    exit;
}


}