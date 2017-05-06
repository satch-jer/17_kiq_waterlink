<?php

class Db{
    private static $db;

    public static function getInstance(){
        if(self::$db === null){
            self::$db = new PDO("mysql:host=localhost; dbname=17_waterlink", "mrsatch", "@dmin123");
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$db;
        }else{
            return self::$db;
        }
    }
}