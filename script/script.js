var data = {};

$(document).ready(function(){

    //url
    var $form = $("#form_game");

    $('#form_game_input_submit').on("click", function(){
        resetErrors();

        $.each($('form input, form select'), function(i, v){
            if(v.type !== 'submit'){
                data[v.name] = v.value;
            }
        }); //end each

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: $form.attr('action'),
            data: data,
            success: function(resp){
                if(resp == true){
                    $('form').submit();
                    $('form').reset();
                    $("#form_game_confirm").text('Uw deelname werd bevestigd, bedankt!');
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
                $("#form_game_confirm").text('Er ging iets mis met uw registratie, probeer later nog eens!');
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