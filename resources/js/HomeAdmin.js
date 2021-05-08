var $loading_icon = $('#loading-icon').hide();
$(document).ajaxStart(function (){
    $loading_icon.show();
}).ajaxStop(function() {
    $loading_icon.hide();
});
