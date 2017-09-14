/**
 * Created by Дария on 08.08.2017.
 */
$(document).ready(function () {
    var answNum = 2, questionNum = 2;
    /*$('body').fallings({

     velocity: 0.5,
     initialPosition: -200,
     bgParallax: true,
     bgPercent: "0%",
     onClass: "fallings-visible",
     offClass: "fallings-invisible"

     });*/

    $('body').on('click', '.btn-add-answ', function () {
        $(this).before('<div class="form-group">' +
            '<label for="test-answ-' + answNum + '" class="col-md-3 control-label">Ответ ' + answNum + ':</label>' +
            '<div class = "col-md-9"><input id="test-answ-' + answNum + '" type="text" name="test-answ-' + answNum + '" class="form-control"></div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label class="form-check-label">' +
            '<input class="form-check-input right-answ-' + answNum + '" type="checkbox" name="right-answ-' + answNum + '" id="right-answ-" ' + answNum + ' value="option1">' +
            ' Правильный ответ ' +
            '</label>' +
            '</div>' +
            '</div>');
        answNum++;
    });

    $('body').on('click', '.btn-add-question', function () {
        $(this).before('<div class = "question-group">' +
            '<div class="form-group">' +
            '<label for="test-question-' + questionNum + '" class="col-md-3 control-label">Вопрос ' + questionNum + '</label>' +
            '<div class = "col-md-9">' +
            '<input id="test-question-' + questionNum + '" type="text" name="test-question-' + questionNum + '" class="form-control">' +
            '</div>' +
            '</div>' +
            '<div class="clearfix"></div>' +
            '<div class="answer-group">' +
            '<div class="form-group">' +
            '<label for="test-answ-' + answNum + '" class="col-md-3 control-label">Ответ ' + answNum + '</label>' +
            '<div class = "col-md-9">' +
            '<input id="test-answ-' + answNum + '" type="text" name="test-answ-' + answNum + '" class="form-control">' +
            '</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label class="form-check-label">' +
            '<input class="form-check-input right-answ-1" type="checkbox" name="right-answ-1" id="right-answ-1" value="true" checked>' +
            'Правильный ответ' +
            '</label></div>' +
            '<button type="button" class="btn btn-add-answ add-answ-' + questionNum + '">Добавить ответ</button>' +
            '</div>' +
            '</div>');
        questionNum++;
        answNum++;
    });

    $('body').on('click', '.test .test-final', function (e) {
        e.preventDefault();
        var formData = $('.custom-control-input:checked'), arrFormData = [];

        formData.each(function (ind, elem) {
            arrFormData.push({'name': $(elem).attr('id'), 'value': $(elem).val()});
        });
        arrFormData.push({'name':'time', 'value' :$('#time_start').val()});
        console.log(arrFormData);
        $.ajax({
            type: "POST",
            url: "../ajax/test_control.php",
            cache: false,
            data: arrFormData,
            success: function (data) {
                $('#main').html(data);
            }
        });
    });
});