<?php

namespace IconicCodes\LightAuth;
use IconicCodes\LightAuth\LightAuthBase;

class LToken extends LightAuthBase {

    public static function createToken($userid) {
        $token = self::generateToken();
        $query = "INSERT INTO `" . self::$forgot_password_table . "` (`user_id`, `token`) VALUES (:user_id, :token)";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':user_id', $userid);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $token;
    }

    public static function checkResetToken($userid, $token) {
        $forgot_password_table = self::$forgot_password_table;
        $query = "SELECT * FROM `" . $forgot_password_table . "` WHERE `user_id` = :user_id AND `token` = :token";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':user_id', $userid);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $user = $stmt->fetchObject();
        return $user;
    }

    function deleteResetToken($userid, $token) {
        $forgot_password_table = self::$forgot_password_table;
        $query = "DELETE FROM `" . $forgot_password_table . "` WHERE `user_id` = :user_id AND `token` = :token";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':user_id', $userid);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
    }
}
