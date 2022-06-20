<?php

namespace IconicCodes\LightAuth;

class LPassword extends LightAuthBase {
    public static function forgotten($email) {
        $forgot_password_table = self::$forgot_password_table;
        $errors = [];

        $email = self::sanitize($email);
        
        if (empty($email)) {
            $errors['email'] = 'Email is required';
        }

        if (count($errors) > 0) {
            return $errors;
        }

        $user = self::getUserByEmail($email);

        if (!$user) {
            $errors['email'] = 'Email does not exist';
            return $errors;
        }

        $token = self::generateToken();

        $query = "INSERT INTO `{self::$forgot_password_table}` (`user_id`, `token`) VALUES (:user_id, :token)";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':user_id', $user['id']);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        return $token;

    }

    public static function updatePassword($userid, $newpassword) {
        $users_table = self::$users_table;
        $forgot_password_table = self::$forgot_password_table;
        $errors = [];

        $newpassword = self::sanitize($newpassword);

        if (empty($newpassword)) {
            $errors['password'] = 'Password is required';
        }

        if (count($errors) > 0) {
            return $errors;
        }

        $query = "UPDATE `" . $users_table . "` SET `password` = :password WHERE `id` = :user_id";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':password', $newpassword);
        $stmt->bindParam(':user_id', $userid);
        $stmt->execute();
        $query = "DELETE FROM `{$forgot_password_table}` WHERE `user_id` = :user_id";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':user_id', $userid);
        $stmt->execute();
        return true;
    }

}