$(document).ready(function(){
    //> Событие при ответе на чужой комментарий
    $('.response-link').click(function() {
        var id = $(this).attr('data-comment-id');
        $('input[name="response_id"]').val(id);
    });
    //<

    //> Событие всплытия модального окна, для редактирования комментария
    $('.edit-link').click(function() {
        $.ajax({
            "url" : "/getCommentAjax",
            "type" : "GET",
            "async" : false,
            "dataType" : "json",
            "data" : {
                "id" : $(this).attr("data-comment-id")
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

    var mainSwiper = new Swiper ('.swiper-container', {
        "loop" : true,
        "centeredSlides" : true,
        "pagination" : {
            "el" : '.swiper-pagination'
        },

        // Navigation arrows
        "navigation" : {
            "nextEl" : '.swiper-button-next',
            "prevEl" : '.swiper-button-prev'
        }
    });
});

// Календарь для поля дат
$('.datepickerBS').datepicker({
    "autoclose" : true,
    "format" : "yyyy-mm-dd"
});

//> Отправка обратнйо связи
$('#fb_submit').on('click', function(event) {
    event.preventDefault();
    $.ajax({
        "url" : "/feedbackSendAjax",
        "type" : "post",
        "async" : "false",
        "dataType" : "json",
        "headers" : {
            "X-CSRF-TOKEN" : $('input[name="_token"]').val()
        },
        "data" : {
            "name" : $('input[name="fb_name"]').val(),
            "email" : $('input[name="fb_email"]').val(),
            "text" : $('textarea[name="fb_text"]').val()
        }
    }).done(function(data) {
        if (data.fail) {
            toastr['error'](data.message);
        } else if (data.success) {
            toastr['success'](data.message);
            $('input[name="fb_name"]').val('');
            $('input[name="fb_email"]').val('');
            $('textarea[name="fb_text"]').val('')
        }
    }).fail(function() {
        toastr['error']('Server error!');
    });
});
//<