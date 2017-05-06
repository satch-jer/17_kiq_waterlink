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
        <form id="form_game" action="../php/mailtwo.php">
            <!--name-->
            <label for="form_game_input_name">Naam</label>
            <input type="text" id="form_game_input_name" name="form_game_input_name">
            <!--firstname-->
            <label for="form_game_input_firstname">Voornaam</label>
            <input type="text" id="form_game_input_firstname" name="form_game_input_firstname">
            <!--street-->
            <label for="form_game_input_street">Straat</label>
            <input type="text" id="form_game_input_street" name="form_game_input_street">
            <!--number-->
            <label for="form_game_input_number">Nummer</label>
            <input type="text" id="form_game_input_number" name="form_game_input_number">
            <!--postalcode-->
            <label for="form_game_input_postalcode">Postcode</label>
            <input type="text" id="form_game_input_postalcode" name="form_game_input_postalcode">
            <!--city-->
            <label for="form_game_input_city">Gemeente</label>
            <input type="text" id="form_game_input_city" name="form_game_input_city">
            <!--phone-->
            <label for="form_game_input_phone">Telefoon</label>
            <input type="text" id="form_game_input_phone" name="form_game_input_phone">
            <!--mail-->
            <label for="form_game_input_mail">Email</label>
            <input type="text" id="form_game_input_mail" name="form_game_input_mail">
            <!--birthdate-->
            <label for="form_game_input_birthdate">Geboortedatum</label>
            <input type="date" id="form_game_input_birthdate" name="form_game_input_birthdate">
            <!--first question-->
            <label for="form_game_input_q1">Indien je alle dagen van het jaar 1,5 liter kraantjeswater zou drinken, wat zou de kostprijs zijn?</label>
            <input type="text" id="form_game_input_q1" name="form_game_input_q1">
            <!--second question-->
            <label for="form_game_input_q2">Hoeveel mensen zullen aan deze wedstrijd deelnemen?</label>
            <input type="text" id="form_game_input_q2" name="form_game_input_q2">

            <!--submit-->
            <input type="submit" name="submit" id="form_game_input_submit">

            <p id="form_game_message"></p>
        </form>
    </div>
</main>

<!-- js links -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="../script/game.js"></script>

</body>


</html>