<?php

class Customer extends Model {

    

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
        'CUS_PASSWORDSALT'
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

    public function updateResetToken($userId, $resetToken, $resetExpiry) {
        return $this->update($userId, [
            'CUS_RESETTOKEN' => $resetToken,
            'CUS_RESETEXPIRED' => $resetExpiry
        ], 'CUS_ID');
    }

    public function getById($id) {
        return $this->first(['CUS_ID' => $id]);
    }


    // public function getDetailsByEmail($column, $email) {
    //     return $this->getDetailsByEmail($this->table, $column, $email);
    // }


    public function updateCustomerInfo($userId, $data) {
        return $this->update($userId, $data, 'CUS_ID');
    }
}
?>