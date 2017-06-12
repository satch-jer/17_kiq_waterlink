$(function() {
    //get the form and messages div.
    var $form = $('#form_registration');
    var $form_unsynced_link = $("#form_unsynced_show");
    var $form_unsynced_list = $("#form_unsynced_list");
    var $form_mail = $('#form_registration_input_email');

    //delay for redirect
    var delay = 5000;

    //fill array with localstorage addresses
    var storedData = localStorage.getItem('emails');
    var emails = [];
    emails = JSON.parse(storedData);

    //refresh after 10 seconds no activitity
    (function(seconds) {
        var refresh,
            intvrefresh = function() {
                clearInterval(refresh);
                refresh = setTimeout(function() {
                    window.location.href = "../index.php";
                }, seconds * 1000);
            };

        $(document).on('keypress click', function() { intvrefresh() });
        intvrefresh();
    }(15)); // define here seconds

    //add localstorage elements
    if (emails != null) {
        for(var i = 0; i<emails.length; i++){
            $form_unsynced_list.append("<li><a id='" + emails[i] +"' class='form_unsynced_list_item ' href='#'>" + emails[i] + "</a></li>");
        }
    }

    //remove status text
    $('body').on('click', $form_mail, function(e){
        $("#form_registration_success_message").text("");
        $("#form_registration_error_message").text("");
    });

    //form submit
    $form.on("submit", function(e){
        e.preventDefault();

        if($('#form_registration_input_conditions').is(":checked")){
            if(validEmail($form_mail.val())){
                if(navigator.onLine){
                    //submit form with ajax
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: '../php/process.php',
                        data: $(this).serialize(),
                        encode: true
                    }).done(function(data){
                        if(data == 'true'){
                            //reset form
                            $('form')[0].reset();

                            //show feedback
                            $("#form_registration_success_message").text("Woehoew, deelname voltooid!");
                        }else{
                            //set errormessages
                            $.each(data, function(i,v){
                                $("#form_registration_error_message").text(v);
                            });
                        }
                    });

                    //redirect to start page
                    setTimeout(function(){
                        window.location.href = "../index.php";
                    }, delay);

                } else{
                    if (typeof(Storage) !== "undefined") {
                        // local storage

                        //get input email
                        var email = $("#form_registration_input_email").val();

                        //add to array
                        if(emails !== null){
                            emails.push(email);
                        }else{
                            emails = [email];
                        }

                        //set mail in local storage
                        localStorage.setItem("emails", JSON.stringify(emails));

                        //mail saved in local storage because offline
                        $("#form_registration_success_message").text("Je bent offline, dit e-mailadres werd lokaal opgeslagen. Niet vergeten te syncen!");

                        //append item to list
                        $form_unsynced_list.append("<li><a id='" + email +"' class='form_unsynced_list_item ' href='#'>" + email + "</a></li>");

                        //clear form after submission
                        $form.each(function(){
                            this.reset();
                        });
                    } else {
                        // sorry! no web storage support..
                    }
                }
            }else{
                //set error message
                $("#form_registration_error_message").text('Gelieve een geldig e-mailadres in te geven');
            }
        }else{
            //set error message
            $("#form_registration_error_message").text('Gelieve de algemene voorwaarden te accepteren');
        }
    });

    //show unsynced
    $form_unsynced_link.on("click", function(e){
        e.preventDefault();

        $form_unsynced_list.toggle("fast", function(){

        });
    });

    //submit unsynced
    $(document).on('click', '.form_unsynced_list_item', function(e){
        e.preventDefault();

        //get key
        var email = $(this).text();

        //add data to form
        $form_mail.val(email);

        //remove from array
        emails.remove(email);

        //set mail in local storage
        localStorage.setItem("emails", JSON.stringify(emails));

        //remove from list
        $(this).remove();
    });
});

function validEmail(input) {
    var reg= new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
    return (input.match(reg) == null) ? false : true;
}

Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};