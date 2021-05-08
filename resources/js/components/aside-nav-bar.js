import {
    View_Admin_unverified_factories,
    API_Path_unverified_factories,
    get_content,
    $auth$clickAJAX
} from "../global.js";


$(document).ready(function() {
    $auth$clickAJAX('#Under_Verification_Factories',View_Admin_unverified_factories);
});
