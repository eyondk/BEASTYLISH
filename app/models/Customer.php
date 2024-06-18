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

    public function getByToken($token) {
        return $this->first(['CUS_RESETTOKEN' => $token]);
    }
    

    public function updateResetToken($userId, $resetToken, $resetExpiry) {
        $data = [
            'CUS_RESETTOKEN' => $resetToken,
            'CUS_RESETEXPIRED' => $resetExpiry
        ];
        return $this->update($userId, $data, 'cus_id');
    }
    

    public function updatePassword($userId, $passwordHash, $salt) {
        $data = [
            'CUS_PASSWORD' => $passwordHash,
            'CUS_SALT' => $salt,
            'CUS_RESETTOKEN' => null,
            'CUS_RESETEXPIRED' => null
        ];
        return $this->update($userId, $data, 'cus_id');
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
        $query = "SELECT currval('customer_cus_id_seq') AS last_insert_id";
        $result = $this->query($query);
        if ($result && isset($result[0]['last_insert_id'])) {
            return $result[0]['last_insert_id'];
        }
        return false;
    }

    public function insertCustomer($data) {
        return $this->insert($data);
    }

    public function getCustomerCity($cus_id) {
    try {
        $conn = $this->connect();
        $stmt = $conn->prepare("
            SELECT add_city 
            FROM address 
            WHERE cus_id = :cus_id
        ");
        $stmt->bindParam(':cus_id', $cus_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['add_city'] ?? null;
    } catch (PDOException $e) {
        error_log('Database error: ' . $e->getMessage());
        return null;
    }
     
}
?>
