var data = {};
var $form_game_input_submit = $('#form_game_input_submit');
var $form_game_confirm = $("#form_game_confirm");

//disable submit button because general conditions are not accepted
$form_game_input_submit.prop("disabled", true);

$(document).ready(function(){

    //submit button only enabled when conditions are accepted
    $('#form_game_input_conditions').click(function(){
        if($(this).is(':checked')){
            $form_game_input_submit.prop("disabled", false);
        }else{
            $form_game_input_submit.prop("disabled", true);
        }
    });

    $form_game_input_submit.on("click", function(){
        resetErrors();

        $.each($('form input, form select'), function(i, v){
            if(v.type !== 'submit'){
                data[v.name] = v.value;
            }
        }); //end each

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: '../php/secondmail.php',
            data: data,
            success: function(resp){
                if(resp === true){
                    $('form')[0].reset();
                    $form_game_confirm.addClass('success').text('Uw deelname werd bevestigd, bedankt!');
                    $form_game_input_submit.prop("disabled", true);
                    return false;
                }else{
                    $.each(resp, function(i,v){
                        var msg = '<label class="error" for="'+i+'">'+v+'</label>';
                        $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
                    });
                    var keys = Object.keys(resp);
                    $('input[name="' + keys[0] +'"]').focus();
                }
                return false;
            },
            error: function(){
                $form_game_confirm.text('Er ging iets mis met uw registratie, probeer later nog eens!');
            }
        });
        return false;
    });

    $('form input, form select').on("focusout", function(){
        var length = $(this).val().length;

        if(length > 0 && $(this).hasClass('inputTxtError')){
            $(this).next().remove();
            $(this).removeClass('inputTxtError');
        }

        return false;
    })
});

function resetErrors(){
    $('form input, form select').removeClass('inputTxtError');
    $('label.error').remove();
}