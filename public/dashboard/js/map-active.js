if (document.getElementById("map3")) {
  const position = [37.5004851, -96.2261503];
  const seg = {
    type: "FeatureCollection",
    features: [
      {
        type: "Feature",
        properties: {},
        geometry: {
          type: "Polygon",
          coordinates: [
            [
              [-96.240234375, 37.413294556125904],
              [-96.328125, 37.54457732085582],
              [-96.177978515625, 37.60332776490421],
              [-96.019287109375, 37.52099934331486],
              [-96.240234375, 37.413294556125904],
            ],
          ],
        },
      },
    ],
  };
  const ecomp = {
    type: "FeatureCollection",
    features: [
      {
        type: "Feature",
        properties: {
          Name: "ECOMP",
        },
        geometry: {
          type: "Point",
          coordinates: [-96.2261503, 37.5004851],
        },
      },
    ],
  };

  // Initialize the map
  const map = L.map("map3").setView(position, 4);

  // Add the tile layer
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
      '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
  }).addTo(map);

  // Add the GeoJSON layers
  L.geoJSON(seg, {
    style: {
      weight: 1,
    },
  }).addTo(map);
  L.geoJSON(ecomp, {
    pointToLayer: function (feature, latlng) {
      return L.marker(latlng, {
        icon: L.divIcon({
          html: feature.properties.Name,
          className: "icon",
        }),
      });
    },
  }).addTo(map);
}
