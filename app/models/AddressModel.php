<?php

class AddressModel {
    use Model;

    protected $table = 'ADDRESS';

    protected $allowedColumns = [
        'add_id',
        'add_street',
        'add_city',
        'add_province',
        'add_infoaddress',
        'cus_id'
    ];

    // public function getByCustomerId($cus_id) {
    //     $query = "SELECT ADDRESS.add_id 
    //               FROM ADDRESS 
    //               JOIN CUSTOMER ON ADDRESS.cus_id = CUSTOMER.cus_id 
    //               WHERE ADDRESS.cus_id = ?";
    //     return $this->query($query, [$cus_id]);
    // }
    

    // public function getById($add_id) {
    //     return $this->first(['add_id' => $add_id]);
    // }

    // public function updateAddress($add_id, $data) {
    //     return $this->update($add_id, $data, 'add_id');
    // }


    public function getByCustomerId($cus_id) {
        $query = "SELECT add_id, add_street, add_city, add_province, add_infoaddress, cus_id 
                  FROM ADDRESS 
                  WHERE cus_id = ?";
        return $this->query($query, [$cus_id]);
    }

    public function updateAddressByCustomerId($cus_id, $data) {
        // Check if there's an existing address for the customer
        $existingAddress = $this->getByCustomerId($cus_id);

        if ($existingAddress) {
            // Update the existing address
            $address_id = $existingAddress[0]->add_id; // Assuming the first address found
            return $this->updateAddressInfo($address_id, $data);
        } else {
            // Insert a new address
            $data['cus_id'] = $cus_id;
            return $this->insertAddress($data);
        }
    }

    public function updateAddressInfo($add_id, $data) {
        return $this->update($add_id, $data, 'add_id');
    }

    public function deleteAddress($add_id) {
        return $this->delete($add_id, 'add_id');
    }

    public function insertAddress($data) {
        return $this->insert($data);
    }

    public function insertAddressForCustomer($cus_id, $addressData) {
        // Get the last inserted customer ID
        $lastInsertedCusId = $this->getLastInsertedCustomerID();
        
        if (!$lastInsertedCusId) {
            throw new Exception('Customer not found');
        }
        
        // Ensure the provided $cus_id matches the last inserted customer ID
        if ($lastInsertedCusId != $cus_id) {
            throw new Exception('Provided customer ID does not match the last inserted customer ID');
        }
        
        // Add cus_id to address data
        $addressData['cus_id'] = $cus_id;
        
        // Perform the address insertion
        return $this->insert($addressData);
    }

    

    // Helper function to get the last inserted customer ID
    protected function getLastInsertedCustomerID() {
        $query = "SELECT CUS_ID FROM CUSTOMER ORDER BY CUS_ID DESC LIMIT 1";
        $result = $this->query($query);
        if ($result && isset($result[0]['CUS_ID'])) {
            return $result[0]['CUS_ID'];
        }
        return null;
    }

 
   
}
?>
