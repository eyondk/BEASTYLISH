<?php

class Customer {

    use Model;

    protected $table = 'CUSTOMER';

    protected $allowedColumns = [
        'CUS_ID',
        'CUS_FNAME',
        'CUS_LNAME',
        'CUS_EMAIL',
        'CUS_USERNAME',
        'CUS_PHONENUM',
        'CUS_PROFILE',
        'CUS_SEX',
        'CUS_RESETTOKEN',
        'CUS_RESETEXPIRED',
        'CUS_TYPE',
        'CUS_PASSWORDHASH',
        'CUS_PASSWORDSALT',
        'add_street',
        'add_city',
        'add_province',
        'add_infoaddress'
    ];

    public function getByEmail($email) {
        return $this->first(['CUS_EMAIL' => $email]);
    }

    public function getByUsername($username) {
        return $this->first(['CUS_USERNAME' => $username]);
    }

    public function getByPhone($phone) {
        return $this->first(['CUS_PHONENUM' => $phone]);
    }

    // public function getByToken($token) {
    //     return $this->first(['CUS_RESETTOKEN' => $token]);
    // }


    public function getByToken($token)
{
    echo "Looking for token: " . htmlspecialchars($token) . "<br>";
    
    try {
        $conn = $this->connect();
        $stmt = $conn->prepare("
            SELECT *
            FROM {$this->table}
            WHERE CUS_RESETTOKEN = :token
            LIMIT 1
        ");
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Debugging output
        echo "Query result: ";
        print_r($result);
        
        return $result;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}

    
    
    // public function getByToken($token) {
    //     // Debug output to check the input token
    //     echo "Looking for token: " . htmlspecialchars($token) . "<br>";

    //     // Query to fetch customer by reset token
    //     $query = "SELECT * FROM {$this->table} WHERE CUS_RESETTOKEN = :token LIMIT 1";
    //     $data = ['token' => $token];

    //     // Execute the query
    //     $result = $this->query($query, $data);

    //     if ($result && isset($result[0])) {
    //         $customer = $result[0];
    //         echo "Token found: " . htmlspecialchars($customer->CUS_RESETTOKEN) . "<br>";
    //         echo "Expiry: " . htmlspecialchars($customer->CUS_RESETEXPIRED) . "<br>";
    //         return $customer;
    //     } else {
    //         echo "Token not found or invalid.<br>";
    //         return false;
    //     }
    // }
    

    // public function updateResetToken($userId, $resetToken, $resetExpiry) {
    //     $data = [
    //         'CUS_RESETTOKEN' => $resetToken,
    //         'CUS_RESETEXPIRED' => $resetExpiry
    //     ];
    //     return $this->update($userId, $data, 'cus_id');
    // }
    public function updateResetToken($userId, $resetToken, $resetExpiry) {
        $data = [
            'CUS_RESETTOKEN' => $resetToken,
            'CUS_RESETEXPIRED' => $resetExpiry
        ];
        return $this->update($userId, $data, 'CUS_ID');
    }

    public function updatePassword($userId, $passwordHash, $salt) {
        $data = [
            'CUS_PASSWORDHASH' => $passwordHash,
            'CUS_PASSWORDSALT' => $salt,
            'CUS_RESETTOKEN' => null,
            'CUS_RESETEXPIRED' => null
        ];
        return $this->update($userId, $data, 'CUS_ID');
    }
    
    


    public function getByCustomerId($cus_id) {
        // Ensure the method uses the correct column names
        return $this->where(['cus_id' => $cus_id]);
    }


    // public function getDetailsByEmail($column, $email) {
    //     return $this->getDetailsByEmail($this->table, $column, $email);
    // }


    public function updateCustomerInfo($userId, $data) {
        return $this->update($userId, $data, 'CUS_ID');
    }

    public function getByResetToken($token) 
    {
       
        $query = 'SELECT * FROM customers WHERE cus_reset_token = :token LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the user as an object
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        // Return the user object or false if no user found
        return $user ?: false;
    }
    
    

    public function getLastInsertedCustomerID() {
        try {
            $conn = $this->connect();
            $stmt = $conn->prepare("
                SELECT cus_id 
                FROM customer 
                ORDER BY cus_id DESC 
                LIMIT 1
            ");
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['cus_id'] ?? null;
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return null;
        }
    }

    public function insertCustomer($data) {
        return $this->insert($data);
    }
     
}
?>
