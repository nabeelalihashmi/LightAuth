<?php

namespace IconicCodes\LightAuth;

class LightAuthBase {
    public static $db;
    public static $users_table = 'users';
    public static $forgot_password_table = 'lightauthtokens';
    public static $profile_table = 'profiles';

    public static function sanitize($string) {
        return htmlspecialchars($string);
    }


    public static function getUserByEmail($email) {
        $userTable = self::$users_table;
        $query = "SELECT * FROM `{$userTable}` WHERE `email` = :email";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetchObject();
        return $user;
    }

    public static function generateToken() {
        return bin2hex(openssl_random_pseudo_bytes(16));
    }

    
}