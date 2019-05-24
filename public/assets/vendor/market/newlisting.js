/**
 * Created by Mitchell on 25-5-2019.
 */
$(document).ready(function () {
    counts = JSON.parse(counts);
   var itemselect = $("#itemselect");

   var amount = $("#amount");
    itemselect.on('change', function() {
        updateValues(this.value);
        updateTotal();
    });

    var price = $("#price");
    var total = $("#total");

    amount.on('change keyup', function() {
        updateTotal();
    });
    price.on('change keyup', function() {
        updateTotal();
    });

    updateValues(itemselect.val());

    function updateValues(val) {
        amount.attr('max', counts[val]);
        amount.attr('value', counts[val]);
    }

    function updateTotal() {
        total.attr('value', price.val() * amount.val() + "gp")
    }
});