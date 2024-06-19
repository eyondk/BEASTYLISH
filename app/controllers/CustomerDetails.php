<?php
class CustomerDetails extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] === null) {
            // Redirect to the login page
            header('Location: home/login'); // Adjust the path as needed for your application
            exit();
        }
        $cus_id = isset($_GET['cus_id']) ? $_GET['cus_id'] : null;
        
        if ($cus_id === null) {
            header('Location: ' . ROOT . 'Customer');
            exit;
        }

        $cus = new Customers;
        $customerData = $cus->getCustomerDetailsById($cus_id);

        if (!$customerData['success']) {
            header('Location: ' . ROOT . 'Customer');
            exit;
        }

        // Structure the data for the view
        $data = [
            'customer' => $customerData['data']['customer'],
            'total_orders' => $customerData['data']['total_orders'],
            'total_spent' => $customerData['data']['total_spent']
        ];

        $this->view('admin/CustomerDetails', $data);
    }

    public function deleteCustomer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerId = isset($_POST['customer_id']) ? $_POST['customer_id'] : null;
    
            if ($customerId === null) {
                echo json_encode(['status' => 'error', 'message' => 'Customer ID is required']);
                exit();
            }
    
            $cus = new Customers();
    
            if ($cus->hasOrders($customerId)) {
                echo json_encode(['status' => 'error', 'message' => 'Cannot delete customer with associated orders.']);
                exit();
            }
            else{
            if ($cus->deleteCustomerById($customerId)) {
                echo json_encode(['status' => 'success', 'message' => 'Customer successfully deleted.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete customer.']);
            }
        }
        }
    }
    
    
}
