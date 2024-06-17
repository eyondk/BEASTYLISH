<?php

class Admin{
    use Model;

    protected $table = 'ADMIN';

    protected $allowedColumns = [
        'admin_id',
        'admin_fname',
        'admin_lname',
        'admin_email',
        'admin_username',
        'admin_passwordhash',
        'admin_passwordsalt',
        'admin_profile',
        'admin_resettoken',
        'admin_resetexpired',
        'admin_sex',
        'admin_phonenum',
    ];

    public function getByEmail($email) {
        return $this->first(['admin_email' => $email]);
    }

    public function getByUsername($username) {
        return $this->first(['admin_email' => $username]);
    }

    public function getByPhone($phone) {
        return $this->first(['admin_phonenum' => $phone]);
    }

    public function updateResetToken($userId, $resetToken, $resetExpiry) {
        return $this->update($userId, [
            'admin_resettoken' => $resetToken,
            'admin_resetexpired' => $resetExpiry
        ], 'admin_id');
    }


    public function updateProfile($userId, $data) {
        return $this->update($userId, $data, 'CUS_ID');
    }
    public function getById($id) {
        return $this->first(['admin_id' => $id]);
    }
}
