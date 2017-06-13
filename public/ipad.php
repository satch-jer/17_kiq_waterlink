<?php

include('../php/process.php');

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="water-link">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/normalize.css">
    <!-- bootstrap support-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styling.css">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Registreer je nu | water-link</title>

    <link rel="shortcut icon" href="../assets/icons/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="../assets/icons/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="../assets/icons/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="../assets/icons/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/icons/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="../assets/icons/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="../assets/icons/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="../assets/icons/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="../assets/icons/apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/icons/apple-touch-icon-180x180.png" />
</head>

<body>

    <img id="logo" src="../assets/speelwin.svg" alt="Speel en win met water-link">

    <section>
        <div class="container">
            <h3>Neem nu deel:</h3>

            <div class="contentform">
                <form id="form_registration" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" novalidate>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="form_registration_input_email">Laat hier jouw e-mailadres achter en wij sturen jouw de link om deel te nemen aan de water-link wedstrijd! Veel succes!</label>
                            <input class="form-control" name="form_registration_input_email" id="form_registration_input_email" placeholder="E-mail" autocomplete="off" value="<?php echo $email;?>">
                        </div>
                    </div>

                    <div class="row" id="checkboxes">
                        <div class="checkbox form-group col-sm-12" id="form_registration_div_conditions">
                            <input type="checkbox" name="form_registration_input_conditions" id="form_registration_input_conditions" >
                            <label for="form_registration_input_conditions">Ik aanvaard het gebruik van mijn e-mailadres enkel voor deze wedstrijd.</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12" id="buttons">
                            <input type="submit" name="submit" id="form_registration_input_submit" class="btn btn-default" value="Speel mee">
                            <span id="form_registration_error_message"><?= $feedback_error ?></span>
                            <span id="form_registration_success_message"><?= $feedback_success ?></span>
                        </div>
                    </div>

                    <div id="form_unsynced">
                        <a href="#" id="form_unsynced_show">[ Niet-gesynchroniseerde adressen ]</a>
                        <ul id="form_unsynced_list"></ul>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section>
        <div id="content_borders">
            <div class="content_borders blue"></div>
            <div class="content_borders orange"></div>
            <div class="content_borders blue"></div>
            <div class="content_borders blue"></div>
            <div class="content_borders blue"></div>
            <div class="content_borders blue"></div>
            <div class="content_borders blue"></div>
            <div class="content_borders blue"></div>
            <div class="content_borders blue"></div>
        </div>
    </section>

<!-- js links -->
<script src="../script/lib/jquery-3.2.1.min.js"></script>
<script src="../script/ipad.js"></script>

</body>

</html>