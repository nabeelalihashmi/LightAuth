<?php

namespace IconicCodes\LightAuth;

class LAccount extends LightAuthBase {

    public static function deactiveUserAccount($id) {
        $query = "UPDATE `" . self::$users_table . "` SET `active` = 0 WHERE `id` = :id";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function activateUserAccount($id) {
        $query = "UPDATE `" . self::$users_table . "` SET `active` = 1 WHERE `id` = :id";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}