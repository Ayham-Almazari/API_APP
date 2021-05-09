import {API_Path_unverified_factories } from "../global";
import "../auth/middelwares/AdminRedirectToLoginIFUnauthMeddleware.js";

    let info={
        ele_clickable:".cancel_factory",
        attr_to_get_id:'factory_id',
        class_to_append_with_id_to_remove:"#factory_view_",
        url:API_Path_unverified_factories,
        type:'DELETE',
        confirm_button:"Remove Factory",
        cancel_button:"Cancel",
        message: "Are you sure that ? , you are going to <b><u>remove</u> <strike  style='color: red'>factory</strike></b> .",
        id:"Not Set Yet"
    };
    console.log(info)

//delete
$(document).on('click',info.ele_clickable,function (e) {
    e.preventDefault();
    $("#report .message").html(info.message);
    $("#report #cancel").html(info.cancel_button).click(() => {
        $("#report").fadeOut(500);
    });
    $("#report").fadeIn();
    $("#closeWindow").click(function (e) {
        $("#report").fadeOut(500);
    });
    info.id = $(this).attr(info.attr_to_get_id);
});
    $("#report #confirm").html(info.confirm_button + "<i style='display: none' id='loading-btn' class='fas fa-cog fa-spin faa-fast'></i>")
        .click((e) => {
            $.ajax(
                {
                    async: true,   // this will solve the problem
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
                            $("#alert").animate({left: '50%'}).fadeIn();
                        }
                    }
                });
        });
$(document).ajaxStart(function () {
    $("#loading-btn").show();
}).ajaxStop(function () {
    $("#loading-btn").hide();
});

