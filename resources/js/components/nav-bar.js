import "../auth/logoutAdmin";
import "../auth/middelwares/AdminRedirectToLoginIFUnauthMeddleware.js";
import {View_Admin_Home,$change_$content} from "../global.js";
$(document).ready(function() {
    $change_$content(".home_page",View_Admin_Home);

});
