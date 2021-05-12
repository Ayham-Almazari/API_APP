//__________API_______________
import $ from "jquery";

const API_Path ="http://127.0.0.1:8000/api/v1/auth/admin/";
const API_Admin_Login= API_Path + "login";
const API_Admin_Logout= API_Path + "logout";
const AdminAuthMiddelwareRoute = API_Path + 'user';

//-------------View_Admin_unauthenticated_factories--------------
const API_Path_unverified_factories  ="http://127.0.0.1:8000/api/v1/dashboard/factories/underverificationfactories/";
const API_Path_unverified_deleted_factories  ="http://127.0.0.1:8000/api/v1/dashboard/factories/underverificationfactoriesfordlete/";


//_________Views______________
const Views_Path ="http://localhost:3000/tallybills/admins/dashboard/";
const View_Admin_Login= Views_Path + "login";
const View_Admin_Home= Views_Path + "home";
const View_Admin_unverified_factories= Views_Path + "unverified-factories";
const View_Admin_unverified_deleted_factories= Views_Path + "unverified-deleted-factories";

// ------------helper functions
//----replace content
const set_content=function ($result){
    $("#content").html($result.substring($result.indexOf("<!--__CONTENT__-->"),$result.indexOf("<!--END__CONTENT__-->")));
};
const set_css=function ($result){
    $("#css").replaceWith($result.substring($result.indexOf("<!--Css-->"),$result.indexOf("<!--END-Css-->")));
};
const set_title=function ($result){
    $("#title").replaceWith($result.substring($result.indexOf("<!--Title-->"),$result.indexOf("<!--END-Title-->")));
};
export const $change_$content=function ($ele, $url) {
        $($ele).click(function (e){
            e.preventDefault();
            $.ajax(
                {
                    url: $url,
                    type: "GET",
                    dataType:"text",
                    success: function (result,status) {
                        if (status === "success"){
                            set_css(result);
                            set_title(result);
                            set_content(result);
                            // $("#content").load($url +" #content");
                            window.history.pushState("","unverified", $url);
                            // $("#content").empty().load($url +" #content");
                        }
                    },
                });
        });
};



export {
    API_Path,
    API_Admin_Login,
    API_Admin_Logout,
    API_Path_unverified_factories,
    AdminAuthMiddelwareRoute,
    View_Admin_Login,
    View_Admin_Home,
    View_Admin_unverified_factories,
    API_Path_unverified_deleted_factories,
    View_Admin_unverified_deleted_factories
};
