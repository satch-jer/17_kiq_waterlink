<?php

include_once "Db.php";

class Event{

    private $name;

    //set
    public function __set($prop, $val){
        switch($prop){
            case 'name':
                $this->name = $val;
                break;
            default:
                echo "Error: " . $prop . " bestaat niet.";
        }
    }

    //get
    public function __get($prop){
        switch($prop) {
            case 'name':
                return $this->name;
            default:
                echo "Error: " . $prop . " bestaat niet.";
        }
    }

    //get all
    public function getAll(){
        $db = Db::getInstance();

        $stmt = $db->prepare("SELECT name FROM events");
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row;
        }
        return $data;
    }
}

