<?php

include_once '../php/secondmail.php'

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/game.css">
    <title>Play en win | Water-link</title>
</head>

<body>

<nav>
    <a href="#" id="nav_logo">Logo Water-Link</a>
</nav>

<main class="content" role="main">
    <div class="wrapper">
        <div class="intro">
            <h1>Win een Sodastream en maak thuis jouw eigen bruiswater</h1>
            <h2>Om deel te nemen hebben we eerst jouw gegevens nodig:</h2>
        </div>

        <form id="form_game" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <!--name-->
                            <label class="screenreader" for="form_game_input_name">Naam</label>
                            <input type="text" id="form_game_input_name" name="form_game_input_name" placeholder="Naam">
                            <span><?php echo $span_form_game_input_name ?></span>
                        </td>
                        <td>
                            <!--firstname-->
                            <label class="screenreader" for="form_game_input_firstname">Voornaam</label>
                            <input type="text" id="form_game_input_firstname" name="form_game_input_firstname" placeholder="Voornaam">
                            <span><?php echo $span_form_game_input_firstname ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <!--street-->
                            <label class="screenreader" for="form_game_input_street">Straat</label>
                            <input type="text" id="form_game_input_street" name="form_game_input_street" placeholder="Straat">
                            <span><?php echo $span_form_game_input_street ?></span>
                        </td>
                        <td>
                            <!--number-->
                            <label class="screenreader" for="form_game_input_number">Nummer</label>
                            <input type="text" id="form_game_input_number" name="form_game_input_number" placeholder="Huisnummer">
                            <span><?php echo $span_form_game_input_number ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <!--postalcode-->
                            <label class="screenreader" for="form_game_input_postalcode">Postcode</label>
                            <input type="text" id="form_game_input_postalcode" name="form_game_input_postalcode" placeholder="Postcode">
                            <span><?php echo $span_form_game_input_postalcode ?></span>
                        </td>
                        <td>
                            <!--city-->
                            <label class="screenreader" for="form_game_input_city">Gemeente</label>
                            <input type="text" id="form_game_input_city" name="form_game_input_city" placeholder="Gemeente">
                            <span><?php echo $span_form_game_input_city ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <!--phone-->
                            <label class="screenreader" for="form_game_input_phone">Telefoon</label>
                            <input type="text" id="form_game_input_phone" name="form_game_input_phone" placeholder="Telefoon">
                            <span><?php echo $span_form_game_input_phone ?></span>
                        </td>
                        <td>
                            <!--mail-->
                            <label class="screenreader" for="form_game_input_mail">Email</label>
                            <input type="text" id="form_game_input_mail" name="form_game_input_mail" placeholder="E-mailadres">
                            <span><?php echo $span_form_game_input_mail ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <!--birthdate-->
                            <label class="screenreader" for="form_game_input_birthdate">Geboortedatum</label>
                            <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="form_game_input_birthdate" name="form_game_input_birthdate" placeholder="Geboortedatum">
                            <span><?php echo $span_form_game_input_birthdate ?></span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <h2>Wedstrijd:</h2>

            <!--first question-->
            <label class="form_game_input_q" for="form_game_input_q1">Indien je alle dagen van het jaar 1,5 liter kraantjeswater zou drinken, wat zou de kostprijs zijn?</label>
            <input type="text" id="form_game_input_q1" name="form_game_input_q1" placeholder="Weet je het?">
            <span><?php echo $span_form_game_input_q1 ?></span>
            <!--second question-->
            <label class="form_game_input_q" for="form_game_input_q2">Hoeveel mensen zullen aan deze wedstrijd deelnemen?</label>
            <input type="text" id="form_game_input_q2" name="form_game_input_q2" placeholder="Ik weet het hoor!">
            <span><?php echo $span_form_game_input_q2 ?></span>
            <!--submit-->
            <input type="submit" name="submit" id="form_game_input_submit">

            <p id="form_game_confirm"></p>
        </form>
    </div>
</main>

<!-- js links -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="../script/game.js"></script>
</body>


</html>