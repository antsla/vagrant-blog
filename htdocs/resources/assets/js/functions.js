// Фильтрация статей на главной
function articleFilter()
{
    $('#articleContainer').html('<img src="js/img/ajax-loader.gif" class="ajax-loader" />');
    $.ajax({
        "url" : "getFilterArticlesAjax",
        "type" : "GET",
        "async" : false,
        "dataType" : "json",
        "data" : {
            "name" : $('input[name="name"]').val(),
            "group_id" : $('select[name="group_id"]').val(),
            "dateFrom" : $('input[name="dateFrom"]').val(),
            "dateTo" : $('input[name="dateTo"]').val(),
            "_token" : $('input[name="_token"]').val()
        }
    }).done(function (data) {
        if (data == 'empty') {
            $('#articleContainer').text('');
            toastr["warning"]("По Вашему запросу ничего не найдено!");
        } else {
            $('#articleContainer').html(data);
        }
    }).fail(function () {
        $('#articleContainer').text('');
        toastr["error"]("Произошла ошибка!");
    });
}


//> Функция обновления текста комментария
function updateComment() {
    var idVal = $('#editCommentId').val();
    var commentVal = $('#editComment').val();
    $.ajax({
        "url" : "/updateCommentAjax",
        "type" : "PUT",
        "async" : false,
        "dataType" : "json",
        "data" : {
            "id" : idVal,
            "text" : commentVal
        }
    }).done(function (data) {
        if (data.result == 'success') {
            $('#data-comment-' + idVal).text(commentVal);
            $('#modal-comment').modal('hide')
            toastr['success'](data.message);
        } else if (data.result == 'error') {
            toastr['error'](data.message);
        }
    }).fail(function () {
        toastr['error']('Server error!');
    });
}
//<