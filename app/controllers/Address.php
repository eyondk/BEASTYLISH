<?php

class Address extends Controller {

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cus_id = $_SESSION['temp_cus_id'] ?? null;

            // Validate cus_id
            if (!$cus_id) {
                return $this->view("address", ['message' => 'Customer ID not found']);
            }

            // Sanitize inputs
            $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $province = filter_input(INPUT_POST, 'province', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Prepare data for insertion
            $data = [
                'add_street' => $street,
                'add_city' => $city,
                'add_province' => $province,
                'cus_id' => $cus_id
            ];

            $addressModel = new AddressModel();
            try {
                $addressModel->insert($data);
                unset($_SESSION['temp_cus_id']); // Clear temporary customer ID
                header('Location: ' . ROOT . '/login');
                exit();
            } catch (Exception $e) {
                // Handle insertion failure
                return $this->view("address", ['message' => $e->getMessage()]);
            }
        }

        $this->view("address");
    }


   
}

?>
