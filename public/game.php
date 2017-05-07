<?php

//include sendinblue smtp library
include_once '../php/classes/Mailin.php';
include_once '../php/classes/Player.php';

//var set to true if there is an error
$has_error = false;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //== name check
    if(empty($_POST["form_game_input_name"])){
        $has_error = true;
        $error_name = "Name is required";
    }else{
        if(strlen($_POST["form_game_input_name"]) < 2){
            $has_error = true;
            $error_name = "Name needs to be at least 2 characters long";
        }
    }

    //== firstname check
    if(empty($_POST["form_game_input_firstname"])){
        $has_error = true;
        $error_firstname = "Firstname is required";
    }else{
        if(strlen($_POST["form_game_input_firstname"]) < 2){
            $has_error = true;
            $error_firstname = "Firstname needs to be at least 2 characters long";
        }
    }

    //== street check
    if(empty($_POST["form_game_input_street"])){
        $has_error = true;
        $error_street = "Street is required";
    }else{
        if(strlen($_POST["form_game_input_street"]) < 5){
            $has_error = true;
            $error_street = "Street needs to be at least 5 characters long";
        }
    }

    //== number check
    if(empty($_POST["form_game_input_number"])){
        $has_error = true;
        $error_number = "Number is required";
    }

    //== postal check
    if(empty($_POST["form_game_input_postalcode"]) && !is_numeric($_POST["form_game_input_postalcode"])){
        $has_error = true;
        $error_postalcode = "Postalcode is required and can have numeric value only";
    }else{
        if(strlen($_POST["form_game_input_postalcode"]) != 4){
            $has_error = true;
            $error_postalcode = "Postalcode can be only 4 characters long";
        }
    }

    //== city check
    if(empty($_POST["form_game_input_city"])){
        $has_error = true;
        $error_city = "City is required";
    }else{
        if(strlen($_POST["form_game_input_city"]) < 2){
            $has_error = true;
            $error_city = "City needs to be at least 2 characters long";
        }
    }

    //== phone check
    if(empty($_POST["form_game_input_phone"]) && !is_numeric($_POST["form_game_input_phone"])){
        $has_error = true;
        $error_phone = "Phone is required and can have numeric value only";
    }else{
        if(strlen($_POST["form_game_input_phone"]) < 8 || strlen($_POST["form_game_input_phone"]) > 12){
            $has_error = true;
            $error_phone = "Phone needs to be between 8 and 12 characters";
        }
    }

    //== email check
    if(empty($_POST["form_game_input_mail"])){
        $has_error = true;
        $error_mail = "Mail is required";
    }else{
        if(strlen($_POST["form_game_input_mail"]) < 5 || strlen($_POST["form_game_input_mail"]) > 64){
            $has_error = true;
            $error_mail = "Mail needs to be at least 5 characters long";
        }
    }

    //== birthday check
    if(empty($_POST["form_game_input_birthdate"])){
        $has_error = true;
        $error_birthdate = "Birthdate is required";
    }

    //== q1 check
    if(empty($_POST["form_game_input_q1"])){
        $has_error = true;
        $error_q1 = "Response is required to win";
    }

    //== q2 check
    if(empty($_POST["form_game_input_q2"])){
        $has_error = true;
        $error_q2 = "Response is required to win";
    }

    //no error so time for db logic
    if(!$has_error){
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

        //check if player exist
        if($player->exist($recipient)){
            if($player->updatePlayer($recipient)){
                //create new mailin object
                $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'gFfSEwGJ3MsWv7YP');

                //send mail
                $data = array("id" => 3,
                    "to" => $recipient
                );

                //dump response
                if($mailin->send_transactional_template($data)){
                    $form_feedback = "Proficiat, uw deelname is bevestigd.";
                }else{
                    $form_feedback = "Oei, er ging iets mis. Probeer later opnieuw.";
                }
            }else{
                $form_feedback = "Oei, er ging iets mis. Probeer later even opnieuw.";
            }
        }
        }else{
            $form_feedback = "Oei, dit mailadres kennen we niet...";
        }

}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/waterlink.css">
    <title>Game | Waterlink</title>
</head>

<body>

<main class="content" role="main">
    <div class="wrapper">
        <form id="form_game" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <!--name-->
            <label for="form_game_input_name">Naam</label>
            <input type="text" id="form_game_input_name" name="form_game_input_name">
            <span class="error"><?php echo $error_name;?></span>
            <!--firstname-->
            <label for="form_game_input_firstname">Voornaam</label>
            <input type="text" id="form_game_input_firstname" name="form_game_input_firstname">
            <span class="error"><?php echo $error_firstname;?></span>
            <!--street-->
            <label for="form_game_input_street">Straat</label>
            <input type="text" id="form_game_input_street" name="form_game_input_street">
            <span class="error"><?php echo $error_street;?></span>
            <!--number-->
            <label for="form_game_input_number">Nummer</label>
            <input type="text" id="form_game_input_number" name="form_game_input_number">
            <span class="error"><?php echo $error_number;?></span>
            <!--postalcode-->
            <label for="form_game_input_postalcode">Postcode</label>
            <input type="text" id="form_game_input_postalcode" name="form_game_input_postalcode">
            <span class="error"><?php echo $error_postalcode;?></span>
            <!--city-->
            <label for="form_game_input_city">Gemeente</label>
            <input type="text" id="form_game_input_city" name="form_game_input_city">
            <span class="error"><?php echo $error_city;?></span>
            <!--phone-->
            <label for="form_game_input_phone">Telefoon</label>
            <input type="text" id="form_game_input_phone" name="form_game_input_phone">
            <span class="error"><?php echo $error_phone;?></span>
            <!--mail-->
            <label for="form_game_input_mail">Email</label>
            <input type="text" id="form_game_input_mail" name="form_game_input_mail">
            <span class="error"><?php echo $error_mail;?></span>
            <!--birthdate-->
            <label for="form_game_input_birthdate">Geboortedatum</label>
            <input type="date" id="form_game_input_birthdate" name="form_game_input_birthdate">
            <span class="error"><?php echo $error_birthdate;?></span>
            <!--first question-->
            <label for="form_game_input_q1">Indien je alle dagen van het jaar 1,5 liter kraantjeswater zou drinken, wat zou de kostprijs zijn?</label>
            <input type="text" id="form_game_input_q1" name="form_game_input_q1">
            <span class="error"><?php echo $error_q1;?></span>
            <!--second question-->
            <label for="form_game_input_q2">Hoeveel mensen zullen aan deze wedstrijd deelnemen?</label>
            <input type="text" id="form_game_input_q2" name="form_game_input_q2">
            <span class="error"><?php echo $error_q2;?></span>

            <!--submit-->
            <input type="submit" name="submit" id="form_game_input_submit">

            <p id="form_game_message"><?php echo $form_feedback;?></p>
        </form>
    </div>
</main>

<!-- js links -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
</body>


</html>