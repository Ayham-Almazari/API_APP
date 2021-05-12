import {
    View_Admin_unverified_factories,
    View_Admin_unverified_deleted_factories,
    $change_$content
} from "../global.js";


$(document).ready(function() {
    $change_$content("#Under_Verification_Deleted_Factories",View_Admin_unverified_deleted_factories);
    $change_$content('#Under_Verification_Factories',View_Admin_unverified_factories);


    $(".close-alert").click(()=>{
        $("#alert").fadeOut(500);
    });

//------------------------icon loading for page------------------------------------------------------------
    $(document).ajaxStart(function (){
        $('#loading-icon').show();
    }).ajaxStop(function() {
        $('#loading-icon').hide();
    });

//------------------------active------------------------------------------------------------
    $(".navbar-nav li").click(function(event) {
        var $this = $(this);
        var loading_id= $($this).attr('for');
        $(".navbar-nav li").removeClass("active").css({
            border:"none"
        });
        $this.removeClass('active');
       // console.log(loading_id);//'loading-id-'
        $($this).addClass("active").css({
            borderBottom:"1px solid white"
        });
        $(document).ajaxStart(function (){
            $(".navbar-nav li i").hide();
            $('#loading-id-'+loading_id).show();
        }).ajaxStop(function() {
            $('#loading-id-'+loading_id).hide();
        });
    });
});

