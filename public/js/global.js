/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/global.js ***!
  \********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "$auth$clickAJAX": () => (/* binding */ $auth$clickAJAX),
/* harmony export */   "API_Path": () => (/* binding */ API_Path),
/* harmony export */   "API_Admin_Login": () => (/* binding */ API_Admin_Login),
/* harmony export */   "API_Admin_Logout": () => (/* binding */ API_Admin_Logout),
/* harmony export */   "API_Path_unverified_factories": () => (/* binding */ API_Path_unverified_factories),
/* harmony export */   "AdminAuthMiddelwareRoute": () => (/* binding */ AdminAuthMiddelwareRoute),
/* harmony export */   "View_Admin_Login": () => (/* binding */ View_Admin_Login),
/* harmony export */   "View_Admin_Home": () => (/* binding */ View_Admin_Home),
/* harmony export */   "View_Admin_unverified_factories": () => (/* binding */ View_Admin_unverified_factories),
/* harmony export */   "get_content": () => (/* binding */ get_content)
/* harmony export */ });
//__________API_______________
var API_Path = "http://127.0.0.1:8000/api/v1/auth/admin/";
var API_Admin_Login = API_Path + "login";
var API_Admin_Logout = API_Path + "logout";
var AdminAuthMiddelwareRoute = API_Path + 'user'; //-------------View_Admin_unauthenticated_factories--------------

var API_Path_unverified_factories = "http://127.0.0.1:8000/api/v1/dashboard/factories/underverificationfactories/"; //_________Views______________

var Views_Path = "http://localhost:3000/tallybills/admins/dashboard/";
var View_Admin_Login = Views_Path + "login";
var View_Admin_Home = Views_Path + "home";
var View_Admin_unverified_factories = Views_Path + "unverified-factories"; // ------------helper

var get_content = function get_content($result, $url) {
  $("#content").html($result.substring($result.indexOf("<!--__CONTENT__-->"), $result.indexOf("<!--END__CONTENT__-->")));
  window.history.pushState("", "unverified", $url);
};

var $auth$clickAJAX = function $auth$clickAJAX($ele, $url) {
  $($ele).click(function (e) {
    e.preventDefault();
    $.ajax({
      url: $url,
      //PHP file to execute
      type: 'GET',
      //method used POST or GET
      dataType: "html",
      headers: {
        "Authorization": "Bearer " + localStorage.getItem('_token')
      }
    }).done(function (result) {
      get_content(result, $url);
    }).fail(function (result) {
      console.log(result.responseJSON.message);
    }).ajaxStop;
  });
};

/******/ })()
;