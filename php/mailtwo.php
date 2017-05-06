<?php

//include sendinblue smtp library
include_once 'classes/Mailin.php';
include_once 'classes/Player.php';

//get recipient mailadress
$recipient = strip_tags(trim($_POST["form_game_input_mail"]));

//create player
$player = new Player();
$player->lastname = strip_tags(trim($_POST["form_game_input_name"]));
$player->firstname = strip_tags(trim($_POST["form_game_input_firstname"]));
$player->street = strip_tags(trim($_POST["form_game_input_street"]));
$player->housenumber = strip_tags(trim($_POST["form_game_input_number"]));
$player->postal = strip_tags(trim($_POST["form_game_input_postalcode"]));
$player->city = strip_tags(trim($_POST["form_game_input_city"]));
$player->phone = strip_tags(trim($_POST["form_game_input_phone"]));
$player->birthday = strip_tags(trim($_POST["form_game_input_birthdate"]));
$player->question_1 = strip_tags(trim($_POST["form_game_input_q1"]));
$player->question_2 = strip_tags(trim($_POST["form_game_input_q2"]));

if($player->updatePlayer($recipient)){

    //create new mailin object
    $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'gFfSEwGJ3MsWv7YP');

    //send mail
    $data = array("id" => 3,
        "to" => $recipient
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
            'message'=>  "Bericht succesvol verzonden."
        );
    }
}else{
    $response = array(
        'result'=> false,
        'message'=>  "Probleem bij het bewaren van de gebruiker in de db, probeer opnieuw."
    );
}

//return resultset
echo json_encode($response);