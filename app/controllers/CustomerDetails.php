<?php
class CustomerDetails extends Controller
{
    public function index()
    {
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

        $this->view('CustomerDetails', $data);
    }
}
