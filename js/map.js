var map = L.map('map', {
    center: [55.953127602821546, -3.1895459039947034],
    zoom: 30,
    touchZoom: true,
}).setView([55.95347674438965, -3.1880017404810554], 11);
var OpenStreetMap_Mapnik = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
}).addTo(map);

function addMarker(name, phone, email, lat, lng) {
    var p = L.marker([lat, lng]);
    p.title = name;
    p.alt = name;
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
    p.bindPopup(popupContent);
    p.addTo(map);
}

$(document).ready(function() {
    var points = [
        ["Bonnyrigg Venue", "+44 131 660 6906", "74 Lothian St", 55.87785649335798, -3.101221996976643],
        ["Balerno Venue", "+44 131 259 5760", "36 Main St", 55.883660996544066, -3.338686081426858],
        ["Leith Venue", "+44 7445 890884", "60 Great Jct St", 55.97173935506401, -3.1735335133048777],
        ["Corstorphine Venue", "+44 345 677 9193", "30 Meadow Pl Rd", 55.940421710187216, -3.2943882608885406]
    ];
    for (var i = 0; i < points.length; i++) {
        addMarker(points[i][0], points[i][1], points[i][2], points[i][3], points[i][4]);
    }
});

L.control.scale({ maxWidth: 240, metric: true, position: 'bottomleft' }).addTo(map);
L.control.polylineMeasure({
    position: 'topleft',
    imperial: false,
    clearMeasurementsOnStop: false,
    showMeasurementsClearControl: true
}).addTo(map);