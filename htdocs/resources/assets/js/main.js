// Слайдер
$(document).ready(function(){
    var mainSwiper = new Swiper ('.swiper-container', {
        loop: true,

        // If we need pagination
        pagination: {
            el: '.swiper-pagination'
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        }
    });
});
// Календарь для поля дат
$('.datepickerBS').datepicker({
    "autoclose" : true,
    "format" : "yyyy-mm-dd"
});
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