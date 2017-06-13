<?php

//include sendinblue smtp library
include_once 'classes/Mailin.php';
include_once 'classes/Player.php';

//vars
$email = "";
$feedback_success = $feedback_error = "";

//array with errors
$errors = [];

//form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //=== create player object ===
    $player = new Player();

    //get day and add ten days
    $date = strtotime("+10 day");

    //=== required tests ===
    if(!empty($_POST["form_registration_input_email"])){
        $email = test_input($_POST["form_registration_input_email"]);

        if(isset($_POST["form_registration_input_conditions"])){
            if(filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email > 255)){
                if(!$player->exist($email)){
                    $player->mail = $email;
                    $player->expiration = date('Y-m-d', $date);
                }else{
                    $errors["email"] = "Dit e-mailadres werd reeds geregistreerd";
                }
            }else{
                $errors["email"] = "Gelieve een geldig e-mailadres in te geven";
            }
        }else{
            $errors["email"] = "Gelieve te accepteren dat we jouw e-mail adres mogen gebruiken";
        }
    }else{
        $errors["email"] = "Gelieve een e-mailadres in te geven";
    }

    //if all the errors are empty, only then send the message
    if(count($errors) > 0){
        //if ajax request
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode($errors);
            exit();
        }
        //no ajax, just use php form submission
        foreach ($errors as $key => $value) {
            $feedback_error = $value;
        }
    }else{
        if(sendMail($email, $date)){
            //if ajax request
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
                if($player->insertPlayer()) {
                    echo json_encode('true');
                }else{
                    echo json_encode('false');
                }
                exit();
            }
            //insert player in db
            if($player->insertPlayer()){
                $feedback_success = "Woehoew,  we hebben jouw een mail gestuurd met de wedstrijdvraag. Indien je deze niet terugvindt in je inbox, check dan zeker je spam!!";
            }else{
                $feedback_error = "Er ging iets mis met het opslaan van de gebruiker in de databank, probeer later opnieuw.";
            }
        }else{
            //if ajax request
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode('false');
                exit();
            }

            $feedback_error = "Er ging iets mis tijdens je deelname, probeer later opnieuw.";
        }
    }
}

//function that strips out unnecessary spaces and slashes, and escapes all the special HTML characters.
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//function that sends email to selected email-address
function sendMail($recipient, $date){
    //create new mailin object
    $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'gFfSEwGJ3MsWv7YP');

    //send mail
    $data = array("id" => 5,
        "to" => $recipient,
        "attr" => array("DATE"=> date('d M  Y', $date)),
    );

    //send mail
    if($mailin->send_transactional_template($data)){
        return true;
    }else{
        return false;
    }
}