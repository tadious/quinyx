function LoadMapProperty() {
    var locations = new Array(
        [-33.95056,18.50753],
        [-33.95058,18.50893],
        [-33.95029,18.50652],
        [-33.95018,18.50513],
        [-33.95025,18.50410],
        [-33.95076,18.50213],
        [-33.95053,18.50204],
        [-33.95137,18.50019],
        [-33.95251,18.49821],
        [-33.95310,18.49632],
        [-33.95308,18.49532],
        [-33.95206,18.49368],
        [-33.95078,18.49189],
        [-33.94908,18.48963],
        [-33.94752,18.48717],
        [-33.94638,18.48617],
        [-33.94496,18.48505],
        [-33.94243,18.48491]
    );
    var markers = new Array();
    var mapOptions = {
        center: new google.maps.LatLng(-33.95056, 18.50753),
        zoom: 16,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false
    };

    var map = new google.maps.Map(document.getElementById('map'), mapOptions);

    $.each(locations, function(index, location) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(location[0], location[1]),
            map: map,
            icon: 'http://html.realia.byaviators.com/assets/img/marker-transparent.png'
        });

        var myOptions = {
            content: '<div class="infobox"><div class="image"><img src="http://html.realia.byaviators.com/assets/img/tmp/property-tiny-1.png" alt=""></div><div class="title"><a href="detail.html">1041 Fife Ave</a></div><div class="area"><span class="key">Area:</span><span class="value">200m<sup>2</sup></span></div><div class="price">€450 000.00</div><div class="link"><a href="detail.html">View more</a></div></div>',
            disableAutoPan: false,
            maxWidth: 0,
            pixelOffset: new google.maps.Size(-146, -190),
            zIndex: null,
            closeBoxURL: "",
            infoBoxClearance: new google.maps.Size(1, 1),
            position: new google.maps.LatLng(location[0], location[1]),
            isHidden: false,
            pane: "floatPane",
            enableEventPropagation: false
        };
        marker.infobox = new InfoBox(myOptions);
        marker.infobox.isOpen = false;

        var myOptions = {
            draggable: true,
            content: '<div class="marker"><div class="marker-inner">xsxs</div></div>',
            disableAutoPan: true,
            pixelOffset: new google.maps.Size(-21, -58),
            position: new google.maps.LatLng(location[0], location[1]),
            closeBoxURL: "",
            isHidden: false,
            // pane: "mapPane",
            enableEventPropagation: true
        };
        marker.marker = new InfoBox(myOptions);
        marker.marker.open(map, marker);
        markers.push(marker);

        google.maps.event.addListener(marker, "click", function (e) {
            var curMarker = this;

            $.each(markers, function (index, marker) {
                // if marker is not the clicked marker, close the marker
                if (marker !== curMarker) {
                    marker.infobox.close();
                    marker.infobox.isOpen = false;
                }
            });


            if(curMarker.infobox.isOpen === false) {
                curMarker.infobox.open(map, this);
                curMarker.infobox.isOpen = true;
                map.panTo(curMarker.getPosition());
            } else {
                curMarker.infobox.close();
                curMarker.infobox.isOpen = false;
            }

        });
    });
}


LoadMapProperty();