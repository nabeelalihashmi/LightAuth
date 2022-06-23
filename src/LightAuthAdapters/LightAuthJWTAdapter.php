<?php

namespace IconicCodes\LightAuth\LightAuthAdapters;

use IconicCodes\LightAuth\LightAuthBase;
use IconicCodes\LightAuth\LightAuthAdapters\ILightAuthAdapter;

class LightAuthJWTAdapter extends LightAuthBase implements ILightAuthAdapter {
    
    public static $JWT_OBJ;
    public static $jwt_secret_key = "highly_secret_key";
    public static $jwt_issuer = "https://localhost:8081/";
    public static $jwt_nbf_delay = 10;
    public static $jwt_cookie_key = "jwt_token";

    public static function loginUser($email, $password) {
        $user = self::getUserByEmail($email);
        if ($user && $user->password == $password) {
            unset($user->password);
            $data = [
                "user" => $user,
                "iss" => self::$jwt_issuer,
                "nbf" => time() + self::$jwt_nbf_delay,
                "iat" => time(),
                "exp" => time() + (60 * 60 * 24 * 7)
            ];
            $token = self::$JWT_OBJ::encode($data, self::$jwt_secret_key, "HS256");
            return $token;
        }
        return false;   
    }

    public static function getLoggedInUser() {
        $token = self::getToken();
        if ($token) {
            $decoded = self::$JWT_OBJ::decode($token, self::$jwt_secret_key, array("HS256"));
            $user = $decoded->user;
            return $user;
        }
        return null;
    }

    public static function isUserLoggedIn() {
        $token = self::getToken();
        if ($token) {
            $decoded = self::$JWT_OBJ::decode($token, self::$jwt_secret_key, array("HS256"));
            $user = $decoded->user;
            if ($user) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }


    private static function getToken() {
        if (isset($_COOKIE[self::$jwt_cookie_key])) {
            return $_COOKIE[self::$jwt_cookie_key];
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            return $_SERVER['HTTP_AUTHORIZATION'];
        } 

        return null;
    }

    public static function logoutUser() {
        setcookie(self::$jwt_cookie_key, '', time() - 3600, '/', "", false, true);
    }

}
