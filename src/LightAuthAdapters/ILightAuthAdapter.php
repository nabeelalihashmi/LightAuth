<?php

namespace IconicCodes\LightAuth\LightAuthAdapters;


interface ILightAuthAdapter
{
    public static function getLoggedInUser();
    public static function isUserLoggedIn();
    public static function logoutUser();
    public static function loginUser($email, $password);
}