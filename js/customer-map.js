
async function initialize(){
    var mapOptions, map, marker, searchBox, city
    var infoWindow = '';
    var addressEl = document.querySelector( '#map-search' );
    var latEl = document.querySelector( '#latitude' );
    var longEl = document.querySelector( '#longitude' );
    var element = document.getElementById( 'map-canvas' );
    var updateLocation = document.getElementById( 'update-current-location' );
    var userLocation;
    var debugInfo = document.createElement('div');
    var nodeElement = document.createTextNode('info');

    //configs 
    var followMeOption = true;

    debugInfo.appendChild(nodeElement);
    document.querySelector('.debugInfo').appendChild(debugInfo);

    const {spherical} = await google.maps.importLibrary("geometry")

    mapOptions = {
        // How far the maps zooms in.
        zoom: 18,
        // Current Lat and Long position of the pin/
        // center: new google.maps.LatLng(43.12594948882426, -89.40703074062499),
        center : {
            lat: 41.9600164,
            lng: -87.9471244
            
        },
        disableDefaultUI: false, // Disables the controls like zoom control on the map if set to true
        scrollWheel: true, // If set to false disables the scrolling on the map.
        draggable: true, // If set to false , you cannot move the map around.
    };

    const setMarker = (e) => {
        console.log('clicked')
        if(e.preventDefault){
            e.preventDefault();
        }
        if(navigator.geolocation){
            // alert(navigator.geolocation.getCurrentPosition)
            // Call getCurrentPosition with success and failure callbacks
            navigator.geolocation.getCurrentPosition( 
                (position) => {
                    document.getElementById('longitude').value = position.coords.longitude;
                    document.getElementById('latitude').value = position.coords.latitude;

                    var myLatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    console.log(myLatlng)
                    marker.setPosition( myLatlng )
                    markerPos.setMap(map)
                    map.setCenter( myLatlng )
                }, 
                (error) => {
                    alert(`ERROR(${error.code}): ${error.message}`);
                    // Could not obtain location
                } 
            );
        }
        else{
            alert("Sorry, your browser does not support geolocation services.");
        }
    }

    const createCenterControl = (map) => {
        const controlButton = document.createElement("button");
        
        // Set CSS for the control.
        // controlButton.classList.add('btn');
        // controlButton.classList.add('btn-success');
        controlButton.classList.add('btn-pin');
    
    
        // controlButton.style.backgroundColor = "#fff";
        // controlButton.style.border = "2px solid #fff";
        // controlButton.style.borderRadius = "3px";
        // controlButton.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
        // controlButton.style.color = "rgb(25,25,25)";
        // controlButton.style.cursor = "pointer";
        // controlButton.style.fontFamily = "Roboto,Arial,sans-serif";
        // controlButton.style.fontSize = "16px";
        // controlButton.style.lineHeight = "38px";
        // controlButton.style.margin = "8px 0 22px";
        // controlButton.style.padding = "0 5px";
        // controlButton.style.textAlign = "center";
        controlButton.textContent = "Pin this location";
        controlButton.type = "button";
        // controlButton.title = "Click to recenter the map";
        // Setup the click event listeners: simply set the map to Chicago.
        controlButton.addEventListener("click", setMarker, false);
        return controlButton;
    }
    // Create an object map with the constructor function Map()
    map = new google.maps.Map( element, mapOptions ); // Till this like of code it loads up the map.
    // Create the DIV to hold the control.
    const centerControlDiv = document.createElement("div");
    // Create the control.
    const centerControl = createCenterControl(map);

    // Append the control to the DIV.
    centerControlDiv.appendChild(centerControl);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(centerControlDiv);

    window.map = map;

    var icons = {
        iconMoving: {
            anchor: new google.maps.Point(0,0),
            fillColor: 'black',
            fillOpacity: 1,
            path: "M12 7.27l4.28 10.43-3.47-1.53-.81-.36-.81.36-3.47 1.53L12 7.27M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71L12 2z",
            //   path: google.maps.SymbolPath.CIRCLE,
            //   rotation: userDirection,               // ADDED
            scale: 2,
            strokeColor: 'white',
            strokeWeight: 2,
        },
        iconStatic:{
            anchor: new google.maps.Point(0,0),
            fillColor: 'red',
            fillOpacity: 1,
            // path: "M12 7.27l4.28 10.43-3.47-1.53-.81-.36-.81.36-3.47 1.53L12 7.27M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71L12 2z",
            // path: "M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z",
              path: google.maps.SymbolPath.CIRCLE,
            //   rotation: userDirection,               // ADDED
            scale: 8,
            strokeColor: 'blue',
            strokeWeight: 4,
        }
    }
    var markerPos;
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition( (position) => {
            userLocation = {
                lat: position.coords.latitude, 
                lng: position.coords.longitude
            }
            document.getElementById('longitude').value = position.coords.longitude;
            document.getElementById('latitude').value = position.coords.latitude;

            var myLatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            markerPos = new google.maps.Marker({
                icon: icons.iconStatic,
                position: userLocation,
                title: 'You are here!',
            });
            // Mark the current location
            markerPos.setMap(map);

            markerPos.setPosition( myLatlng )
            map.setCenter( myLatlng )
            map.panTo( myLatlng );

            // markerPos = new google.maps.Marker({
            //     position: myLatlng,
            //     map: map,
            //     icon: base_url + '/images/arrowmap.png',
            //     draggable: false
            
            // })
            
            // setInterval(() => {
            //     navigator.geolocation.getCurrentPosition((position) => {
            //         var myLatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            //         markerPos.setPosition( myLatlng );
            //         map.panTo( myLatlng );
            //     })
            // }, 500)

        }, 
        (error) => {
            alert(`ERROR(${error.code}): ${error.message}`);
            // Could not obtain location
        }, {
            enableHighAccuracy: true, 
            timeout: 20000, 
            maximumAge: 0, 
            distanceFilter: 1
        } )
    }else{
        alert("Sorry, your browser does not support geolocation services.");
    }

    

    
    updateLocation.addEventListener('click', setMarker, false);

    // var city = document.querySelector( '.reg-input-city' );

    /**
     * Creates the marker on the map
     *
     */
    marker = new google.maps.Marker({
        position: mapOptions.center,
        icon: base_url + '/images/icon.png',
        map:map,
        draggable: true,
    });

    // Construct marker

    const getCurrentDirection = (previousCoordinates, currentCoordinates) => {
        // helper function
        const convertToDegrees = (radian) => {
            return (radian * 180) / Math.PI; 
        }
        if(previousCoordinates != null){
            const diffLat = currentCoordinates.lat - previousCoordinates.lat;
            const diffLng = currentCoordinates.lng - previousCoordinates.lng;
            const anticlockwiseAngleFromEast = convertToDegrees(
              Math.atan2(diffLat, diffLng)
            );
            const clockwiseAngleFromNorth = 90 - anticlockwiseAngleFromEast;
            return clockwiseAngleFromNorth;
        }else{
            return 0;
        }
        
      }
    navigator.geolocation.watchPosition(position => {
        // Record the previous user location
        const previousCoordinates = userLocation;
        // Update the user location
        userLocation = {
          lat: position.coords.latitude, 
          lng: position.coords.longitude
        };
        // Calculate the direction
        const userDirection = getCurrentDirection(   // ADDED
          previousCoordinates,                       // ADDED
          userLocation                              // ADDED
        );    
        const distance = spherical.computeDistanceBetween(previousCoordinates, userLocation);
        document.querySelector('.debugInfo').innerHTML = 'Distance: ' + distance
        if(distance > 5){
            markerPos.setPosition( userLocation )
            markerPos.icon = icons.iconMoving;
            markerPos.icon.rotation = userDirection;
            markerPos.setIcon(markerPos.icon);
        }else{
            markerPos.icon = icons.iconStatic;
            markerPos.setIcon(markerPos.icon);
        }

        if(followMeOption){
            map.setCenter( userLocation )
            map.panTo( userLocation );
        }

      }, (error) => {console.log('error'), {
        enableHighAccuracy: true, timeout: 20000, maximumAge: 0, distanceFilter: 1
      }});
    
    /**
     * Creates a search box
     */
    searchBox = new google.maps.places.SearchBox( addressEl );

    /**
     * When the place is changed on search box, it takes the marker to the searched location.
     */
    google.maps.event.addListener( searchBox, 'places_changed', function () {
        var places = searchBox.getPlaces(),
            bounds = new google.maps.LatLngBounds(),
            i, place, lat, long, resultArray,
            addresss = places[0].formatted_address;

        for( i = 0; place = places[i]; i++ ) {
            bounds.extend( place.geometry.location );
            marker.setPosition( place.geometry.location );  // Set marker position new.
        }

        map.fitBounds( bounds );  // Fit to the bound
        map.setZoom( 15 ); // This function sets the zoom to 15, meaning zooms to level 15.
        // console.log( map.getZoom() );

        lat = marker.getPosition().lat();
        long = marker.getPosition().lng();
        latEl.value = lat;
        longEl.value = long;

        resultArray =  places[0].address_components;

        // // Get the city and set the city input value to the one selected
        // for( var i = 0; i < resultArray.length; i++ ) {
        //     if ( resultArray[ i ].types[0] && 'administrative_area_level_2' === resultArray[ i ].types[0] ) {
        //         citi = resultArray[ i ].long_name;
        //         city.value = citi;
        //     }
        // }

        // Closes the previous info window if it already exists
        if ( infoWindow ) {
            infoWindow.close();
        }
        /**
         * Creates the info Window at the top of the marker
         */
        infoWindow = new google.maps.InfoWindow({
            content: addresss
        });

        infoWindow.open( map, marker );
    } );


    /**
     * Finds the new position of the marker when the marker is dragged.
     */
    google.maps.event.addListener( marker, "dragend", function ( event ) {
        var lat, long, address, resultArray, citi;

        console.log( 'i am dragged' );
        lat = marker.getPosition().lat();
        long = marker.getPosition().lng();
        console.log(lat, long);

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode( { latLng: marker.getPosition() }, function ( result, status ) {
            if ( 'OK' === status ) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
                address = result[0].formatted_address;
                resultArray =  result[0].address_components;

                // Get the city and set the city input value to the one selected
                // for( var i = 0; i < resultArray.length; i++ ) {
                //     if ( resultArray[ i ].types[0] && 'administrative_area_level_2' === resultArray[ i ].types[0] ) {
                //         citi = resultArray[ i ].long_name;
                //         console.log( citi );
                //         city.value = citi;
                //     }
                // }
                addressEl.value = address;
                latEl.value = lat;
                longEl.value = long;

            } else {
                console.log( 'Geocode was not successful for the following reason: ' + status );
            }

            // Closes the previous info window if it already exists
            if ( infoWindow ) {
                infoWindow.close();
            }

            /**
             * Creates the info Window at the top of the marker
             */
            infoWindow = new google.maps.InfoWindow({
                content: address
            });

            infoWindow.open( map, marker );
        } );
    });

    // initGeolocation();
}