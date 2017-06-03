<?php

//include sendinblue smtp library
include_once 'classes/Mailin.php';
include_once 'classes/Player.php';

// 1 == add user to db ==

//get recipient mailadress
$recipient = strip_tags(trim($_POST["form_registration_input_email"]));

//get event
$event = strip_tags(trim($_POST["form_registration_input_event"]));

//get day and add ten days
$date = strtotime("+10 day");

//create player
$player = new Player();
$player->mail = $recipient;
$player->event = $event;
$player->registration = date('Y-m-d', $date);

//used to check if mail is already in db
$check = new Player();

if(!$check->exist($player->mail)){
    if($player->insertPlayer()){
        // 2 == send mail

        //create new mailin object
        $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'gFfSEwGJ3MsWv7YP');

        //send mail
        $data = array("id" => 5,
            "to" => $recipient,
            "attr" => array("EVENT"=>$player->event,"DATE"=> date('d M  Y', $date))
        );

        //dump response
        if(!$mailin->send_transactional_template($data)){
            $response = array(
                'result'=> false,
                'message'=>  "Oeps, er ging iets mis bij het verzenden, probeer opnieuw."
            );
        }else{
            $response = array(
                'result'=> true,
                'message'=>  "Woehoew, bericht succesvol verzonden."
            );
        }
    }else{
        $response = array(
            'result'=> false,
            'message'=>  "Probleem bij het bewaren van de gebruiker in de db, probeer opnieuw."
        );
    }
}else{
    $response = array(
        'result'=> false,
        'message'=>  "Dit e-mailadres werd reeds geregistreerd."
    );
}

//return resultset
echo json_encode($response);