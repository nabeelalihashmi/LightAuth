<?php

namespace IconicCodes\LightAuth\LightAuthAdapters;

use IconicCodes\LightAuth\LightAuthBase;

class LightAuthSessionAdapter extends LightAuthBase implements ILightAuthAdapter {

    public static $session_key = "lightauth_user_data";

    public static function getLoggedInUser() {
        if (isset($_SESSION[self::$session_key])) {
            return $_SESSION[self::$session_key];
        }
        return null;
    }

    public static function isUserLoggedIn() {
        return isset($_SESSION[self::$session_key]);
    }

    public static function logoutUser() {
        unset($_SESSION[self::$session_key]);
    }

    public static function loginUser($email, $password) {
        $user = self::getUserByEmail($email);
        if ($user && $user->password == $password) {
            $_SESSION[self::$session_key] = $user;
            return true;
        }
        return false;
    }

}
