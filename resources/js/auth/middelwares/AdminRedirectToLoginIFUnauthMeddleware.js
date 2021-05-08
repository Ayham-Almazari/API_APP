// ------ ajax
import {AdminAuthMiddelwareRoute, View_Admin_Login} from "../../global";

$.ajax({
        url : AdminAuthMiddelwareRoute, //PHP file to execute
        type : 'GET', //method used POST or GET
        dataType: "json",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem('_token')
        }
     }).done(function (result){
          localStorage.setItem('user',result.data.user.profile.first_name + " " +result.data.user.profile.last_name);
          localStorage.setItem('picture',result.data.user.profile.picture);
          $(".profile-image").attr('src',localStorage.getItem('picture'));
          $("#profile_name").html(localStorage.getItem('user'));
       }).fail(function (result){
       window.location.href= View_Admin_Login;
        }).ajaxStop;

