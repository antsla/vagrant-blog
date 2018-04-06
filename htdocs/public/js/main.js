/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 42);
/******/ })
/************************************************************************/
/******/ ({

/***/ 42:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(43);


/***/ }),

/***/ 43:
/***/ (function(module, exports) {

$(document).ready(function () {
    //> Событие при ответе на чужой комментарий
    $('.response-link').click(function () {
        var id = $(this).attr('data-comment-id');
        $('input[name="response_id"]').val(id);
    });
    //<

    //> Событие всплытия модального окна, для редактирования комментария
    $('.edit-link').click(function () {
        $.ajax({
            "url": "/getCommentAjax",
            "type": "GET",
            "async": false,
            "dataType": "json",
            "data": {
                "id": $(this).attr("data-comment-id")
            }
        }).done(function (data) {
            if (data.result == 'success') {
                $('#commentTitle').text('Редактирование комментария от пользователя "' + data['data']['username'] + '"');
                $('#editComment').val(data['data']['text']);
                $('#editCommentId').val(data['data']['id']);
                $('#modal-comment').modal('show');
            } else if (data.result == 'error') {
                toastr['error'](data['message']);
            }
        }).fail(function () {
            toastr['error']('Server Error!');
        });
    });
    //<

    var mainSwiper = new Swiper('.swiper-container', {
        "loop": true,
        "centeredSlides": true,
        "pagination": {
            "el": '.swiper-pagination'
        },

        // Navigation arrows
        "navigation": {
            "nextEl": '.swiper-button-next',
            "prevEl": '.swiper-button-prev'
        }
    });
});

// Календарь для поля дат
$('.datepickerBS').datepicker({
    "autoclose": true,
    "format": "yyyy-mm-dd"
});

//> Отправка обратнйо связи
$('#fb_submit').on('click', function (event) {
    event.preventDefault();
    $.ajax({
        "url": "/feedbackSendAjax",
        "type": "post",
        "async": "false",
        "dataType": "json",
        "headers": {
            "X-CSRF-TOKEN": $('input[name="_token"]').val()
        },
        "data": {
            "name": $('input[name="fb_name"]').val(),
            "email": $('input[name="fb_email"]').val(),
            "text": $('textarea[name="fb_text"]').val()
        }
    }).done(function (data) {
        if (data.fail) {
            toastr['error'](data.message);
        } else if (data.success) {
            toastr['success'](data.message);
            $('input[name="fb_name"]').val('');
            $('input[name="fb_email"]').val('');
            $('textarea[name="fb_text"]').val('');
        }
    }).fail(function () {
        toastr['error']('Server error!');
    });
});
//<

/***/ })

/******/ });