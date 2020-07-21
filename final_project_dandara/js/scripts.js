$(document).ready(function(){
    $('.pin-button').click(() => {
        console.log('opa: ',this);
    })


    $('.pin-button').click(() => {
        var clickBtnValue = $(this).val();
        var ajaxurl = 'manage_product.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            alert("action performed successfully");
        });
    });
});