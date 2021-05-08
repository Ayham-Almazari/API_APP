import "../auth/logoutAdmin";
import "../auth/middelwares/AdminRedirectToLoginIFUnauthMeddleware.js";
import {View_Admin_Home,$auth$clickAJAX} from "../global.js";
$(document).ready(function() {
    $auth$clickAJAX(".home_page",View_Admin_Home);



});
