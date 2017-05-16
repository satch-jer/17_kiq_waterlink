<?php

//includes
include_once '../php/classes/Mailin.php';
include_once '../php/classes/Player.php';

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
        $mailin->send_transactional_template($data);

        echo json_encode("true");
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Game | Waterlink</title>
</head>

<body>

<main class="content" role="main">
    <div class="wrapper">
        <form id="form_game" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>
            <!--name-->
            <label for="form_game_input_name">Naam</label>
            <input type="text" id="form_game_input_name" name="form_game_input_name">
            <span><?php echo $span_form_game_input_name ?></span>
            <!--firstname-->
            <label for="form_game_input_firstname">Voornaam</label>
            <input type="text" id="form_game_input_firstname" name="form_game_input_firstname">
            <span><?php echo $span_form_game_input_firstname ?></span>
            <!--street-->
            <label for="form_game_input_street">Straat</label>
            <input type="text" id="form_game_input_street" name="form_game_input_street">
            <span><?php echo $span_form_game_input_street ?></span>
            <!--number-->
            <label for="form_game_input_number">Nummer</label>
            <input type="text" id="form_game_input_number" name="form_game_input_number">
            <span><?php echo $span_form_game_input_number ?></span>
            <!--postalcode-->
            <label for="form_game_input_postalcode">Postcode</label>
            <input type="text" id="form_game_input_postalcode" name="form_game_input_postalcode">
            <span><?php echo $span_form_game_input_postalcode ?></span>
            <!--city-->
            <label for="form_game_input_city">Gemeente</label>
            <input type="text" id="form_game_input_city" name="form_game_input_city">
            <span><?php echo $span_form_game_input_city ?></span>
            <!--phone-->
            <label for="form_game_input_phone">Telefoon</label>
            <input type="text" id="form_game_input_phone" name="form_game_input_phone">
            <span><?php echo $span_form_game_input_phone ?></span>
            <!--mail-->
            <label for="form_game_input_mail">Email</label>
            <input type="text" id="form_game_input_mail" name="form_game_input_mail">
            <span><?php echo $span_form_game_input_mail ?></span>
            <!--birthdate-->
            <label for="form_game_input_birthdate">Geboortedatum</label>
            <input type="date" id="form_game_input_birthdate" name="form_game_input_birthdate">
            <span><?php echo $span_form_game_input_birthdate ?></span>
            <!--first question-->
            <label for="form_game_input_q1">Indien je alle dagen van het jaar 1,5 liter kraantjeswater zou drinken, wat zou de kostprijs zijn?</label>
            <input type="text" id="form_game_input_q1" name="form_game_input_q1">
            <span><?php echo $span_form_game_input_q1 ?></span>
            <!--second question-->
            <label for="form_game_input_q2">Hoeveel mensen zullen aan deze wedstrijd deelnemen?</label>
            <input type="text" id="form_game_input_q2" name="form_game_input_q2">
            <span><?php echo $span_form_game_input_q2 ?></span>
            <!--submit-->
            <input type="submit" name="submit" id="form_game_input_submit">

            <p id="form_game_confirm"></p>
        </form>
    </div>
</main>

<!-- js links -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="../script/script.js"></script>
</body>


</html>