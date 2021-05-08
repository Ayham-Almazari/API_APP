/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/auth/logoutAdmin.js":
/*!******************************************!*\
  !*** ./resources/js/auth/logoutAdmin.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _global__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../global */ "./resources/js/global.js");
// ------ ajax

$('#Logout').click(function () {
  $.ajax({
    url: _global__WEBPACK_IMPORTED_MODULE_0__.API_Admin_Logout,
    //PHP file to execute
    type: 'GET',
    //method used POST or GET
    dataType: "json",
    headers: {
      "Authorization": "Bearer " + localStorage.getItem('_token')
    }
  }).done(function (result) {
    localStorage.clear();
    window.location.href = _global__WEBPACK_IMPORTED_MODULE_0__.View_Admin_Login;
  }).fail(function (result) {
    console.log(result.responseJSON.message);
  }).ajaxStop;
});

/***/ }),

/***/ "./resources/js/auth/middelwares/AdminRedirectToLoginIFUnauthMeddleware.js":
/*!*********************************************************************************!*\
  !*** ./resources/js/auth/middelwares/AdminRedirectToLoginIFUnauthMeddleware.js ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _global__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../global */ "./resources/js/global.js");
// ------ ajax

$.ajax({
  url: _global__WEBPACK_IMPORTED_MODULE_0__.AdminAuthMiddelwareRoute,
  //PHP file to execute
  type: 'GET',
  //method used POST or GET
  dataType: "json",
  headers: {
    "Authorization": "Bearer " + localStorage.getItem('_token')
  }
}).done(function (result) {
  localStorage.setItem('user', result.data.user.profile.first_name + " " + result.data.user.profile.last_name);
  localStorage.setItem('picture', result.data.user.profile.picture);
  $(".profile-image").attr('src', localStorage.getItem('picture'));
  $("#profile_name").html(localStorage.getItem('user'));
}).fail(function (result) {
  window.location.href = _global__WEBPACK_IMPORTED_MODULE_0__.View_Admin_Login;
}).ajaxStop;

/***/ }),

/***/ "./resources/js/global.js":
/*!********************************!*\
  !*** ./resources/js/global.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

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


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		if(__webpack_module_cache__[moduleId]) {
/******/ 			return __webpack_module_cache__[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
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
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!********************************************!*\
  !*** ./resources/js/components/nav-bar.js ***!
  \********************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _auth_logoutAdmin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../auth/logoutAdmin */ "./resources/js/auth/logoutAdmin.js");
/* harmony import */ var _auth_middelwares_AdminRedirectToLoginIFUnauthMeddleware_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../auth/middelwares/AdminRedirectToLoginIFUnauthMeddleware.js */ "./resources/js/auth/middelwares/AdminRedirectToLoginIFUnauthMeddleware.js");
/* harmony import */ var _global_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../global.js */ "./resources/js/global.js");



$(document).ready(function () {
  (0,_global_js__WEBPACK_IMPORTED_MODULE_2__.$auth$clickAJAX)(".home_page", _global_js__WEBPACK_IMPORTED_MODULE_2__.View_Admin_Home);
});
})();

/******/ })()
;