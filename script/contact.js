$(function() {
    //get the form and messages div.
    var form = $('#form_registration');
    var message = $('#form_registration_message');
    var form_unsynced_link = $("#form_unsynced_show");
    var form_unsynced_list = $("#form_unsyced_list");


    //form submit
    $(form).on("submit", function(e){
        e.preventDefault();


        if(navigator.onLine){
            alert("browser online");
            if($('#form_registration_input_conditions').is(":checked")){
                //serialize (key-value) the form data
                var formdata = $(form).serialize();

                //submit form with ajax
                $.ajax({
                    type: 'POST',
                    url: 'php/mailone.php',
                    data: formdata,
                    dataType: 'json'
                }).done(function(response){
                    if(response["result"]){
                        $(message).removeClass('error');
                        $(message).addClass('success');
                    }else{
                        $(message).removeClass('success');
                        $(message).addClass('error');
                    }

                    $(message).text(response["message"]);
                });
            }else{
                //set error message
                $(message).removeClass('success');
                $(message).addClass('error');
                $(message).text('Gelieve de algemene voorwaarden te accepteren');
            }
        }
        else{
            alert("browser offline");
            if (typeof(Storage) !== "undefined") {
                // localstorage

                //get input email
                $email = $("#form_registration_input_email").val();
                $key = "waterlink_" + localStorage.length;

                //set mail in local storage
                localStorage.setItem($key, $email);
            } else {
                // sorry! no web storage support..
            }
        }
    });

    //show unsynced
    $(form_unsynced_link).on("click", function(e){
        e.preventDefault();

        for(var i in localStorage){
            form_unsynced_list.append("<li><a id='" + localStorage.key(i) +"' class='form_unsynced_list_item ' href='#'>" + localStorage[i] + "</a></li>");
        }
    });

    //submit unsynced
    $('body').on('click', '.form_unsynced_list_item', function(e){
        e.preventDefault();

        //get key
        $key = $(this).attr('id');

        //get value
        $value = localStorage.getItem($key);
        alert($value);

        //add data to form

        //remove from localstorage
    })
});

//fun