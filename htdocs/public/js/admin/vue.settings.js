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
/******/ 	return __webpack_require__(__webpack_require__.s = 46);
/******/ })
/************************************************************************/
/******/ ({

/***/ 46:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(47);


/***/ }),

/***/ 47:
/***/ (function(module, exports) {


// Загружаем список настроек
$.ajax({
    "url": "/admin/getSettingsAjax",
    "type": "GET",
    "async": false,
    "dataType": 'json',
    "sortKey": 'name',
    "success": function success(data) {
        dataSettings = data;
    }
});

var appSetting = new Vue({
    "el": '#appSetting',
    "data": {
        "settings": dataSettings,
        "newSet": {
            "name": '',
            "value": ''
        },
        "editSet": '',
        "sorting": {
            "name": false,
            "value": '-'
        }
    },
    "methods": {
        //> Сортировка по имени
        "nameSort": function nameSort() {
            this.sorting.value = '-';
            this.sorting.name = !this.sorting.name;
            var sorting = this.sorting.name;
            return this.settings.sort(function (a, b) {
                var nameA = a.name;
                var nameB = b.name;
                if (nameA < nameB) {
                    return -1 * Math.pow(-1, +sorting);
                } else if (nameA > nameB) {
                    return Math.pow(-1, +sorting);
                } else {
                    return 0;
                }
            });
        },
        //> Сортировка по значению
        "valueSort": function valueSort() {
            this.sorting.name = '-';
            this.sorting.value = !this.sorting.value;
            var sorting = this.sorting.value;
            return this.settings.sort(function (a, b) {
                var valA = a.value;
                var valB = b.value;
                if (valA < valB) {
                    return -1 * Math.pow(-1, +sorting);
                } else if (valA > valB) {
                    return Math.pow(-1, +sorting);
                } else {
                    return 0;
                }
            });
        },
        //> Функция добавления настройки
        "addSetting": function addSetting() {
            var setName = this.newSet.name;
            var setVal = this.newSet.value;
            var settingsArray = this.settings;
            if (this.newSet.name && this.newSet.value) {
                var sendData = {
                    "name": setName,
                    "value": setVal,
                    "_token": $('input[name="_token"]').val()
                };
                $.ajax({
                    "url": "/admin/addSettingAjax",
                    "type": "POST",
                    "async": false,
                    "dataType": "json",
                    "data": sendData
                }).done(function (data) {
                    if (data.result == 'error') {
                        toastr["error"](data.content);
                    } else if (data.result == 'success') {
                        success = data.content;
                    }
                }).fail(function () {
                    toastr["error"]("Server error!");
                });
            } else {
                toastr["error"]("Пожайлуйста заполните оба поля!");
            }
            if (success) {
                this.newSet.name = this.newSet.value = '';
                settingsArray.push({
                    "name": setName,
                    "value": setVal,
                    "id": success
                });
                toastr["success"]("Настройка успешно добавлена");
            }
        },
        //> Функция обновления произвольного поля
        "updSetting": function updSetting(id, name, value) {
            var sendData = {
                "id": id,
                "name": name,
                "value": value
            };
            $.ajax({
                "url": "/admin/updSettingAjax",
                "type": "PUT",
                "async": false,
                "dataType": "json",
                "data": sendData
            }).done(function (data) {
                if (data.result == 'error') {
                    toastr["error"](data.content);
                } else if (data.result == 'success') {
                    success = true;
                    toastr["success"](data.content);
                }
            }).fail(function () {
                toastr["error"]("Server error!");
            });
            if (success) {
                this.editSet = '';
            }
        },
        //> Удаление настройки
        "delSetting": function delSetting(id, index) {
            if (confirm('Вы дествительно хотите удалить запись?')) {
                $.ajax({
                    "url": "/admin/delSettingAjax",
                    "type": "DELETE",
                    "async": false,
                    "dataType": "json",
                    "data": {
                        "id": id
                    }
                }).done(function (data) {
                    if (data.result == 'error') {
                        toastr["error"](data.content);
                    } else if (data.result == 'success') {
                        success = true;
                        toastr["success"](data.content);
                    }
                }).fail(function () {
                    toastr["error"]("Server error!");
                });
                if (success) {
                    this.settings.splice(index, 1);
                }
            }
        }
        //<
    }
});

/***/ })

/******/ });