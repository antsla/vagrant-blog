function orderToUp(id) {
    $.ajax({
        "url" : "/admin/slider/order",
        "type" : "GET",
        "async" : false,
        "dataType" : "json",
        "data" : {
            "id" : id,
            "direction" : "up"
        }
    }).done(function (content) {
        if (content.result == 'error') {
            toastr["error"]("Ошибка сортировки!");
        } else {
            $('#slider-edit-block').html(content.data);
        }
    }).fail(function() {
        toastr["error"]("Произошла ошибка!");
    });
}

function orderToDown(id) {
    $.ajax({
        "url" : "/admin/slider/order",
        "type" : "GET",
        "async" : false,
        "dataType" : "json",
        "data" : {
            "id" : id,
            "direction" : "down"
        }
    }).done(function (content) {
        if (content.result == 'error') {
            toastr["error"]("Ошибка сортировки!");
        } else {
            $('#slider-edit-block').html(content.data);
        }
    }).fail(function() {
        toastr["error"]("Произошла ошибка!");
    });
}