import {API_Path_unverified_deleted_factories , $change_$content,View_Admin_unverified_deleted_factories } from "../global";
import "../auth/middelwares/AdminRedirectToLoginIFUnauthMeddleware.js";

//cancele info
const cancel_factory={
    ele_clickable:".cancel_factory",
    attr_to_get_id:'factory_id',
    class_to_append_with_id_to_remove:"#factory_view_",
    url:API_Path_unverified_deleted_factories,
    type:'DELETE',
    confirm_button:"Force Remove Factory",
    cancel_button:"Cancel",
    message: "Are you sure that ? , you are going to <b><u>Force Delete</u> <strike  style='color: red'>factory</strike></b> .",
    id:"Not Set Yet"
};
//confirmation infp
const confirm_factory={
    ele_clickable:".confirm_factory",
    attr_to_get_id:'factory_id',
    class_to_append_with_id_to_remove:"#factory_view_",
    url:API_Path_unverified_deleted_factories,
    type:'GET',
    confirm_button:"Restore Factory",
    cancel_button:"Cancel",
    message: "Are you sure that ? , you are going to <b><u>Restore</u> <b  style='color: green'>factory</b></b> .",
    id:"Not Set Yet"
};
let info = "request to process";
//confirm set info
$(document).on('click',confirm_factory.ele_clickable,function (e){
    e.preventDefault();
    info = confirm_factory ;
    $("#report .message").html(info.message);
    $("#report #cancel").html(info.cancel_button);
    $("#report #confirm").html(info.confirm_button + "<i style='display: none' id='loading-btn' class='fas fa-cog fa-spin faa-fast'></i>");
    $("#report").fadeIn();
    info.id = $(this).attr(info.attr_to_get_id);
    console.log(info.id);
});
//delete set info
$(document).on('click',cancel_factory.ele_clickable,function (e) {
    e.preventDefault();
    info =cancel_factory;
    $("#report .message").html(info.message);
    $("#report #cancel").html(info.cancel_button);
    $("#report #confirm").html(info.confirm_button + "<i style='display: none' id='loading-btn' class='fas fa-cog fa-spin faa-fast'></i>")
    $("#report").fadeIn();
    info.id = $(this).attr(info.attr_to_get_id);
    console.log(info.id);
});
$(document).ready((e)=>{
    //fadeout the report
    $("#report #cancel").click(() => {
        $("#report").fadeOut(500);
    });
    $("#closeWindow").click(function (e) {
        $("#report").fadeOut(500);
    });
//------------------------loading btn------------------------------------------------------------
    $("#report #confirm").click((e) => {
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
                        $(info.class_to_append_with_id_to_remove + info.id)
                            .animate({
                                position:"absolute",
                                top:"50%",
                                left:"50%",
                                transform: "translate(-50%,-50%)",
                                opacity:0,
                                _zIndex:3
                            },"slow",()=>{
                                $(info.class_to_append_with_id_to_remove + info.id).remove();
                            });
                        $("#alert .message").html(result.msg);
                        $("#alert").fadeIn();
                    }
                }
            });
    });
//------------------------loading btn------------------------------------------------------------
    $(document)
        .ajaxStart(function () {
            $("#loading-btn").show();
            $("#report #confirm").attr("disabled", true);
        })
        .ajaxStop(function () {
            $("#loading-btn").hide();
            $("#report #confirm").attr("disabled", false);
        });
//------------------------Zoom and style property file-------------------------------------------
    $(document).on('click','.property_file_container',function (e){
        var id= $(this).attr('id');
        console.log(id);
        $("#factory_view_"+id)
            .css({
                position:"fixed",
                top:"50%",
                left:"50%",
                transform: "translate(-30%,-45%)",
                border:'5px',
                "z-index":2,
                width:'50%',
                height:'80%'
            }).append("<a href=''><i class='close-alert fas fa-times' style='color:#0a53be;position: absolute;right: 3px;top:3px ;font-size: x-large' ></i></a>");
        $("#property_file_"+id).css({
            position:"relative",
            transition:"none",
            left:'3%',
            top:'1%',
            width:"62%",
            height:"90%",
            "z-index": 8
        }).addClass("zoom");
        $("#factory_view_"+id+" .chip").css({
            width:'200px'
        });
        $("#factory_view_"+id+" h2").css({
            marginTop:'10px',
            textAlign:"left",
            position:"absolute",
            right:'20%'
        });

        $("#factory_view_"+ id +" .close-alert").hover(()=>{
            $("#factory_view_"+ id +" .close-alert").css({
                color:"red"
            });
        }).mouseout(()=>{
            $("#factory_view_"+id+" .close-alert").css({
                color:"darkblue"
            });
        });
        $change_$content("#factory_view_"+id+" .close-alert",View_Admin_unverified_deleted_factories);
    });
//------------------------search-----------------------------------------------------------------
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $('.table .table-row').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
