$(document).ready(()=>{
    const $loading_icon = $('#loading-icon');
    $(document).ajaxStart(function (){
        $loading_icon.show();
    }).ajaxStop(function() {
        $loading_icon.hide();
    });
})

