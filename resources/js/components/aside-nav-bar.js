import {
    View_Admin_unverified_factories,
    View_Admin_unverified_deleted_factories,
    View_Admin_unverified_owners,
    $change_$content, View_Admin_users, View_Admin_Manage_Factories
} from "../global.js";


$(document).ready(function() {
    $change_$content("#Under_Verification_Deleted_Factories",View_Admin_unverified_deleted_factories);
    $change_$content('#Under_Verification_Factories',View_Admin_unverified_factories);
    $change_$content('#Under_Verification_Owners',View_Admin_unverified_owners);
    $change_$content('#users',View_Admin_users);
    $change_$content('#Manage_Factories',View_Admin_Manage_Factories);


///close alert
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
        $($this).css({
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

