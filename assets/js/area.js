$(document).ready(function() {
    $('#drop_1').change(function(){
        $('#wait_1').show();
        $('#result_1').hide();
        $.get("./clases/select.php", {
            func: "drop_1",
            drop_var: $('#drop_1').val()
        }, function(response){
            $('#result_1').fadeOut();
            setTimeout("finishAjax('result_1', '"+escape(response)+"')", 400);
        });
        return false;
    });
});

function finishAjax(id, response) {
    $('#wait_1').hide();
    $('#' + id).html(unescape(response));
    $('#' + id).fadeIn();
}