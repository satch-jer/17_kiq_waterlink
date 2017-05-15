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
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/waterlink.css">
    <title>registratie | water-link</title>
</head>


<body>

<main class="container" role="main">
    <div class="container_cell">
        <div class="container_content">

            <img src="assets/logo.png" alt="logo water-link" id="logo">

            <form id="form_registration" novalidate>
                <label class="screenreader" for="form_registration_input_event">event:</label>
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
                <label class="screenreader" for="form_registration_input_email">email:</label>
                <input type="text" name="form_registration_input_email" id="form_registration_input_email" placeholder="E-mail">
                <div id="form_registration_div_conditions">
                    <input type="checkbox" name="form_registration_input_conditions" id="form_registration_input_conditions" >
                    <label for="form_registration_input_conditions">Ik aanvaard de algemene voorwaarden</label>
                </div>
                <input type="submit" name="submit" id="form_registration_input_submit" value="Registreer">

                <p id="form_registration_message"></p>
            </form>

            <div id="form_unsynced">
                <h2><a href="#" id="form_unsynced_show">Niet-gesynchroniseerde adressen</a></h2>
                <ul id="form_unsynced_list"></ul>
            </div>
        </div>
    </div>
</main>


<!-- js links -->
<script src="script/jquery-3.2.1.min.js"></script>
<script src="script/contact.js"></script>

</body>

</html>