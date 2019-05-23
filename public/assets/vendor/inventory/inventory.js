var origin;
var dest;
var lastDest;
$(document).ready(function () {

    var item = $(".item");
    var equipitem = $(".equip_item");

    setupTooltips();
    setupItems();

    function setupTooltips() {
        item = $(".item");
        equipitem = $(".equip_item");
        item.tlp({track: true, show: false, hide: false});
        equipitem.tlp({track: true, show: false, hide: false});
    }

    $.ajaxSetup({
        beforeSend: function (xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        }
    });
    function setupItems() {
        item = $(".item");
        equipitem = $(".equip_item");
        item.draggable({
            start: function (event, ui) {
                origin = event.target.closest('.inv_slot').id;
                $(this).addClass('dragging');
                console.log(origin);
            },
            scroll: true,
            revert: function (isValidEl) {
                if (isValidEl)
                    return false;

                return true;

            },
            helper: "clone",
            cursor: "pointer",
            stack: false,
            zIndex: 27
        });
        $(".inv_slot").droppable({
            accept: ".item",
            drop: function (event, ui) {
                var item = $(this).find(".item");
                $(this).removeClass('dragging');
                if (item.length == 0) /// See if there any items already in the currently selected inventory slot  //
                {
                    console.log("Inserting");
                    ui.draggable.detach().appendTo($(this)); // if none, insert the item into athe free slot ///
                } else {
                    console.log("swapping");
                    var move = $(this).children().detach();
                    $(ui.draggable).parent().append(move);
                    ui.draggable.detach().appendTo($(this));
                }
                dest = this.id;
                lastDest = this.id;
                $.ajax({
                    method: 'POST', // Type of response and matches what we said in the route
                    url: redirect + '/swapslot', // This is the url we gave in the route
                    data: {
                        'og': origin,
                        'new': dest
                    }, // a JSON object to send back
                    success: function (response) { // What to do if we succeed
                        getOptionsInfo();
                    },
                    error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                        console.log(JSON.stringify(jqXHR));
                        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    }
                });
            }
        });
        item.click(function (event) {
            lastDest = event.target.closest('.inv_slot').id;
            getOptionsInfo();
        });
    }

    //unequipping
    $(document).on('click', '.equip_item', function (e) {
        sendUnequip($(this).parent().attr('id').substring(1));
    });

    function clearOptionsInfo() {
        var info = $(".item-info");
        $(".option").remove();
        info.remove();
    }

    function getOptionsInfo() {
        $.ajax({
            method: 'POST', // Type of response and matches what we said in the route
            url: redirect + '/getiteminfo', // This is the url we gave in the route
            data: {
                'slot': lastDest
            }, // a JSON object to send back
            success: function (response) { // What to do if we succeed
                var infos = $(".item-infos");
                var info = $(".item-info");
                //show item options
                $(".option").remove();
                for (var i = 0; i < response['options'].length; i++) {
                    var tag = response['options'][i][0];
                    $(".options").append("<p class='option'><button>" + tag + "</button></p>");
                }
                var option = $('.option');
                option.click(function () {
                    send($(this).text());
                });
                //show item icon, name, desc
                info.remove();
                infos.append("<img class='item-info' src='" + response['infos'][0] + "'/>");
                infos.append("<p class='item-info'><b>" + response['infos'][1] + response['amount'] + "</b></p>");
                infos.append("<p class='item-info'>" + response['infos'][2] + "</p>");

                //show item stats
                if (response['stats'].length != 0) {
                    infos.append("<i class='item-info'>Melee: " + response['stats'][0] + " </i>");
                    infos.append("<i class='item-info'>Melee defence: " + response['stats'][1] + "<br></i>");
                    infos.append("<i class='item-info'>Ranged: " + response['stats'][2] + " </i>");
                    infos.append("<i class='item-info'>Ranged defence: " + response['stats'][3] + "<br></i>");
                    infos.append("<i class='item-info'>Magic: " + response['stats'][4] + " </i>");
                    infos.append("<i class='item-info'>Magic defence: " + response['stats'][5] + "<br></i>");
                }

                //show heal amount for food
                if (response['heal'] != -1) {
                    infos.append("<i class='item-info'>Heals " + response['heal'] + " HP </i>");
                }

            },
            error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }

    function addClientSidedItem(response) {
        var slotElement = $('#' + response['slot']);

        if (slotElement.find(".item").length > 0)
            return;

        slotElement.append('<div class="item item ui-draggable ui-draggable-handle" title=' + "" + response['itemName'] + '> <img src=' + "" + response['itemIcon'] + '/> </div>');
        setupTooltips();
        setupItems();
    }

    function addClientSidedEquip(response) {
        var slotElement = $('#e' + response['slot']);

        if (slotElement.find(".equip_item").length > 0)
            slotElement.empty();

        slotElement.append('<div class="equip_item" title="' + response['equipName'] + '"><img src=' + response['equipIcon'] + '/></div>');
        if (response['swapName'] != "") {
            var swapResponse = {};
            swapResponse['slot'] = response['swapSlot'];
            swapResponse['itemName'] = response['swapName'];
            swapResponse['itemIcon'] = response['swapIcon'];
            addClientSidedItem(swapResponse);
        }
        setupTooltips();
        setupItems();
    }

    function sendUnequip(clicked) {
        $.ajax({
            method: 'POST', // Type of response and matches what we said in the route
            url: redirect + '/unequip', // This is the url we gave in the route
            data: {
                'slot': clicked
            }, // a JSON object to send back
            success: function (response) { // What to do if we succeed
                console.log('clicked:' + clicked);
                console.log(response);
                if (response['status'] == true) {
                    $('#e' + clicked).empty();
                    addClientSidedItem(response);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }

    function destroyClientSidedItem(response) {
        var slotElement = $('#' + response['slot']);

        if (slotElement.find(".item").length > 0)
            slotElement.empty();
    }

    function sendUse(clicked) {
        $.ajax({
            method: 'POST', // Type of response and matches what we said in the route
            url: redirect + '/useitem', // This is the url we gave in the route
            data: {
                'slot': clicked
            }, // a JSON object to send back
            success: function (response) { // What to do if we succeed
                console.log('clicked:' + clicked);
                console.log(response);
                if (response['status'] == "equip") {
                    $('#' + clicked).empty();
                    addClientSidedEquip(response);
                    clearOptionsInfo();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }

    function sendDestroy(clicked) {
        var itemname = $('#'+clicked).find('.item').attr('title');
        itemname = itemname.trim();
        var c = confirm("Do you really want to destroy your "+itemname+' ?');
        if (c == false)
            return;

        $.ajax({
            method: 'POST', // Type of response and matches what we said in the route
            url: redirect + '/destroyitem', // This is the url we gave in the route
            data: {
                'slot': clicked
            }, // a JSON object to send back
            success: function (response) { // What to do if we succeed
                if (response['status'] == true) {
                    destroyClientSidedItem(response);
                    clearOptionsInfo();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }

    function send(text) {
        switch(text) {
            case "Use":
            case "Equip":
                sendUse(lastDest);
                break;
            case "Destroy":
                sendDestroy(lastDest);
                break;
        }
    }
});