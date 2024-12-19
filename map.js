var map = L.map('map', {
    center: [55.95347674438965, -3.1880017404810554],
    zoom: 30,
    scrollWheelZoom: false,
    touchZoom: true,
}).setView([55.95347674438965, -3.1880017404810554], 16);
var OpenStreetMap_Mapnik = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
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
        ["Tech Solutions Inc.", "+1-234-567-8901", "info@techsolutions.com", 55.95547846311412, -3.1830842227468072],
        ["Green Thumb Landscaping", "+1-234-567-8902", "info@greenthumb.com", 55.957232291772186, -3.177462312767842],
        ["Gourmet Coffee Shop", "+1-234-567-8903", "info@gourmetcoffee.com", 55.953003747797844, -3.1726128789691934],
        ["City Fitness Center", "+1-234-567-8904", "info@cityfitness.com", 55.9509854162493, -3.1744582387332807]
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