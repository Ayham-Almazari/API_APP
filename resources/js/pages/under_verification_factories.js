import {API_Path_unverified_factories } from "../global";
import "../auth/middelwares/AdminRedirectToLoginIFUnauthMeddleware.js";

    const cancel_factory={
        ele_clickable:".cancel_factory",
        attr_to_get_id:'factory_id',
        class_to_append_with_id_to_remove:"#factory_view_",
        url:API_Path_unverified_factories,
        type:'DELETE',
        confirm_button:"Remove Factory",
        cancel_button:"Cancel",
        message: "Are you sure that ? , you are going to <b><u>REMOVE</u> <strike  style='color: red'>factory</strike></b> .",
        id:"Not Set Yet"
    };

    const confirm_factory={
        ele_clickable:".confirm_factory",
        attr_to_get_id:'factory_id',
        class_to_append_with_id_to_remove:"#factory_view_",
        url:API_Path_unverified_factories,
        type:'GET',
        confirm_button:"Confirm Factory",
        cancel_button:"Cancel",
        message: "Are you sure that ? , you are going to <b><u>Verify</u> <b  style='color: green'>factory</b></b> .",
        id:"Not Set Yet"
    };

    let info = "request to process";
    //confirm
$(document).on('click',confirm_factory.ele_clickable,function (e){
        e.preventDefault();
        info = confirm_factory ;
        $("#report .message").html(info.message);
        $("#report #cancel").html(info.cancel_button).click(() => {
            $("#report").fadeOut(500);
        });
        $("#report #confirm").html(info.confirm_button + "<i style='display: none' id='loading-btn' class='fas fa-cog fa-spin faa-fast'></i>")
        $("#report").fadeIn();
        $("#closeWindow").click(function (e) {
            $("#report").fadeOut(500);
        });
        info.id = $(this).attr(info.attr_to_get_id);
        console.log(info.id);
    });
    //delete
    $(document).on('click',cancel_factory.ele_clickable,function (e) {
        e.preventDefault();
        info =cancel_factory;
        $("#report .message").html(info.message);
        $("#report #cancel").html(info.cancel_button).click(() => {
            $("#report").fadeOut(500);
        });
        $("#report #confirm").html(info.confirm_button + "<i style='display: none' id='loading-btn' class='fas fa-cog fa-spin faa-fast'></i>")
        $("#report").fadeIn();
        $("#closeWindow").click(function (e) {
            $("#report").fadeOut(500);
        });
        info.id = $(this).attr(info.attr_to_get_id);
        console.log(info.id);
    });

$("#report #confirm")
        .click((e) => {
            $.ajax(
                {
                    url: info.url + info.id,
                    type:  info.type,
                    headers: {"Authorization": "Bearer " + localStorage.getItem('_token')}
                    ,
                    success: function (result, status) {
                        console.log(status)
                        if (status === "success") {
                            $("#report").fadeOut(500);
                            $(info.class_to_append_with_id_to_remove + info.id).remove();
                            $("#alert .message").html(result.msg);
                            $("#alert").fadeIn();
                        }
                    }
                });
        });


$(document).ready(()=>{
    $(document).ajaxStart(function () {
        $("#loading-btn").show();
        $(info.class_to_append_with_id_to_remove + info.id)
            .animate({
                position:"absolute",
                top:"50%",
                left:"50%",
                transform: "translate(-50%,-50%)",
                opacity:0,
                _zIndex:3
            },"slow");
        $("#report #confirm").attr("disabled", true);
        $('#loading-icon').hide();
    }).ajaxStop(function () {
        $("#loading-btn").hide();
        $("#report #confirm").attr("disabled", false);
    });

});

let     search_about = null;
$('input:radio[name="Filter-Search"]').change(function(){
    search_about =$(this).val();
    console.log(search_about);
});
$("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $('.row .card').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});
