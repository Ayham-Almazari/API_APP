/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/global.js":
/*!********************************!*\
  !*** ./resources/js/global.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "path": () => (/* binding */ path)
/* harmony export */ });
var path = "http://127.0.0.1:8000/api/v1/auth/admin/login";


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
/*!************************************!*\
  !*** ./resources/js/LoginAdmin.js ***!
  \************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _global_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./global.js */ "./resources/js/global.js");
 // ------ ajax

$("#admin_login").click(function (e) {
  e.preventDefault();
  var formData = new FormData($('#loginForm')[0]);
  $.ajax({
    url: _global_js__WEBPACK_IMPORTED_MODULE_0__.path,
    //PHP file to execute
    type: 'POST',
    //method used POST or GET
    dataType: "json",
    data: formData,
    // Parameters passed to the PHP file
    processData: false,
    contentType: false,
    cache: false,
    // enctype:'multipart/form-data',
    success: function success(result) {// Has to be there !
      // console.log(result);
    },
    error: function error(result, status, _error) {// Handle errors
    }
  }).done(function (result) {
    console.log(result);
    localStorage.setItem('_token', result._token);
    console.log($("input[name='identifier']").val(), $("#inputPassword3").val(), {
      chexckbox: $("#gridCheck1").is(':checked'),
      local: localStorage.getItem('_token')
    });
    $("#identifier_error").hide();
    $("#password_error").hide();
    $("#Invalid_User").hide();
  }).fail(function (result) {
    if (result.responseJSON.hasOwnProperty('errors')) {
      result.responseJSON.errors.hasOwnProperty("identifier") ? $("#identifier_error").text(result.responseJSON.errors.identifier[0]).show() : $("#identifier_error").css({
        "display": 'none'
      });
      result.responseJSON.errors.hasOwnProperty("password") ? $("#password_error").text(result.responseJSON.errors.password[0]).show() : null;
    } else {
      $("#identifier_error").css({
        "display": 'none'
      });
      $("#password_error").css({
        "display": 'none'
      });
    }

    result.responseJSON.hasOwnProperty("general") ? $("#Invalid_User").text(result.responseJSON.general).show() : $("#Invalid_User").hide();
  }).always(function () {});
});
var $loading_icon = $('#loading-icon').hide();
var $loading_overlay = $('.overlay').hide();
$(document).ajaxStart(function () {
  $loading_icon.show();
  $loading_overlay.show();
}).ajaxStop(function () {
  $loading_icon.hide();
  $loading_overlay.hide();
});
})();

/******/ })()
;