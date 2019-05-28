/**
 * Created by Mitchell on 28-5-2019.
 */
function triggerLevelUp(icon, name, level) {
    var html = "" +
        "<img src='" + icon + "'/>" +
        "<br>" +
        "<p>Your <b>"+ name +"</b> level is now <b>"+ level +"</b>!</p>";
    $("#popup-content").html(html);
    $('#popup').modal('show');
}