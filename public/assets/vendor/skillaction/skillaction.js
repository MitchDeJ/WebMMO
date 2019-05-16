/**
 * Created by mitch on 16/05/2019.
 */
$(document).ready(function () {

    //calc progress
    var secondsPassed = (Date.now() / 1000) - startTime;
    var wait = setTimeout(function () {
        $('#progressBar').find('div').html('');
        progress(+secondsPassed, +goal, $('#progressBar'));
        clearInterval(wait);
    }, 1);

    function progress(timePassed, timetotal, $element) {
        var progressBarWidth = (timePassed / goal) * $element.width();
        if (progressBarWidth >= $element.width()) {
            progressBarWidth = $element.width();
            $element.find('div').css('background-color', '#41B314');
            insertCompletetion();
        }
        $element.find('div').animate({width: progressBarWidth}, 500);
        setTimeout(function () {

            if (stop == true) {
                clearTimeout(this);
                return;
            }

            if (timePassed < timetotal) {
                progress(timePassed + (1), timetotal, $element);
            } else {
                stop = true;
            }

        }, 1000);
    }

    function insertCompletetion() {
        resultElement = $('#result');
        completeElement = $('#completion');
        results = JSON.parse(results);
        resultElement.append('' +
            '<p><b>Result</b></p> ' +
            '<p>+ ' + results['items'] + 'x <img src="'+results['product_img']+'" /></p> ' +
            '<p>+ ' + results['xp'] + ' ' + results['skill']+' XP </p> ');

        //add form with complete button
        var formHtml = "" +
            "<form action='completeaction' method='POST'>" +
            token +
            "<button type='submit'class='btn btn-success'>Complete</button>" +
            "</form>";

        completeElement.append(formHtml);
    }
});