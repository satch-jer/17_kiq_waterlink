<?php

    include_once "php/classes/Event.php";

    $event = new Event();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/waterlink.css">
    <title>Registratie | Waterlink</title>
</head>


<body>

<main class="content" role="main">
    <div class="wrapper">
        <form id="form_registration" action="php/mailone.php">
            <label for="form_registration_input_event">event:</label>
            <select name="form_registration_input_event" id="form_registration_input_event">
                <?php
                    foreach ($event->getAll() as $value){
                        //extract values from array
                        extract($value);

                        //show every option as option in select
                        echo '<option>' . $name . '</option>';
                    }
                ?>
            </select>
            <label for="form_registration_input_email">email:</label>
            <input type="email" name="form_registration_input_email" id="form_registration_input_email">
            <label for="form_registration_input_conditions">ik aanvaard de algemene voorwaarden:</label>
            <input type="checkbox" name="form_registration_input_conditions" id="form_registration_input_conditions" >
            <input type="submit" name="submit" id="form_registration_input_submit">

            <p id="form_registration_message"></p>
        </form>
    </div>
</main>


<!-- js links -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="script/contact.js"></script>

</body>


</html>