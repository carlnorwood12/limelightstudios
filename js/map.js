// Referenced from here: https://codepen.io/kokod/pen/GmqKBM?editors=1010
// just a map of Edinburgh with some markers for venues
// create a map in the map div and set view to a given place and zoom level (11 is the zoom level)
var map = L.map('map', {
    touchZoom: true,
}).setView([55.95347674438965, -3.1880017404810554], 11);

// use OpenStreetMap tiles set max zoom level to 19 and add it to the map
var OpenStreetMap_Mapnik = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
}).addTo(map);

// function to add a new marker to the map
function addMarker(name, phone, email, lat, lng) {
    // create a marker with the given latitude and longitude
    var p = L.marker([lat, lng]);
    // set the text for the marker
    p.title = name;
    p.alt = name;
    // here we are creating a custom popup content for the marker
    var popupContent = `
        <div class="popup-content">
            <h2 class="popup-name">${name}</h2>
            <p class="popup-email">
               ${email}
            </p>
            <p class="popup-phone">
               ${phone}
            </p>
            <a href="https://www.google.com/maps/search/?api=1&query=${lat},${lng}" target="_blank" class="popup-address">
                Get Directions
            </a>
        </div>
    `;
    // bind the popup content to the marker and add it to the map
    p.bindPopup(popupContent);
    p.addTo(map);
}
// add markers for each venue with their respective details
$(document).ready(function() {
    var points = [
        ["Bonnyrigg Venue", "+44 131 660 6906", "74 Lothian St", 55.87785649335798, -3.101221996976643],
        ["Balerno Venue", "+44 131 259 5760", "36 Main St", 55.883660996544066, -3.338686081426858],
        ["Leith Venue", "+44 7445 890884", "60 Great Jct St", 55.97173935506401, -3.1735335133048777],
        ["Corstorphine Venue", "+44 345 677 9193", "30 Meadow Pl Rd", 55.940421710187216, -3.2943882608885406]
    ];
    // loop through each point and add a marker to the map
    for (var i = 0; i < points.length; i++) {
        addMarker(points[i][0], points[i][1], points[i][2], points[i][3], points[i][4]);
    }
});
// add a scale control to the map
L.control.scale({ maxWidth: 240, metric: true, position: 'bottomleft' }).addTo(map);
L.control.polylineMeasure({
    position: 'topleft',
    imperial: false,
    clearMeasurementsOnStop: false,
    showMeasurementsClearControl: true
}).addTo(map);