<?php

namespace IconicCodes\LightAuth;

use IconicCodes\LightAuth\LightAuthBase;

class LRegister extends LightAuthBase {
    public static function register($username, $email, $password, $require_email_activation) {
    
        $errors = [];

        $username = self::sanitize($username);
        $email = self::sanitize($email);
        $password = self::sanitize($password);

        if (empty($username)) {
            $errors['username'] = 'Username is required';
        }

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        }

        if (empty($password)) {
            $errors['password'] = 'Password is required';
        }

        if (count($errors) > 0) {
            return $errors;
        }

        $user = self::getUserByEmail($email);

        if ($user) {
            $errors['email'] = 'Email already exists';
            return $errors;
        }


        $query = "INSERT INTO `" . self::$users_table . "` (`username`, `email`, `password`, `active`) VALUES (:username, :email, :password, :active)";

        $stmt = self::$db->prepare($query);

        $stmt->bindParam(':username', $username);

        $stmt->bindParam(':email', $email);

        $stmt->bindParam(':password', $password);

        $stmt->bindParam(':active', $require_email_activation);

        $stmt->execute();
        
        if ($require_email_activation) {
            $user = self::getUserByEmail($email);
            $token = LToken::createToken($user->id);
            return ['token' => $token, 'user' => $user];
        }
        
        return true;
    }
}
