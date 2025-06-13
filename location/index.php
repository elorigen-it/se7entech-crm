<head>
  <style>
    html, body, #map-canvas {
      height: 400px;
      margin: 0px;
      padding: 0px
    }
  </style>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=geometry"></script>    
  <script>
    var random_marker_locations = [
      new google.maps.LatLng(50.7, 4.1),
      new google.maps.LatLng(50.4, 4.2),
      new google.maps.LatLng(50.1, 4.3),
      new google.maps.LatLng(50.8, 4.4),
      new google.maps.LatLng(50.5, 4.5),
      new google.maps.LatLng(50.2, 4.6),
      new google.maps.LatLng(50.9, 4.7),
      new google.maps.LatLng(50.6, 4.8),
      new google.maps.LatLng(50.3, 4.9)
    ]

    var map;
    var markers = [];
    var polygon;
    var polygonMarkers = [];
    var polygonLocations = [];

    var mapOptions = {
      zoom: 8,
      center: new google.maps.LatLng(50.40, 4.34),  // Brussels, Belgium
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    function initialize() {
      map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
      // add markers
      for(var i in random_marker_locations) {
        var marker = new google.maps.Marker({position: random_marker_locations[i], map: map, title: 'marker ' + i});
        markers.push(marker);
      }

      // add a click on map event
    const iconBase =
    "https://developers.google.com/maps/documentation/javascript/examples/full/images/";
  const icons = {
    parking: {
      icon: iconBase + "parking_lot_maps.png",
    },
    library: {
      icon: iconBase + "library_maps.png",
    },
    info: {
      icon: iconBase + "info-i_maps.png",
    },
  };
  const features = [
    {
      position: new google.maps.LatLng(-33.91721, 151.2263),
      type: "info",
    },
    {
      position: new google.maps.LatLng(-33.91539, 151.2282),
      type: "info",
    },
    {
      position: new google.maps.LatLng(-33.91747, 151.22912),
      type: "info",
    },
    {
      position: new google.maps.LatLng(-33.9191, 151.22907),
      type: "info",
    },
    {
      position: new google.maps.LatLng(-33.91725, 151.23011),
      type: "info",
    },
    {
      position: new google.maps.LatLng(-33.91872, 151.23089),
      type: "info",
    },
    {
      position: new google.maps.LatLng(-33.91784, 151.23094),
      type: "info",
    },
    {
      position: new google.maps.LatLng(-33.91682, 151.23149),
      type: "info",
    },
    {
      position: new google.maps.LatLng(-33.9179, 151.23463),
      type: "info",
    },
    {
      position: new google.maps.LatLng(-33.91666, 151.23468),
      type: "info",
    },
    {
      position: new google.maps.LatLng(-33.916988, 151.23364),
      type: "info",
    },
    {
      position: new google.maps.LatLng(-33.91662347903106, 151.22879464019775),
      type: "parking",
    },
    {
      position: new google.maps.LatLng(-33.916365282092855, 151.22937399734496),
      type: "parking",
    },
    {
      position: new google.maps.LatLng(-33.91665018901448, 151.2282474695587),
      type: "parking",
    },
    {
      position: new google.maps.LatLng(-33.919543720969806, 151.23112279762267),
      type: "parking",
    },
    {
      position: new google.maps.LatLng(-33.91608037421864, 151.23288232673644),
      type: "parking",
    },
    {
      position: new google.maps.LatLng(-33.91851096391805, 151.2344058214569),
      type: "parking",
    },
    {
      position: new google.maps.LatLng(-33.91818154739766, 151.2346203981781),
      type: "parking",
    },
    {
      position: new google.maps.LatLng(-33.91727341958453, 151.23348314155578),
      type: "library",
    },
  ];

  // Create markers.
  for (let i = 0; i < features.length; i++) {
    const marker = new google.maps.Marker({
      position: features[i].position,
      icon: icons[features[i].type].icon,
      map: map,
    });
  }
}
    }

    // draws a polygon
    function drawPolygon(points) {
      if(points.length < 3) {
        return;
      }
      // first delete the previous polygon
      if(polygon) {
        polygon.setMap(null);
      }
      // @see https://developers.google.com/maps/documentation/javascript/examples/polygon-simple
      polygon = new google.maps.Polygon({
        paths: points,
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
        map: map
      });
      // display to input
      displaySelectedMarkers(polygon);
    }
    // display the selected markers to input.  
    function displaySelectedMarkers(polygon) {
      // empty the input
      document.getElementById('selected_markers').value = '';
      var a=0;  // I use this to set a comma between the values, but no comma at the end
      for(var i in random_marker_locations) {
        // @see https://developers.google.com/maps/documentation/javascript/examples/poly-containsLocation
        if (google.maps.geometry.poly.containsLocation(random_marker_locations[i], polygon)) {
          document.getElementById('selected_markers').value += (a++>0 ? ', ' : '') + i ;
        }
      }
    }

    function clearSelection() {
      if(polygon) {
        polygon.setMap(null);
      }
      for (var i in polygonMarkers) {
        polygonMarkers[i].setMap(null);
      }          
      polygonLocations = [];
      document.getElementById('selected_markers').value = '';
    }

    google.maps.event.addDomListener(window, 'load', initialize);
  </script>
</head>
<body>
  <div id="map-canvas"></div>
  <hr>
  <input id="selected_markers"><br>
  <input type="button" onclick="clearSelection()" value="Clear polygon"><br>
  Click to select a polygon selection around the markers
</body>