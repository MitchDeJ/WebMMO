/**
 * Created by Mitchell on 19-5-2019.
 */
$(document).ready(function () {
    var item = {};
    var price = {};
    var slot = $(".shop_slot");
    var total = $('input[name=pricetotal]');
    var amount = $('input[name=amount]');
    var hidden = $('input[name=shopitemid]');
    var currentPrice = 0;

    slot.tlp(
        {
            track: true,
            show: false,
            hide: false,
            content: function () {
                item[$(this)] = $(this).attr('title');
                price[$(this)] = $(this).find('p').text();
                return "Buy '" + item[$(this)] + "'";
            }
        });

    slot.click(function(){
        var menu = $("#buy_menu");
        var details = $("#buy_details");
        details.html('Buying: <b>' +  item[$(this)] + '</b>');
        menu.removeAttr('hidden');
        currentPrice = price[$(this)];
        updatePrice(amount.val());
        hidden.attr('value', ($(this).attr('id')));
    });

    amount.on('change keyup', function() {
        updatePrice(amount.val());
    });

    function updatePrice(a) {
        total.attr('value', (a * +currentPrice) + 'gp');
    }

    function clearPost() {
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    }
});