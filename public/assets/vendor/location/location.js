/**
 * Created by Mitchell on 22-5-2019.
 */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    var clickedId;
    var clickedButton;
    var useButtons = $('.usespot');
    useButtons.click(function () {
        clickedId = $(this).parent().find('p').text();
        sendRequest();
        clickedButton = $(this);
    });

    function disableButtons() {
        useButtons.html('()');
        useButtons.attr('disabled', true);
        useButtons.attr('style', 'color:#676a6d')
    }

    function enableButtons() {
        useButtons.html('Use');
        useButtons.removeAttr('disabled')
        useButtons.attr('style', 'color:#23527c')
    }

    function setTimer(time) {
        useButtons.html('('+time+'s)');
        time--;
        updateTimer(time)
    }

    function updateTimer(time) {
        var i = setInterval(function() {
            if (time <= 0) {
                enableButtons();
                clearInterval(i);
                return;
            }
            useButtons.html('('+time+'s)');
            time--;
        }, 1000);
    }

    function sendRequest() {
        $.ajax({
            method: 'POST', // Type of response and matches what we said in the route
            url: redirect + '/useskillspot', // This is the url we gave in the route
            data: {
                'id': clickedId
            }, // a JSON object to send back
            success: function(response) { // What to do if we succeed
                console.log(response);
                if (response['status'] == true) { //we gathered items
                    disableButtons();
                    animateItem(clickedButton);
                    setTimer(response['cooldown']);
                } else { //something went wrong
                    //
                }
                $('#skillstatus').html('> '+response['statustext']);
            },
            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }

    function animateItem(clicked) {
        item = clicked.parent().next().find('.animitem');
        console.log(item);
        item.css('opacity', 1);
        item.animate({
                left: '+=10'
            },
            {duration: 500, easing:'linear'});
        item.animate({
                opacity:0
            },
            {duration: 750, easing:'linear', complete :
                function() {
                    item.removeAttr('style');
                    item.css('position','absolute');
                    item.css('opacity','0');
                }
            });
    }

});