import {
    View_Admin_unverified_factories,
    API_Path_unverified_factories,
    $change_$content
} from "../global.js";


$(document).ready(function() {
    $change_$content('#Under_Verification_Factories',View_Admin_unverified_factories);




    $(".close-alert").click(()=>{
        $("#alert").fadeOut(500);
    });
    const $loading_icon = $('#loading-icon');
    $(document).ajaxStart(function (){
        $loading_icon.show();
    }).ajaxStop(function() {
        $loading_icon.hide();
    });
});
