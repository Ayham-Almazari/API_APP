// ------ ajax
import {API_Admin_Logout ,View_Admin_Login} from "../global";

$('#Logout').click(function (){
    $.ajax({
        url : API_Admin_Logout, //PHP file to execute
        type : 'GET', //method used POST or GET
        dataType: "json",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem('_token')
        }
    }).done(function (result){
        localStorage.clear();
        window.location.href= View_Admin_Login;
    }).fail(function (result){
        console.log(result.responseJSON.message);
    }).ajaxStop;
});


