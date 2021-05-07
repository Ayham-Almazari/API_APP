import {path} from "./global.js";

// ------ ajax
$("#admin_login").click(function (e){
    e.preventDefault();
    const formData = new FormData($('#loginForm')[0]);
    $.ajax({
        url : path, //PHP file to execute
        type : 'POST', //method used POST or GET
        dataType: "json",
        data : formData, // Parameters passed to the PHP file
        processData : false,
        contentType:false,
        cache:false,
        // enctype:'multipart/form-data',
        success : function(result){ // Has to be there !
            // console.log(result);
        },
        error : function(result, status, error){ // Handle errors

        }

    }).done(function (result){
        console.log(result);
        localStorage.setItem('_token',result._token);
        console.log(
            $("input[name='identifier']").val() ,
            $("#inputPassword3").val() ,
            {chexckbox:$("#gridCheck1").is(':checked'),
                local : localStorage.getItem('_token')}
        );
        $("#identifier_error").hide();
        $("#password_error").hide();
        $("#Invalid_User").hide();
    }).fail(function (result){
        if (result.responseJSON.hasOwnProperty('errors')){
            result.responseJSON.errors.hasOwnProperty("identifier") ? $("#identifier_error").text(result.responseJSON.errors.identifier[0]).show():$("#identifier_error").css({"display":'none'});
            result.responseJSON.errors.hasOwnProperty("password") ? $("#password_error").text(result.responseJSON.errors.password[0]).show():null;
        }else {
            $("#identifier_error").css({"display":'none'});
            $("#password_error").css({"display":'none'});
        }
        result.responseJSON.hasOwnProperty("general") ? $("#Invalid_User").text(result.responseJSON.general).show():$("#Invalid_User").hide();
    }).always(function (){

    });
});

var $loading_icon = $('#loading-icon').hide();
var $loading_overlay = $('.overlay').hide();
$(document).ajaxStart(function (){
    $loading_icon.show();
    $loading_overlay.show();
}).ajaxStop(function() {
    $loading_icon.hide();
    $loading_overlay.hide();
});

