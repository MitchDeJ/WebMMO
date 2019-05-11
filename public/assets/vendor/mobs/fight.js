$(document).ready(function () {

    var i;
    var stop;

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
                    stop = true;
                    clearInterval(i);
                    kills = response['kills'];
                    $(".kills-text").empty();
                    $(".kills-text").append("Kills: " + kills);
                    $(".hp-text").empty();
                    $(".hp-text").append("HP: "+response['hp']+"/"+response['maxhp']);
                    $(".xp-text").empty();
                    $(".xp-text").append("XP gained: " + (+kills * +xpPerKill));
                    //update hp bar
                    setHP(response['hp'], response['maxhp'], $('#hpBar'));
                    //update loot
                    $(".loot").empty();
                    response['loot'].forEach(function(loot) {
                        $(".loot").append('<img src="'+loot['icon']+'"/> x'+loot['amount']+' ')
                    });
                    return;
                }
                //update hp-text
                $(".hp-text").empty();
                $(".hp-text").append("HP: "+response['hp']+"/"+response['maxhp']);
                //update kills
                $(".kills-text").empty();
                kills++;
                $(".kills-text").append("Kills: " + kills);
                //update xp-text
                $(".xp-text").empty();
                $(".xp-text").append("XP gained: " + (+kills * +xpPerKill));
                //update hp bar
                setHP(response['hp'], response['maxhp'], $('#hpBar'));
                //update loot
                $(".loot").empty();
                response['loot'].forEach(function(loot) {
                    $(".loot").append('<img src="'+loot['icon']+'"/> x'+loot['amount']+' ')
                });
            },
            error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }

    //set hp bar default
    setHP(hp, maxhp, $('#hpBar'));
    $('#progressBar').find('div').html('Loading')

    //calc last update
    var latency = ((Date.now() / 1000) - lastUpdate);
    console.log(lastUpdate);
    console.log(latency);
    console.log(+delay-latency);
    var wait = setTimeout(function() {
        $('#progressBar').find('div').html('');
        progress(+delay-latency, +delay, $('#progressBar'));
        clearInterval(wait);
    }, 1);

    function progress(timeleft, timetotal, $element) {
        var progressBarWidth = timeleft * $element.width() / timetotal;
        if (progressBarWidth > $element.width())
            progressBarWidth = $element.width();
        $element.find('div').animate({ width: progressBarWidth }, 500);
        setTimeout(function() {

            if (stop == true) {
                clearTimeout(this);
                return;
            }

            if(timeleft > 1) {
                progress(timeleft - (1+(1.1/timetotal)), timetotal, $element);
            } else {
                onProgress();
                progress(+delay, +delay, $element);
            }

        }, 1000);
    }

    function onProgress() {
        updateInfo();
    }

    function setHP(timeleft, timetotal, $element) {
        var progressBarWidth = timeleft * $element.width() / timetotal;
        $element.find('div').animate({ width: progressBarWidth }, 500);
    }

});