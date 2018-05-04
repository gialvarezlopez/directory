( function($) {
  'use strict';
$(function(e) {	


/*-------------------------------------------------------------------------------
		Googl-Map
	-------------------------------------------------------------------------------*/

    function GooglMap() {
        var ib = new InfoBox();

        function locationData(locationURL, locationImg, locationTitle, locationAddress, locationRating, locationRatingCounter) {
            return ('' + '<a href="' + locationURL + '" class="map-post-thumb-m">' + '<div class="map-popup-close"><i class="fa fa-times"></i></div>' + '<img src="' + locationImg + '" alt="">' + '</a>' + '<div class="map-post-des-m">'+ '<h5>' + '<a href="' + locationURL + '">' + locationTitle + '</a>' + '</h5>' + '<span><i class="fa fa-map-marker"></i> ' + locationAddress + '</span>' + '</div>' + '<div class="listing-content">' + '</div>')
        }
        var locations = [
            [locationData('listing-detail-1.html', 'assets/images/600x450.jpg', "The Morning Hotel", '3112 NW Cache Rd, Lawton, OK 73505, USA', '3.5', '12'), 40.94401669296697, -74.16938781738281, 1, '<i class="im-icon"><img src="assets/images/category-icon5.png"></i>'],
			
            [locationData('listing-detail-1.html', 'assets/images/600x450.jpg', 'Laisa Spa Center', '41 Sunset Blvd, Lawton, OK 73505, USA', '5.0', '23'), 40.77055783505125, -74.26002502441406, 2, '<i class="im-icon"><img src="assets/images/category-icon4.png"></i>'],
			
            [locationData('listing-detail-1.html', 'assets/images/600x450.jpg', 'Blue Women Parlour', '778 Sunset Blvd, Lawton, OK 73505, USA', '2.0', '17'), 40.7427837, -73.11445617675781, 3, '<i class="im-icon"><img src="assets/images/category-icon4.png"></i>'],
			
            [locationData('listing-detail-1.html', 'assets/images/600x450.jpg', 'Auto Repair Shop', '2726 Shinn Street, New York', '5.0', '31'), 40.70437865245596, -73.98674011230469, 4, '<i class="im-icon"><img src="assets/images/category-icon6.png"></i>'],
			
            [locationData('listing-detail-1.html', 'assets/images/600x450.jpg', 'Eating Restaurant', '1512 Duncan Avenue, New York', '3.5', '46'), 40.641311, -73.778139, 5, '<i class="im-icon"><img src="assets/images/category-icon2.png"></i>'],
			
            [locationData('listing-detail-1.html', 'assets/images/600x450.jpg', 'The Shelby Apartment', '215 Terry Lane, New York', '4.5', '15'), 41.080938, -73.535957, 6, '<i class="im-icon"><img src="assets/images/category-icon1.png"></i>'],
			
            [locationData('listing-detail-1.html', 'assets/images/600x450.jpg', 'Fitness Center', '2726 Shinn Street, New York', '5.0', '31'), 41.079386, -73.519478, 7, '<i class="im-icon"><img src="assets/images/category-icon3.png"></i>'],
        ];
		
        var mapZoomAttr = $('#map').attr('data-map-zoom');
        if (typeof mapZoomAttr !== typeof undefined && mapZoomAttr !== false) {
            var zoomLevel = parseInt(mapZoomAttr);
        } else {
            var zoomLevel = 9;
        }
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: zoomLevel,
            scrollwheel: true,
			disableDefaultUI: true,
            center: new google.maps.LatLng(40.80, -73.70),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoomControl: false,
            mapTypeControl: false,
            scaleControl: false,
            panControl: false,
            navigationControl: false,
            streetViewControl: false,
        });
        $('.items-list').on('mouseover', function() {
            var listingAttr = $(this).data('post-id');
            if (listingAttr !== undefined) {
                var listing_id = $(this).data('post-id') - 1;
                var marker_div = allMarkers[listing_id].div;
                $(marker_div).addClass('clicked');
                $(this).on('mouseout', function() {
                    if ($(marker_div).is(":not(.infoBox-opened)")) {
                        $(marker_div).removeClass('clicked');
                    }
                });
            }
        });
        var boxText = document.createElement("div");
        boxText.className = 'map-box'
        var currentInfobox;
        var boxOptions = {
            content: boxText,
            disableAutoPan: false,
            alignBottom: true,
            maxWidth: 0,
            pixelOffset: new google.maps.Size(-134, -55),
            zIndex: null,
            boxStyle: {
                width: "290px"
            },
            closeBoxMargin: "0",
            closeBoxURL: "",
            infoBoxClearance: new google.maps.Size(25, 25),
            isHidden: false,
            pane: "floatPane",
            enableEventPropagation: false,
        };
        var markerCluster, overlay, i;
        var allMarkers = [];
        var clusterStyles = [{
            textColor: 'white',
            url: '',
            height: 50,
            width: 50
        }];
        var markerIco;
        for (i = 0; i < locations.length; i++) {
            markerIco = locations[i][4];
            var overlaypositions = new google.maps.LatLng(locations[i][1], locations[i][2]),
                overlay = new CustomMarker(overlaypositions, map, {
                    marker_id: i
                }, markerIco);
            allMarkers.push(overlay);
            google.maps.event.addDomListener(overlay, 'click', (function(overlay, i) {
                return function() {
                    ib.setOptions(boxOptions);
                    boxText.innerHTML = locations[i][0];
                    ib.open(map, overlay);
                    currentInfobox = locations[i][3];
                    google.maps.event.addListener(ib, 'domready', function() {
                        $('.map-popup-close').click(function(e) {
                            e.preventDefault();
                            ib.close();
                            $('.map-marker-container').removeClass('clicked infoBox-opened');
                        });
                    });
                }
            })(overlay, i));
        }
        var options = {
            imagePath: 'images/',
            styles: clusterStyles,
            minClusterSize: 2
        };
        markerCluster = new MarkerClusterer(map, allMarkers, options);
        google.maps.event.addDomListener(window, "resize", function() {
            var center = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(center);
        });
        var zoomControlDiv = document.createElement('div');
        var zoomControl = new ZoomControl(zoomControlDiv, map);

        function ZoomControl(controlDiv, map) {
            zoomControlDiv.index = 1;
            map.controls[google.maps.ControlPosition.RIGHT_TOP].push(zoomControlDiv);
            controlDiv.className = "leaflet-control-zoom";
            var controlWrapper = document.createElement('div');
            controlDiv.appendChild(controlWrapper);
            var zoomInButton = document.createElement('div');
            zoomInButton.className = "custom-zoom-in";
            controlWrapper.appendChild(zoomInButton);
            var zoomOutButton = document.createElement('div');
            zoomOutButton.className = "custom-zoom-out";
            controlWrapper.appendChild(zoomOutButton);
            google.maps.event.addDomListener(zoomInButton, 'click', function() {
                map.setZoom(map.getZoom() + 1);
            });
            google.maps.event.addDomListener(zoomOutButton, 'click', function() {
                map.setZoom(map.getZoom() - 1);
            });
        }
        $("#geoLocation, .input-with-icon.location a").click(function(e) {
            e.preventDefault();
            geolocate();
        });

        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    map.setCenter(pos);
                    map.setZoom(12);
                });
            }
        }
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            map.setOptions({
                draggable: false
            });
        }
    }
	
	
	
    var map = document.getElementById('map');
    if (typeof(map) != 'undefined' && map != null) {
        google.maps.event.addDomListener(window, 'load', GooglMap);
        google.maps.event.addDomListener(window, 'resize', GooglMap);
    }

    function singlemap() {
        var myLatlng = new google.maps.LatLng({
            lng: $('#singlemap').data('longitude'),
            lat: $('#singlemap').data('latitude'),
        });
        var single_map = new google.maps.Map(document.getElementById('singlemap'), {
            zoom: 15,
            center: myLatlng,
            scrollwheel: false,
            zoomControl: false,
            mapTypeControl: false,
            scaleControl: false,
			fullscreenControl: false,
            panControl: false,
            navigationControl: false,
            streetViewControl: false,
        });
        var zoomControlDiv = document.createElement('div');
        var zoomControl = new ZoomControl(zoomControlDiv, single_map);

        function ZoomControl(controlDiv, single_map) {
            zoomControlDiv.index = 1;
            single_map.controls[google.maps.ControlPosition.RIGHT_TOP].push(zoomControlDiv);
            var controlWrapper = document.createElement('div');
            controlDiv.appendChild(controlWrapper);
            var zoomInButton = document.createElement('div');
            zoomInButton.className = "custom-zoom-in";
            controlWrapper.appendChild(zoomInButton);
            var zoomOutButton = document.createElement('div');
            zoomOutButton.className = "custom-zoom-out";
            controlWrapper.appendChild(zoomOutButton);
            google.maps.event.addDomListener(zoomInButton, 'click', function() {
                single_map.setZoom(single_map.getZoom() + 1);
            });
            google.maps.event.addDomListener(zoomOutButton, 'click', function() {
                single_map.setZoom(single_map.getZoom() - 1);
            });
        }
        var singleMapIco = "<i class='im-icon'><img src='" + $('#singlemap').data('map-icon') + "'></i>";
        new CustomMarker(myLatlng, single_map, {
            marker_id: '1'
        }, singleMapIco);
    }
    var single_map = document.getElementById('singlemap');
    if (typeof(single_map) != 'undefined' && single_map != null) {
        google.maps.event.addDomListener(window, 'load', singlemap);
        google.maps.event.addDomListener(window, 'resize', singlemap);
    }

    function CustomMarker(latlng, map, args, markerIco) {
        this.latlng = latlng;
        this.args = args;
        this.markerIco = markerIco;
        this.setMap(map);
    }
    CustomMarker.prototype = new google.maps.OverlayView();
    CustomMarker.prototype.draw = function() {
        var self = this;
        var div = this.div;
        if (!div) {
            div = this.div = document.createElement('div');
            div.className = 'map-marker-container';
            div.innerHTML = '<div class="marker-container">' + '<div class="marker-card">' + '<div class="front face">' + self.markerIco + '</div>' + self.markerIco + '</div>'  + '</div>' + '</div>'
            google.maps.event.addDomListener(div, "click", function(event) {
                $('.map-marker-container').removeClass('clicked infoBox-opened');
                google.maps.event.trigger(self, "click");
                $(this).addClass('clicked infoBox-opened');
            });
            if (typeof(self.args.marker_id) !== 'undefined') {
                div.dataset.marker_id = self.args.marker_id;
            }
            var panes = this.getPanes();
            panes.overlayImage.appendChild(div);
        }
        var point = this.getProjection().fromLatLngToDivPixel(this.latlng);
        if (point) {
            div.style.left = (point.x) + 'px';
            div.style.top = (point.y) + 'px';
        }
    };
    CustomMarker.prototype.remove = function() {
        if (this.div) {
            this.div.parentNode.removeChild(this.div);
            this.div = null;
            $(this).removeClass('clicked');
        }
    };
    CustomMarker.prototype.getPosition = function() {
        return this.latlng;
    };


	

});	
})(this.jQuery);
