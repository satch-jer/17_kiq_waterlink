$(function() {
    //get the form and messages div.
    var $form = $('#form_registration');
    var $message = $('#form_registration_message');
    var $form_unsynced_link = $("#form_unsynced_show");
    var $form_unsynced_list = $("#form_unsynced_list");
    var $form_mail = $('#form_registration_input_email');

    //unsynced addresses showed?
    var unsynced_showed = false;

    //remove status text
    $('body').on('click', $form_mail, function(e){
       $message.text("");
    });

    //form submit
    $form.on("submit", function(e){
        e.preventDefault();

        if(navigator.onLine){
            alert("browser online");
            if($('#form_registration_input_conditions').is(":checked")){
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
            }else{
                //set error message
                $message.removeClass('success');
                $message.addClass('error');
                $message.text('Gelieve de algemene voorwaarden te accepteren');
            }
        }
        else{
            alert("browser offline");
            if (typeof(Storage) !== "undefined") {
                // localstorage

                //get input email
                var email = $("#form_registration_input_email").val();
                var key = "waterlink_" + localStorage.length;

                //set mail in local storage
                localStorage.setItem(key, email);

                //mail saved in local storage because offline
                $message.removeClass('error');
                $message.addClass('success');
                $message.text("Je bent offline, dit mailadres werd tijdelijk in local storage opgeslagen. Niet vergeten te syncen!");

            } else {
                // sorry! no web storage support..
            }
        }
    });

    //show unsynced
    $form_unsynced_link.on("click", function(e){
        e.preventDefault();

        if(!unsynced_showed){
            //set unsynced_showed to true
            unsynced_showed = true;

            //add localstorage elements
            for(var i in localStorage){
                $form_unsynced_list.append("<li><a id='" + localStorage.key(i) +"' class='form_unsynced_list_item ' href='#'>" + localStorage[i] + "</a></li>");
            }
        }else{
            //set unsynced_showed to false;
            $unsynced_showed = false;

            //empty list
            $form_unsynced_list.empty();
        }
    });

    //submit unsynced
    $('body').on('click', '.form_unsynced_list_item', function(e){
        e.preventDefault();

        //get key
        var key = $(this).attr('id');

        //get value
        var value = localStorage.getItem(key);
        alert(value);

        //add data to form
        $form_mail.val(value);

        //remove from localstorage
        localStorage.removeItem(key);

        //remove from list
        $(this).remove();
    });
});
