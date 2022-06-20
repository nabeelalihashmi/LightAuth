<?php

namespace IconicCodes\LightAuth;

use PDO;

class LightAuthLib {
    private PDO $db;
    private $users_table = "users";
    private $forgot_password_table = "lightauthtokens";
    private $profile_table = "profiles";

    public function __construct(PDO $db,$users_table ="users",$forgot_password_table="lightauthtokens" ,$profile_table="profiles") {
        $this->db = $db;
        $this->users_table = $users_table;
        $this->forgot_password_table = $forgot_password_table;
        $this->profile_table = $profile_table;
    }

    public function destroyMySQLTables() {
        $queryDeleteUserTable = "Drop table if exists `{$this->users_table}`";
        $queryDeleteForgotPasswordTable = "Drop table if exists `{$this->forgot_password_table}`";
        $queryDeleteProfileTable = "Drop table if exists `{$this->profile_table}`";
        $this->db->query($queryDeleteUserTable);
        $this->db->query($queryDeleteForgotPasswordTable);
        $this->db->query($queryDeleteProfileTable);
    }

    public function createMySQLTables() {
        $queryCreateUserTable = "CREATE TABLE IF NOT EXISTS `{$this->users_table}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `active` tinyint(1) NOT NULL DEFAULT '0',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        );";

        // create forgotton password table, relation with $userttable
        $queryCreateForgotPasswordTable = "CREATE TABLE IF NOT EXISTS `{$this->forgot_password_table}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `token` varchar(255) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        );";

        $queryCreateProfileTable  = "CREATE TABLE IF NOT EXISTS `{$this->profile_table}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `first_name` varchar(255) NOT NULL,
            `last_name` varchar(255) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        );";

        $this->db->exec($queryCreateUserTable);
        $this->db->exec($queryCreateForgotPasswordTable);
        $this->db->exec($queryCreateProfileTable);
    }
}