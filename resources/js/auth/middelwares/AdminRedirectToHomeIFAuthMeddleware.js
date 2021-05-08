// ------ ajax
import {AdminAuthMiddelwareRoute ,View_Admin_Home} from "../../global.js";

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
    window.location.href= View_Admin_Home;
      }).fail(function (result){
      console.log(result.responseJSON.message);
        }).ajaxStop;

