<?php

require_once('config/conf.php');

class BDD {
    public static $pdo;

    public static function Init() {
        $hostname = Conf::getHostname();
        $database_name = Conf::getDatabase();
        $login = Conf::getLogin();
        $password = Conf::getPassword();

        self::$pdo = new PDO(
            "pgsql:host=$hostname;port=5432;dbname=$database_name;user=$login;password=$password"
        );
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}

BDD::Init();

?>