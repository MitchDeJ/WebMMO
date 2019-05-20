/**
 * Created by Mitchell on 19-5-2019.
 */
$(document).ready(function () {
    var item = {};
    var price = {};
    var owned = {};
    var slot = $(".shop_slot");
    var total = $('input[name=pricetotal]');
    var amount = $('input[name=amount]');
    var hidden = $('input[name=shopitemid]');
    var sell_slot = $(".shop_sell_slot");
    var sellTotal = $('input[name=sellpricetotal]');
    var sellAmount = $('input[name=sellamount]');
    var sellHidden = $('input[name=shopsellitemid]');
    var currentPrice = 0;
    var currentSellPrice = 0;

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

    sell_slot.tlp({
        track: true,
        show: false,
        hide: false,
        content: function () {
            item[$(this)] = $(this).attr('title');
            price[$(this)] = $(this).find('p').text();
            owned[$(this)] = $(this).find('i').text();
            return "Sell '" + item[$(this)] + "'";
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

    //selling
    sell_slot.click(function(){
        var menu = $("#sell_menu");
        var details = $("#sell_details");
        details.html('Selling: <b>' +  item[$(this)] + ' (You have '+owned[$(this)]+')</b>');
        menu.removeAttr('hidden');
        currentSellPrice = price[$(this)];
        sellAmount.attr('max', owned[$(this)]).attr('value', owned[$(this)]);
        updateSellPrice(sellAmount.val());
        sellHidden.attr('value', ($(this).attr('id')));
    });

    sellAmount.on('change keyup', function() {
        updateSellPrice(sellAmount.val());
    });

    function updateSellPrice(a) {
        sellTotal.attr('value', (a * +currentSellPrice) + 'gp');
    }
});