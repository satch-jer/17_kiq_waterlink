$(function() {
    //get the form and messages div.
    var form = $('#form_game');
    var message = $('#form_game_message');

    $(form).on("submit", function(e){
        e.preventDefault();

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
    });
});