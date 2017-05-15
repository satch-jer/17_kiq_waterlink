$(function() {
    //get the form and messages div.
    var $form = $('#form_registration');
    var $message = $('#form_registration_message');
    var $form_unsynced_link = $("#form_unsynced_show");
    var $form_unsynced_list = $("#form_unsynced_list");
    var $form_mail = $('#form_registration_input_email');

    //add localstorage elements
    for(var i in localStorage){
        $form_unsynced_list.append("<li><a id='" + localStorage[i] +"' class='form_unsynced_list_item ' href='#'>" + localStorage[i] + "</a></li>");
    }

    //set container to 100% window height
    $('.container').css('height', $(window).height());

    //also on resize
    $(window).resize(function(){
        $('.container').css('height', $(window).height());
    });

    //remove status text
    $('body').on('click', $form_mail, function(e){
       $message.text("");
    });

    //form submit
    $form.on("submit", function(e){
        e.preventDefault();

        if($('#form_registration_input_conditions').is(":checked")){
            if(validEmail($form_mail.val())){
                if(navigator.onLine){
                    //serialize (key-value) the form data
                    var formdata = $($form).serialize();

                    //submit form with ajax
                    $.ajax({
                        type: 'POST',
                        url: 'php/mailone.php',
                        data: formdata,
                        dataType: 'json'
                    }).done(function(response){
                        if(response["result"]){
                            $message.removeClass('error');
                            $message.addClass('success');
                        }else{
                            $message.removeClass('success');
                            $message.addClass('error');
                        }

                        $message.text(response["message"]);

                        //clear form after submission
                        $form.each(function(){
                            this.reset();
                        });
                    });
                } else{
                    if (typeof(Storage) !== "undefined") {
                        // localstorage

                        //get input email
                        var email = $("#form_registration_input_email").val();
                        var key = email;

                        //set mail in local storage
                        localStorage.setItem(key, email);

                        //mail saved in local storage because offline
                        $message.removeClass('error');
                        $message.addClass('success');
                        $message.text("Je bent offline, dit e-mailadres werd lokaal opgeslagen. Niet vergeten te syncen!");

                        //append item to list
                        $form_unsynced_list.append("<li><a id='" + localStorage.key(key) +"' class='form_unsynced_list_item ' href='#'>" + email + "</a></li>");

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
                $message.removeClass('success');
                $message.addClass('error');
                $message.text('Gelieve een geldig e-mailadres in te geven');
            }
        }else{
            //set error message
            $message.removeClass('success');
            $message.addClass('error');
            $message.text('Gelieve de algemene voorwaarden te accepteren');
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
        var key = $(this).text();

        //get value
        var value = localStorage.getItem(key);

        //add data to form
        $form_mail.val(value);

        //remove from localstorage
        localStorage.removeItem(key);

        //remove from list
        $(this).remove();
    });
});

function validEmail(input) {
    var reg= new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
    return (input.match(reg) == null) ? false : true;
}