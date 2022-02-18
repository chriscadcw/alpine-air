<?php
namespace App\Helpers;

use App\Lib\Database;

class UserHelper
{
    public static function checkLogin($email_address, $password)
    {
        $db = new Database;
        $db->query('SELECT id, password FROM users WHERE email_address = :email_address');
        $db->bind(':email_address', $email_address);
        $result = $db->single();
        if($result === false){
            return null;
        }
        if (password_verify($password, $result->password) === true) {
            return $result->id;
        }
        return null;
    }



}
