import {
    UpdateFactoryPermissions,
    API_Admin_Register, View_Admin_users, $reload_$content, API_Admin_Delete, View_Admin_Manage_Factories
} from "../global";
import "../auth/middelwares/AdminRedirectToLoginIFUnauthMeddleware.js";

    $(document)
        .ajaxStart(function () {
            $(".loading-btn").show();
            $("#report #confirm").attr("disabled", true);
        })
        .ajaxStop(function () {
            $(".loading-btn").hide();
            $("#report #confirm").attr("disabled", false);
        });

    $("#search").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $('#component .col').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
//factory permissions
    $('.ChangePermissions').click(function (e){
        var id = $(this).attr('forfactory');
        let $data={
            CanAddCategory:   $('#CanAddCategory'+id).is(':checked')?1:0,
            CanUpdateCategory:$('#CanUpdateCategory'+id).is(':checked')?1:0,
            CanAddProduct:    $('#CanAddProduct'+id).is(':checked')?1:0,
            CanUpdateProduct: $('#CanUpdateProduct'+id).is(':checked')?1:0
        };
        console.log($data,id);
        $.ajax({
            type: 'PUT',
            url: UpdateFactoryPermissions+id,
            headers: {
                "Authorization": "Bearer " + localStorage.getItem('_token')
            },
            data: $data,
            success: function (data) {
                console.log(data);
                // $('#tabledata').html(data);
                $("#alert .message").html(data.msg);
                $("#alert").fadeIn();
            }
        });

    });


    //Show-Factory-Products
$('.Show-Factory-Products').click(function (e){
    var id = $(this).attr('forfactory');
    console.log(id);
    $("#ProductsContent"+id).load(View_Admin_Manage_Factories + id+ "/products");
});


