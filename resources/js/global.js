//__________API_______________
const API_Path ="http://127.0.0.1:8000/api/v1/auth/admin/";
const API_Admin_Login= API_Path + "login";
const API_Admin_Logout= API_Path + "logout";
const AdminAuthMiddelwareRoute = API_Path + 'user';

//-------------View_Admin_unauthenticated_factories--------------
const API_Path_unverified_factories  ="http://127.0.0.1:8000/api/v1/dashboard/factories/underverificationfactories/";


//_________Views______________
const Views_Path ="http://localhost:3000/tallybills/admins/dashboard/";
const View_Admin_Login= Views_Path + "login";
const View_Admin_Home= Views_Path + "home";
const View_Admin_unverified_factories= Views_Path + "unverified-factories";

// ------------helper
const get_content=function ($result , $url ){
    $("#content").html($result.substring($result.indexOf("<!--__CONTENT__-->"),$result.indexOf("<!--END__CONTENT__-->")));
    window.history.pushState("","unverified", $url);
};
export const $auth$clickAJAX=function ($ele, $url) {
    $($ele).click(function (e){
        e.preventDefault();
        $.ajax({
            url : $url, //PHP file to execute
            type : 'GET', //method used POST or GET
            dataType: "html",
            headers: {
                "Authorization": "Bearer " + localStorage.getItem('_token')
            }
        }).done(function (result){
            get_content(result,$url);
        }).fail(function (result){
            console.log(result.responseJSON.message);
        }).ajaxStop;
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
    get_content
};
