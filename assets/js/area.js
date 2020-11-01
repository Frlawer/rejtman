$(document).ready(function() {
    $('#drop_1').change(function(){
        $('#wait_1').show();
        $('#abogada').hide();
        $.get("./clases/select.php", {
            func: "drop_1",
            drop_var: $('#drop_1').val()
        }, function(response){
            $('#abogada').fadeOut();
            setTimeout("finishAjax('abogada', '"+escape(response)+"')", 400);
        });
        return false;
    });
});

$(document).ready(function() {
    $('#abogada').change(function(){
        $('#wait_1').show();
        $('#hora').hide();
        $.get('./clases/select.php',{
            func: 'horas',
            abogadaid: $('#abogada').val()
        }, function(response){
            $('#hora').fadeOut();
            setTimeout("finishAjax('hora', '"+escape(response)+"')", 400);
        });
        return false;
    });
});

function finishAjax(id, response) {
    $('#wait_1').hide();
    $('#' + id).html(unescape(response));
    $('#' + id).fadeIn();
}