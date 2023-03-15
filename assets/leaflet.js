
const mapDisplay = document.getElementById("map") ?? null

console.log(mapDisplay)

if (mapDisplay) {
    const latitude = document.getElementById('map').dataset.latitude
    const longitude = document.getElementById('map').dataset.longitude

    console.log(latitude, longitude)

    // replace "toner" here with "terrain" or "watercolor"
    const layer = new L.StamenTileLayer("terrain");
    const map = new L.Map("map", {
        center: new L.LatLng(latitude, longitude),
        zoom: 14
    });
    map.addLayer(layer);

    var marker = L.marker([latitude, longitude]).addTo(map);
}

