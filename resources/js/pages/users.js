import {
    API_Path_unverified_owners,
    $change_$content,
    View_Admin_unverified_owners,
    API_Admin_Register, View_Admin_users, $reload_$content, API_Admin_Delete
} from "../global";
import "../auth/middelwares/AdminRedirectToLoginIFUnauthMeddleware.js";
import $ from "jquery";

//cancele info
const cancel_factory = {
    ele_clickable: ".remove_admin",
    attr_to_get_id: 'admin_id',
    class_to_append_with_id_to_remove: "#admin_view_",
    url: API_Admin_Delete,
    type: 'DELETE',
    confirm_button: "Force Delete Admin",
    cancel_button: "Cancel",
    message: "Are you sure that ? , you are going to <b><u>REMOVE</u> <strike  style='color: red'>Admin</strike></b> .",
    id: "Not Set Yet"
};
//confirmation infp
const add_admin = {
    ele_clickable: ".add-admin-tr",
    url: API_Admin_Register,
    attr_to_get_id:"username",
    type: 'GET',
    confirm_button: "Set As Admin",
    cancel_button: "Cancel",
    message: "Are you sure that ? , you are going to <b><u>assign </u><b> Admin : </b> <br><br> ",
    username: "Not Set Yet"
};
let info = "request to process";

//confirm set info
$(document).on('click', add_admin.ele_clickable, function (e) {
    info = add_admin;
    info.username = $(this).attr(info.attr_to_get_id );
    $("#report .message").html(info.message +"\'"+ info.username + " \'");
    $("#report #cancel").html(info.cancel_button);
    $("#report #confirm").html(info.confirm_button + "<i style='display: none' id='loading-btn' class='fas fa-cog fa-spin faa-fast'></i>");
    $("#report").fadeIn();
});
//delete set info
$(document).on('click', cancel_factory.ele_clickable, function (e) {
    e.preventDefault();
    info = cancel_factory;
    $("#report .message").html(info.message);
    $("#report #cancel").html(info.cancel_button);
    $("#report #confirm").html(info.confirm_button + "<i style='display: none' id='loading-btn' class='fas fa-cog fa-spin faa-fast'></i>")
    $("#report").fadeIn();
    info.id = $(this).attr(info.attr_to_get_id);
    console.log(info.id);
});
$(document).ready((e) => {
    //show admins
    $(".adminCount").click(() => {
        $(".buyerCount").removeClass('active_users');
        $(".ownerCount").removeClass('active_users');
        $(".adminCount").addClass('active_users');
        $("#BuyersTable").hide();
        $("#OwnersTable").hide();
        $("#AdminsTable").show();
    });
    $(".buyerCount").click(() => {
        $(".adminCount").removeClass('active_users');
        $(".ownerCount").removeClass('active_users');
        $(".buyerCount").addClass('active_users');
        $("#OwnersTable").hide();
        $("#AdminsTable").hide();
        $("#BuyersTable").show();
    });
    $(".ownerCount").click(() => {
        $(".buyerCount").removeClass('active_users');
        $(".adminCount").removeClass('active_users');
        $(".ownerCount").addClass('active_users');
        $("#BuyersTable").hide();
        $("#AdminsTable").hide();
        $("#OwnersTable").show();
    });

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
                url: (info.type === "DELETE") ? info.url + info.id : info.url + info.username,
                type: info.type,
                headers: {"Authorization": "Bearer " + localStorage.getItem('_token')}
                ,
                success: function (result, status) {
                    if (status === "success") {
                        if(info.type === "DELETE"){
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
                            $("#countaminstodecrease").html(eval($("#countaminstodecrease").text() - 1));
                            $("#alert").fadeIn();
                        }else{
                            $("#report").fadeOut(500);
                            $('#AddAdminRequest').fadeOut('500');
                            $("#alert .message").html(result.msg);
                            $("#alert").fadeIn();
                            //--------------relocation----------------
                            $reload_$content(View_Admin_users);
                        }

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

    $("#search").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $('.table .table-row').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    $('#searchforadmins').on('keyup', function () {
        let $value = $(this).val();
        $.ajax({
            type: 'get',
            url: 'http://localhost:8000/api/v1/dashboard/search',
            headers: {
                "Authorization": "Bearer " + localStorage.getItem('_token')
            },
            data: {'search': $value},
            success: function (data) {
                $('#tabledata').html(data);
            }
        });
    });
    $("#btn-add-admin").click((e) => {
        e.preventDefault();
        $('#AddAdminRequest').fadeIn();
        $('input').focus();
    });

    $('.close-alert').click(() => {
        $('#AddAdminRequest').fadeOut('500');
    });

});



