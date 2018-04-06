
// Загружаем список настроек
$.ajax({
    "url" : "/admin/getSettingsAjax",
    "type" : "GET",
    "async" : false,
    "dataType" : 'json',
    "sortKey" : 'name',
    "success" : function(data) {
        dataSettings = data;
    }
});

var appSetting = new Vue({
    "el" : '#appSetting',
    "data" : {
        "settings" : dataSettings,
        "newSet" : {
            "name" : '',
            "value" : ''
        },
        "editSet" : '',
        "sorting" : {
            "name" : false,
            "value" : '-'
        }
    },
    "methods" : {
        //> Сортировка по имени
        "nameSort" : function() {
            this.sorting.value = '-';
            this.sorting.name = !this.sorting.name;
            var sorting = this.sorting.name;
            return this.settings.sort(function(a, b) {
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
        "valueSort" : function() {
            this.sorting.name = '-';
            this.sorting.value = !this.sorting.value;
            var sorting = this.sorting.value;
            return this.settings.sort(function(a, b) {
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
        "addSetting" : function() {
            var setName = this.newSet.name;
            var setVal = this.newSet.value;
            var settingsArray = this.settings;
            if (this.newSet.name && this.newSet.value) {
                var sendData = {
                    "name" : setName,
                    "value" : setVal,
                    "_token" : $('input[name="_token"]').val()
                };
                $.ajax({
                    "url" : "/admin/addSettingAjax",
                    "type" : "POST",
                    "async" : false,
                    "dataType" : "json",
                    "data" : sendData
                }).done(function (data) {
                    if (data.result == 'error') {
                        toastr["error"](data.content);
                    } else if (data.result == 'success') {
                        success = data.content;
                    }
                }).fail(function() {
                    toastr["error"]("Server error!");
                });
            } else {
                toastr["error"]("Пожайлуйста заполните оба поля!");
            }
            if (success) {
                this.newSet.name = this.newSet.value = '';
                settingsArray.push({
                    "name" : setName,
                    "value" : setVal,
                    "id" : success
                });
                toastr["success"]("Настройка успешно добавлена");
            }
        },
        //> Функция обновления произвольного поля
        "updSetting" : function(id, name, value) {
            var sendData = {
                "id" : id,
                "name" : name,
                "value" : value
            };
            $.ajax({
                "url" : "/admin/updSettingAjax",
                "type" : "PUT",
                "async" : false,
                "dataType" : "json",
                "data" : sendData
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
        "delSetting" : function(id, index) {
            if (confirm('Вы дествительно хотите удалить запись?')) {
                $.ajax({
                    "url" : "/admin/delSettingAjax",
                    "type" : "DELETE",
                    "async" : false,
                    "dataType" : "json",
                    "data" : {
                        "id" : id
                    }
                }).done(function(data) {
                    if (data.result == 'error') {
                        toastr["error"](data.content);
                    } else if (data.result == 'success') {
                        success = true;
                        toastr["success"](data.content);
                    }
                }).fail(function() {
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