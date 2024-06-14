<?php

class Cart extends Controller
{
    public function index()
    {
        $cart = new Shopcart();
        
        // $cus_id = $_SESSION['cus_id']; // Assuming customer ID is stored in session after login
        $cus_id = 1;
        
        $cart_items = $cart->get_cart_items($cus_id);
        
        $subtotal = 0;
        foreach ($cart_items as $item) {
            $subtotal += $item['prod_price'] * $item['cart_qty'];
        }
        $total = $subtotal + 90.00 - 100.00; // Add delivery fee and subtract discount
    
        $this->view('customer/cart', [
            'cart_items' => $cart_items,
            'subtotal' => $subtotal,
            'total' => $total
        ]);
    }
    
    

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
            $cus_id = 1; // Replace with actual customer ID

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
            $cus_id = 1; // Replace with actual customer ID
    
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
            $cus_id = 1; // Replace with actual customer ID

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

}