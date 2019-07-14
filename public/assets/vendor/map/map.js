/**
 * Created by Mitchell on 12-5-2019.
 */

//define the map
var map = L.map('map', {
    attributionControl:false,
    crs: L.CRS.Simple,
    minZoom: 2.5
});

//decode the JSON
points = JSON.parse(points);

//setup the bounds and map image
var bounds = [[0,0], [200, 200]];
var image = L.imageOverlay(redirect + '/img/maps/webmmo.png', bounds).addTo(map);
map.maxBoundsViscosity = 1.0;
map.setMaxBounds(bounds);


map.fitBounds(bounds);

//defining different icons
var Icon = L.Icon.extend({
    options: {
        iconSize:     [40, 54],
        shadowSize:   [50, 64],
        iconAnchor:   [18, 60],
        shadowAnchor: [18, 40],
        popupAnchor:  [0, -58]
    }
});

console.log(token);

var blueIcon = new Icon({iconUrl: redirect + '/img/maps/flag_blue.png'}),
    redIcon = new Icon({iconUrl: redirect + '/img/maps/flag_red.png'});

//put the mappoints on the map
points.forEach(function(point) {
    var icon = getIcon(point['id']);
    var html = "" +
        "<form action='travel' method='POST'>" +
        token +
        "<input type='hidden' name='id' value='"+point['id']+"'> </input>" +
        "<button type='submit'>Travel</button>" +
        "</form>";

    if (point['id'] == current) {
        html = "<br>You are currently here.";
        map.panTo(L.latLng([ point['y'], point['x'] ]));
    }

    var newPoint = L.latLng([ point['y'], point['x'] ]);
    L.marker(newPoint, {icon: icon}).addTo(map).bindPopup(
        "<b>" + point['title'] + "</b>" + html
    );
});

function getIcon(id) {
    if (id == current)
        return redIcon;
    return blueIcon;
}

