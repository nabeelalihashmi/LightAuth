<?php


use IconicCodes\LightAuth\LightAuth;
use IconicCodes\LightAuth\LightAuthAdapters\LightAuthJWTAdapter;
use IconicCodes\LightAuth\LRegister;
use IconicCodes\LightAuth\LightAuthLib;
use IconicCodes\LightAuth\LightAuthAdapters\LightAuthSessionAdapter;
use IconicCodes\LightAuth\LightAuthBase;

include "vendor/autoload.php";

$pdo = new PDO("mysql:host=localhost:3306;dbname=testdb", "root", "");

$installer = new LightAuthLib($pdo);
$installer->destroyMySQLTables();
$installer->createMySQLTables();

LightAuthBase::$db = $pdo;

$res = LRegister::register("test", "abc@gmail.com", "1234", 1);
var_dump($res);
$res = LRegister::register("test2", "abc2@gmail.com", "1234", 0);
var_dump($res);

$res = LightAuthSessionAdapter::getUserByEmail('mail2nabeelali@gmail.com', '1233');
var_dump($res);

$res = LightAuthJWTAdapter::loginUser("abc2@gmail.com", "1234");
var_dump($res);



