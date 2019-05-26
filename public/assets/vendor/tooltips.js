/**
 * Created by Mitchell on 26-5-2019.
 */
$(document).ready(function () {

    function setupTooltips() {
        item = $(".item");
        item.tlp({track: true, show: false, hide: false});
    }

    setupTooltips();
});