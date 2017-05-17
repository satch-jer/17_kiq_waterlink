<?php

//includes
include_once 'classes/Mailin.php';
include_once 'classes/Player.php';

//create player object
$player = new Player();

//start session
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //session unset
    session_unset();

    if(empty($_POST['form_game_input_name'])){
        $_SESSION['errors']['form_game_input_name'] = "Naam is verplicht";
    }

    if(empty($_POST['form_game_input_firstname'])){
        $_SESSION['errors']['form_game_input_firstname'] = "Voornaam is verplicht";
    }

    if(empty($_POST['form_game_input_street'])){
        $_SESSION['errors']['form_game_input_street'] = "Straat is verplicht";
    }

    if(empty($_POST['form_game_input_number'])){
        $_SESSION['errors']['form_game_input_number'] = "Huisnummer is verplicht";
    }

    if(strlen($_POST['form_game_input_number']) > 10){
        $_SESSION['errors']['form_game_input_number'] = "Huisnummer is te lang";
    }

    if(empty($_POST['form_game_input_postalcode'])){
        $_SESSION['errors']['form_game_input_postalcode'] = "Postcode is verplicht";
    }

    if(strlen($_POST['form_game_input_postalcode']) > 4){
        $_SESSION['errors']['form_game_input_postalcode'] = "Postcode is te lang";
    }

    if(empty($_POST['form_game_input_city'])){
        $_SESSION['errors']['form_game_input_city'] = "Stad of gemeente is verplicht";
    }

    if(empty($_POST['form_game_input_phone'])){
        $_SESSION['errors']['form_game_input_phone'] = "Telefoon is verplicht";
    }

    if(!filter_var($_POST['form_game_input_mail'], FILTER_VALIDATE_EMAIL)){
        $_SESSION['errors']['form_game_input_mail'] = "E-mailadres heeft een onjuist formaat";
    }

    if(!$player->exist(strip_tags(trim($_POST["form_game_input_mail"])))){
        $_SESSION['errors']['form_game_input_mail'] = "E-mailadres is ons niet bekend, jammer";
    }

    if(!empty($player->participated(strip_tags(trim($_POST["form_game_input_mail"]))))){
        $_SESSION['errors']['form_game_input_mail'] = "E-mailadres nam reeds deel, be patient";
    }

    if(empty($_POST['form_game_input_birthdate'])){
        $_SESSION['errors']['form_game_input_birthdate'] = "Geboortedatum is verplicht";
    }

    if(empty($_POST['form_game_input_q1'])){
        $_SESSION['errors']['form_game_input_q1'] = "Antwoorden is verplicht om te kunnen winnen";
    }

    if(empty($_POST['form_game_input_q2'])){
        $_SESSION['errors']['form_game_input_q2'] = "Antwoorden is verplicht om te kunnen winnen";
    }

    if(count($_SESSION['errors']) > 0){
        //for ajax requests:
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode($_SESSION['errors']);
            exit;
        }

        foreach ($_SESSION['errors'] as $key => $value) {
            ${'span_' . $key} = $value;
        }

    }else{
        //get recipient mailadress
        $recipient = strip_tags(trim($_POST["form_game_input_mail"]));

        //create player
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

        //update player in db
        $player->updatePlayer($recipient);

        //create new mailin object
        $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'gFfSEwGJ3MsWv7YP');

        //send mail
        $data = array("id" => 3,
            "to" => $recipient
        );

        //send mail
        if($mailin->send_transactional_template($data)){
            echo json_encode(true);
        }
    }
}