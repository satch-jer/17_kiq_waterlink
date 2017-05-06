$(function() {
    //get the form and messages div.
    var form = $('#form_registration');
    var message = $('#form_registration_message');

    $(form).on("submit", function(e){
        e.preventDefault();

        if($('#form_registration_input_conditions').is(":checked")){
            //serialize (key-value) the form data
            var formdata = $(form).serialize();

            //submit form with ajax
            $.ajax({
                type: 'POST',
                url: $(form).attr('action'),
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
    });
});