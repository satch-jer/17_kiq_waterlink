<?php
define('DB_HOST', 'ID230103_waterlink.db.webhosting.be');
define('DB_NAME', 'ID230103_waterlink');
define('DB_USER', 'ID230103_waterlink');
define('DB_PASS', '@dmin123');
define('DB_CHAR', 'utf8');


class Db{
    private static $db;

    public static function getInstance(){
        if(self::$db === null){

            $opt  = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => FALSE,
            );

            $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHAR;

            self::$db = new PDO($dsn, DB_USER, DB_PASS, $opt);

            return self::$db;
        }else{
            return self::$db;
        }
    }
}