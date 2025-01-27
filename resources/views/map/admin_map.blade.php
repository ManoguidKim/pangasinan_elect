<x-app-layout>
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Map</a>
                </div>
            </li>
        </ol>
    </nav>

    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Map of Launion</h3>
    <div class="p-4 mb-3 rounded-lg bg-green-50 dark:bg-gray-800 border border-dashed">
        <p class="text-sm text-gray-500 dark:text-gray-400">This interactive map showcases the locations of all municipalities, marked for easy identification. Clicking on a marker reveals comprehensive data about the selected municipality, including the total number of voters, the percentage of allies, opponents, and undecided individuals.</p>
    </div>

    <div id="map" style="height: 700px; width: 100%;"></div>

    <script>
        let map;
        let geocoder;

        function initMap() {

            // Define a custom map style to remove POIs and establishments
            const customMapStyle = [{
                    "featureType": "poi",
                    "stylers": [{
                        "visibility": "off"
                    }]
                },
                {
                    "featureType": "poi.business",
                    "stylers": [{
                        "visibility": "off"
                    }]
                },
                {
                    "featureType": "transit",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }
            ];

            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(16.50000000, 120.41667000);
            var mapOptions = {
                zoom: 12,
                center: latlng,
                scrollwheel: false,
                disableDoubleClickZoom: true,
                styles: customMapStyle
            }
            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            fetch('/api/municipalities')
                .then((response) => response.json())
                .then((munNames) => {
                    for (let i = 0; i < munNames.length; i++) {
                        goecodeMuncipalities(munNames[i]);
                    }
                })
                .catch((error) => console.error('Error fetching barangay data:', error));
        }

        function goecodeMuncipalities(props) {
            geocoder.geocode({
                address: props.municipality_name + ", La Union, Philippines"
            }, function(results, status) {

                if (status == "OK") {
                    let markerColor, markerSize;

                    if (props.opponent_percentage > (props.total_voters * 0.15)) {
                        markerColor = "red-dot.png";
                        markerSize = new google.maps.Size(50, 50);
                    } else {
                        markerColor = "blue-dot.png";
                        markerSize = new google.maps.Size(50, 50);
                    }

                    // Create the marker
                    const marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        title: props.municipality_name,
                        icon: {
                            url: `http://maps.google.com/mapfiles/ms/icons/${markerColor}`,
                            scaledSize: markerSize,
                        },
                    });


                    // Info window content
                    const infoWindow = new google.maps.InfoWindow({
                        content: `<h1>${props.municipality_name}</h1> <br>
                        <strong>Total Voters: ${props.total_voters}</strong>
                        <br><br>
                        <strong>Ally Percentage: ${props.ally_percentage}</strong><br>
                        <strong>Opponent Percentage: ${props.opponent_percentage}</strong><br>
                        <strong>Undecided Percentage: ${props.undecided_percentage}</strong><br><br>
                        <button >Click to view details</button>

                        `,
                    });

                    // Open info window on marker click
                    marker.addListener('click', () => {
                        infoWindow.open(map, marker);
                    });

                } else {
                    console.error("Geocode failed for: " + props.name + " - " + status);
                }
            });
        }
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFE6caWkrxV7vxmJODYJxjOX4xZg4AqYo&callback=initMap">
    </script>

</x-app-layout>