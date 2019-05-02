var origin;
var dest;
var lastDest;
$(document).ready(function() {

    $.ajaxSetup({
        beforeSend: function(xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
	
    $(".item").draggable({
        start: function(event, ui) {
            origin = event.target.closest('div').id;
			$(this).addClass('dragging');
            console.log(origin);
        },
        scroll: true,
        revert: function(isValidEl) {
            if (isValidEl) {
                return false;
            } else {
                return true;
            }
        },
        helper: "clone",
        cursor: "pointer",
        stack: false,
        zIndex: 27,
    });
    $(".inv_slot").droppable({
        accept: ".item",
        drop: function(event, ui) {
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
                success: function(response) { // What to do if we succeed
                    console.log(response);
                    getOptionsInfo();
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }
    });
	$(".item").click(function (event) {
	    lastDest = event.target.closest('div').id;
        getOptionsInfo();
    });

	function getOptionsInfo() {
        $.ajax({
            method: 'POST', // Type of response and matches what we said in the route
            url: redirect + '/getiteminfo', // This is the url we gave in the route
            data: {
                'slot': lastDest
            }, // a JSON object to send back
            success: function(response) { // What to do if we succeed

                //show item options
                $( ".option").remove();
                for(var i = 0; i < response['options'].length; i++) {

                    $( ".options" ).append( "<p class='option'><form class='option' action='"+response['options'][i][1]+"'><input type='submit' value='"+response['options'][i][0]+"' /></form></p>" );
                }
                //show item icon, name, desc
                $( ".item-info").remove();
                $( ".item-infos" ).append( "<img class='item-info' src='"+response['infos'][0]+"'/>" );
                $( ".item-infos" ).append( "<p class='item-info'><b>"+response['infos'][1]+response['amount']+"</b></p>" );
                $( ".item-infos" ).append( "<p class='item-info'>"+response['infos'][2]+"</p>" );
                //show item stats
                if (response['stats'].length != 0) {
                    $( ".item-infos" ).append( "<i class='item-info'>Melee: "+response['stats'][0]+" </i>" );
                    $( ".item-infos" ).append( "<i class='item-info'>Melee defence: "+response['stats'][1]+"<br></i>" );
                    $( ".item-infos" ).append( "<i class='item-info'>Ranged: "+response['stats'][2]+" </i>" );
                    $( ".item-infos" ).append( "<i class='item-info'>Ranged defence: "+response['stats'][3]+"<br></i>" );
                    $( ".item-infos" ).append( "<i class='item-info'>Magic: "+response['stats'][4]+" </i>" );
                    $( ".item-infos" ).append( "<i class='item-info'>Magic defence: "+response['stats'][5]+"<br></i>" );
                }
            },
            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }
});