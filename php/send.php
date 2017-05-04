<?php

    require_once '../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

    //get recipient mailadress
    $recipient = strip_tags(trim($_POST["form_registration_input_email"]));

    //php mailer object
    $mail = new PHPMailer(true);

    //smtp debug
    //$mail->SMTPDebug = 3;
    //$mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";}; //$mail->Debugoutput = 'echo';

    //use smtp
    $mail->isSMTP();

    //smtp hostname
    $mail->Host = "smtp.office365.com";

    //host requires authentication to send mail
    $mail->SMTPAuth = true;

    //smtp username and password
    $mail->Username = "jer@satch.cc";
    $mail->Password = "11.10Anneleen";

    $mail->From = "jer@satch.cc";
    $mail->FromName = "Play with Waterlink";

    //host requires secure connection
    $mail->SMTPSecure = "tls";

    //tcp port to connect to
    $mail->Port = 587;

    //send html mail
    $mail->isHTML(true);

    //create message
    $mail->Subject = "Play with Waterlink";
    $mail->Body = "<i>Thanks for playing with us</i>";
    $mail->AltBody = "This is the plain text version of the email content";

    //add recipient address
    $mail->addAddress($recipient, "Name");

    if(!$mail->send()) {
            echo 'Oeps, er ging iets mis. Probeer opnieuw';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Yeah, bericht verzonden!';
        }

?>