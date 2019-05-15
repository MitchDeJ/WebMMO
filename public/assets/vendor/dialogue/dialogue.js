/**
 * Created by Mitchell on 13-5-2019.
 */
$(document).ready(function () {

    dialogue = JSON.parse(dialogue);
    var current = 0;

    function fixText(text) {
        text = text.replace("_NAME_", username);
        text = text.replace("_NPC_", npcname);
        text = text.replace("^", "'");
        return text;
    }


    var actorDiv = $("#dia_actor");
    var textDiv = $("#dia_text");
    var nextBut = $("#dia_button");
    actorDiv.empty();
    actorDiv.append("<b>" + fixText(dialogue[current]['actor']) + "</b>");
    textDiv.empty();
    textDiv.append(fixText(dialogue[current]['text']));
    nextBut.click(function () {
        next()
    });

    function next() {
        current++;
        if (dialogue[current] == undefined) {
            end();
            return;
        }
        actorDiv.empty();
        actorDiv.append("<b>" + fixText(dialogue[current]['actor']) + "</b>");
        textDiv.empty();
        textDiv.append(fixText(dialogue[current]['text']));
    }

    function end() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", redirect + '/enddialogue', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify({
            '_token' : $('meta[name="csrf-token"]').attr('content')
        }));
        var wait = setInterval(function() {
            window.location.replace(redirect + '/location');
            clearInterval(wait);
        }, 250);
    }
});
