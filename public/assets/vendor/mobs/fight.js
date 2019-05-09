$(document).ready(function () {

    var i;

    $.ajaxSetup({
        beforeSend: function (xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        }
    });

    function updateInfo() {
        $.ajax({
            method: 'POST', // Type of response and matches what we said in the route
            url: redirect + '/updatefight', // This is the url we gave in the route
            success: function (response) { // What to do if we succeed
                console.log(response);
                //check if we still have to update
                if (response['end'] == 1) {
                    clearInterval(i);
                    return;
                }
                //update hp-text
                $(".hp-text").empty();
                $(".hp-text").append("HP: "+response['hp']+"/"+response['maxhp']);
                //update hp-text
                $(".xp-text").empty();
                $(".xp-text").append("XP gained: " +response['xp']);
                //update hp bar
                $('.hp-bar').attr('max', response['maxhp']);
                $('.hp-bar').attr('value', response['hp']);
                //update kills
                $(".kills-text").empty();
                $(".kills-text").append("Kills: " +response['kills']);
            },
            error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }

    var wait = setInterval(function() {
         i = setInterval(function () {
            updateInfo();
        }, ((+delay) * 1000));
        clearInterval(wait);
    }, 1000);

});