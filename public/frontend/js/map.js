var markersObj = [];
var map;
var visibleView;
const LOCATION_MAP = {
    latitude: window.location.host.indexOf('localhost') !== -1 ? 39.9178032 : 0,
    longitude: window.location.host.indexOf('localhost') !== -1 ? -82.7347142 : 0,
    get getLatitude() {
        return this.latitude
    },
    set setLatitude(lat) {
        this.latitude = lat;
    },
    get getLongitude() {
        return this.longitude
    },
    set setLongitude(lng) {
        this.longitude = lng;
    }
};

window.defaultIcon = '';
window.activeIcon = '';
var x_axis, y_axis;
var x_active_axis, y_active_axis;
if (lang === 'en') {
    x_axis = 28;
    y_axis = 32;
    x_active_axis = 40;
    y_active_axis = 41;
} else {
    x_axis = 22;
    y_axis = 32;
    x_active_axis = 33;
    y_active_axis = 41;
}
var geoPositionOptions = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
};

geoBtn = document.getElementById('geoBtn');
var url_detail = window.location.href?.split('/');
console.log('asdasd')
var near_me = url_detail[url_detail.length - 1];
// console.log(near_me)
if (near_me.indexOf("near-me") > -1) {
    // console.log('asdasd')

    navigator.geolocation.getCurrentPosition(geoPositionSuccess, geoPositionError, geoPositionOptions);

    if (navigator.permissions) {
        navigator.permissions.query({
            name: 'geolocation'
        }).then(function (result) {

            result.onchange = function () {
                report(result);
            }
        });
    }
}


function report(result) {

    if (result.state === 'granted' || result.state === 'prompt') {
        $('.user-location').hide();
        $('.user-location current').html('');
        navigator.geolocation.getCurrentPosition(geoPositionSuccess, geoPositionError, geoPositionOptions);
    }
    else if (result.state === 'denied') {
        $('.user-location').show();
        $('.user-location current').html('ERROR(1): User ' + result.state + ' Geolocation');
    }


    console.warn(result);
}

function getPlacesAutoComplete() {
    const map_address_options = {
        // fields: ['ALL'],
        componentRestrictions: {country: ["us", "pr", "vi", "gu", "mp"]},
        fields: ["address_components", "formatted_address", "geometry", "name"], // ['ALL'] to debug
        strictBounds: false,
        // types: ["address"], // https://developers.google.com/maps/documentation/places/web-service/supported_types
        types: ['(regions)'],
    };
    var inputs = document.getElementsByClassName('pac-input');
    var autocompletes = [];
    for (var i = 0; i < inputs.length; i++) {
        var map_autocomplete = new google.maps.places.Autocomplete(inputs[i], map_address_options);
        map_autocomplete.inputId = inputs[i].id;
        map_autocomplete.addListener('place_changed', fillIn);
        autocompletes.push(map_autocomplete);
    }

    // console.log(autocompletes);

    function fillIn() {
        var place = this.getPlace();
        var postal_code = 0;

        if (!place.geometry || !place.geometry.location) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            console.info("No details available for input: '" + place.name + "'");
            return;
        }

        for (var i = 0; i < place.address_components.length; i++) {
            for (var j = 0; j < place.address_components[i].types.length; j++) {
                if (place.address_components[i].types[j] == "postal_code") {
                    postal_code = place.address_components[i].long_name;
                    console.log(place.address_components[i]);
                }
            }
        }


        // LOCATION_MAP.latitude = (place.geometry.location.lat());
        // LOCATION_MAP.longitude = (place.geometry.location.lng());
        if (postal_code > 0) {
            // $('input[name="zipcode"]').val(place.address_components[0].short_name);
            $('input[name="zipcode_hidden"]').val(postal_code);
        }

        console.log(place);
        // console.log(place.address_components.pop());
        // console.log(place.geometry.location.lat(), 'changed=>', LOCATION_MAP.latitude);
        // console.log(place.geometry.location.lng(), 'changed=>', LOCATION_MAP.longitude);
    }
}

function geoPositionSuccess(pos) {
    var crd = pos.coords;

    // console.log('Your current position is:');
    // console.log(`Latitude : ${crd.latitude}`);
    // console.log(`Longitude: ${crd.longitude}`);
    // console.log(`More or less ${crd.accuracy} meters.`);
    // console.log(`Coordinates ${LOCATION_MAP.latitude} latitude.`);
    // console.log(`Coordinates ${LOCATION_MAP.longitude} longitude.`);

    LOCATION_MAP.latitude = crd.latitude;
    LOCATION_MAP.longitude = crd.longitude;

    if (LOCATION_MAP.longitude !== 0) $('.user-location').hide();

    initialize();
    console.log(`latitude Coordinates set ${LOCATION_MAP.latitude} latitude.`);
    console.log(`longitude Coordinates set ${LOCATION_MAP.longitude} longitude.`);
}

function geoPositionError(err) {
    console.warn(`ERROR(${err.code}): ${err.message}`);
    $('.user-location current').html(`ERROR(${err.code}): ${err.message}`);
    initialize();
}


$(document).on('click', '.zipcode i', function () {
    navigator.geolocation.getCurrentPosition(geoPositionSuccess, geoPositionError, geoPositionOptions);
});
$(document).on('keyup', 'input[name="zipcode"]', function (e) {
    if ($(this).val() !== '') {
        $('input[name="zipcode_hidden"]').val($(this).val());
    } else {
        $('input[name="zipcode_hidden"]').val('');
    }
});
/***************************************************************************/
// listen for the window resize event & trigger Google Maps to update too
$(window).resize(function () {
    // (the 'map' here is the result of the created 'var map = ...' above)
    if (map !== undefined) {
        google.maps.event.trigger(map, "resize");
    }

    if (visibleView && visibleView.parent('a').hasClass('show')) {
        $('.list-view a').trigger('click');
    }
});

$(document).ready(function () {
    getPlacesAutoComplete();

    visibleView = $('.list-view a span:visible');
    /****Google Map Script***/
    // var script = document.createElement('script');
    // let google_api_key = $('meta[name=google-api-key]').attr('content');
    // script.type = "text/javascript";
    // script.src = "https://maps.googleapis.com/maps/api/js?key=" + google_api_key + "&callback=initialize";
    //
    // document.body.appendChild(script);
    /****Google Map Script***/

    $('.list-view a').on('click', function () {
        $('.showall').hide();
        $('.pagination').hide();

        $('.list-view a').toggleClass('show');
        $('.scroll-mob').toggleClass('none');
        $('body').toggleClass('mobile-screen');
        $('.map-area').toggleClass('show');

        // console.log('lisview', $('.listview').is(':visible'))
        if (!$('.listview').is(':visible')) {
            $('.pagination-list-main').show();
            initialize(1, 10);
        } else {
            initialize(1, 1);
            $('.pagination-list-main').hide();
        }
    });

    $(document).on('click', '.pagenation_btn', function (e) {

        if ($(this).attr('disabled') === 'disabled') return;

        $('.page-load').css('display', 'block');
        var page = parseInt($(this).data('url').replace('/?page=', '')) || 1;
        if (!$('.listview').is(':visible')) {
            $('.pagination-list-main').show();
            initialize(page, 10);
        } else {
            initialize(page, 1);
            $('.pagination-list-main').hide();
        }
    });
})

function generatePaginationHtml(data, elementClass) {
    var $container = $('.pagination.' + elementClass);
    var data_object = elementClass === 'pagination-map' ? data : null;
    var html = '<div class="container">';

    /**** row start ***/
    html += '<div class="row">';
    html += '<div class="underlist "></div>';

    /**** Col-md-2***/
    html += '<div class="col-md-2">';
    html += '<a class="btn prev pagenation_btn" ' + (data.prev_page_url === null ? 'disabled' : '') + ' data-url="' + data.prev_page_url + '">' +
        '<i class="fas fa-chevron-left" aria-hidden="true"></i>' +
        '</a>';

    html += '</div>';
    /**** end Col-md-2***/

    /**** Col-md-8***/

    if (data_object) {

        html += '<div class="col-md-8  mobileul">';
        html += 'Showing <div class="current">' + data_object.from + '-' + data_object.total + '</div> <div class="total">(' + data_object.total + ' total)</div>';
        html += '</div>';
    } else {
        html += '<div class="col-md-8 align-items-center d-flex justify-content-center">';
        html += '<ul>';
        for (var a = 1; a < data.links.length - 1; a++) {
            html += '<li class="pagenation_btn ' + (data.links[a].active === true ? 'active' : '') + '" data-url="' + data.links[a].url + '">' + data.links[a].label + '</li>';
        }
        html += '</ul>';
        html += '</div>';
    }


    /**** end Col-md-8***/

    /**** Col-md-2***/
    html += '<div class="col-md-2 d-flex justify-content-end">';
    html += '<a class="btn next pagenation_btn" ' + (data.next_page_url === null ? 'disabled' : '') + ' data-url="' + data.next_page_url + '">' +
        '<i class="fas fa-chevron-right" aria-hidden="true"></i>' +
        '</a>';

    html += '</div>';
    /**** end Col-md-2***/

    html += '</div>';
    /**** row end  ***/
    html += '</div>';

    return (data.total > data.per_page) ? html : '';
}

/***************************************************************************/
var requestInProgress;

function initialize(page = 1, limit = 10) {
    if (requestInProgress) {
        requestInProgress.abort();
    }
    if (typeof google === "undefined" || document.getElementById("map") === null) return;
    $('.page-load').css('display', 'block');

    var current_view = !$('.listview').is(':visible') ? 'list_view' : 'map_view';
    var current_width = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap',
        zoom: 11,
        streetViewControl: false,
        zoomControl: true,
        zoomControlOptions: {
            position: google.maps.ControlPosition.RIGHT_CENTER,
        },
        styles: [
            {
                "featureType": "administrative.neighborhood",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "hue": "#ff0000"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#c5bcb9",
                        "weight": "30",
                    }
                ]
            },

            {
                "featureType": "landscape.natural",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#eef1e4"
                    }
                ]
            },

            {
                "featureType": "poi.medical",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#fbd3da"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#d0e7ba"
                    }
                ]
            },

            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffa35c"
                    }
                ]
            },

            {
                "featureType": "road.arterial",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "black"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "transit.station.airport",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#cfb2db"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#a2daf2"
                    }
                ]
            }
            ,
            {
                "featureType": "administrative.country",
                "elementType": "geometry",
                "stylers": [
                    {"visibility": "simplified"},

                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [
                    {"visibility": "on"},

                ]
            },
            {
                "featureType": "landscape",
                "elementType": "labels",
                "stylers": [
                    {"visibility": "on"}
                ]
            }
        ]
    };

    window.defaultIcon = {scaledSize: new google.maps.Size(60, 60), /* scaled size*/ url: marker_map,};
    window.defaultIconSmall = {scaledSize: new google.maps.Size(60, 60), /* scaled size*/ url: marker_map_2digit,};
    window.activeIcon = {scaledSize: new google.maps.Size(60, 60), /* scaled size*/ url: marker_map_hover,};
    window.activeIconSmall = {scaledSize: new google.maps.Size(60, 60), /* scaled size*/ url: marker_map_hover_2digit,};

    map = new google.maps.Map(document.getElementById("map"), mapOptions);

    markers = [];

    var zip = $('input[name="zipcode"]').val() !== '' ? $('input[name="zipcode_hidden"]').val() : '';
    var zip_hidden = getUrlParameter('zipcode_hidden') === getUrlParameter('zipcode_hidden') ? getUrlParameter('zipcode_hidden') : $('input[name="zipcode_hidden"]').val();
    var hospital = $('.select2-selection__rendered_show').val();

    if (current_view === 'map_view') {
        $(".mob-listing").css('display', 'block');
        $(".pagination-list-main").css('visibility', 'hidden');
    } else {
        $(".mob-listing").css('display', 'none');
        $(".pagination-list-main").css('visibility', 'visible');
    }

    localStorage.setItem('hospital', hospital);


    var params = {
        current_view: current_view,
        zipcode: zip,
        zipcode_hidden: zip_hidden,
        hospital: hospital,
        page: page,
        lat: LOCATION_MAP.latitude,
        lng: LOCATION_MAP.longitude
    };
    markersObj = [];

    if (LOCATION_MAP.latitude > 0) {
        /*markersObj.push(new google.maps.Marker({
                position: new google.maps.LatLng(LOCATION_MAP.latitude, LOCATION_MAP.longitude),
                map: map,
                title: 'Your Location',
                id: '-1',
            })
        )*/
    }

    requestInProgress = $.getJSON(route_ajax_map, params, function (data) {
        $('.showall').hide();
        let mapPromise;

        var data_object = data.current_view === 'list_view' ? data.list_view : data.map_view;
        var startnumberPaginate = data.current_view === 'list_view' ? data.list_view.from : data.map_view.from;
        var markers_list = data.current_view === 'list_view' ? data.list_view.data : data.map_view.data;
        var limit = data.current_view === 'list_view' ? data.list_view.per_page : data.map_view.per_page;

        if (data.success && data_object.total > 0) {
            $('all,current').parent().show();
            $('.showall all').html(numberWithCommas(data_object.total));
            $('.showall current').html(
                data_object.from + ' - ' +
                (data.current_view === 'list_view' ? data_object.to : data_object.total)
            );
            $('.pagination').show();
            $('#contents').html('');

            $('.pagination-list').html(data.current_view === 'list_view'
                ? generatePaginationHtml(data.list_view, 'pagination-list')
                : generatePaginationHtml(data.map_view, 'pagination-map')
            );

            $('.pagination-map').html(data.current_view === 'map_view'
                ? generatePaginationHtml(data.map_view, 'pagination-map')
                : generatePaginationHtml(data.list_view, 'pagination-list')
            );
            mapPromise = new Promise(async (mainResolve, reject) => {

                let promiseArray = [];
                await $(markers_list).each(async (index, items) => {
                    promiseArray.push(
                        getMarkersHtml(items.lat, items.lng, startnumberPaginate++, index, data, items, limit)
                        /* This code require 200ms between each request making with google maps */
                    );
                });

                Promise.all(promiseArray).then((values) => {
                    mainResolve(markers);
                });

            });

            mapPromise
                .then((markers) => {
                    // console.log(markers);
                    var marker, i;
                    for (i = 0; i < markers.length; i++) {
                        // if(markers[i][1] !== 'NaN') {
                        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);

                        if (markers[i][1] !== 'NaN') {
                            bounds.extend(position);
                        }
                        marker = new google.maps.Marker({
                            position: position,
                            map: map,
                            title: String(markers[i][3]),
                            id: String(markers[i][0]),
                            icon: String(markers[i][3]).length <= 2 ? window.defaultIconSmall : window.defaultIcon,
                            label: {
                                text: String(markers[i][3]),
                                color: "#FFFFFF",
                                fontSize: "16px",
                                fontWeight: "bold"
                            }
                        });
                        markersObj.push(marker);


                        $('div#container' + marker.id).attr('data-marker-id', i);
                        /************************************* Marker Click **************************************************/
                        google.maps.event.addListener(marker, 'click', (function (marker, i) {
                            return function () {
                                var elem = $('div#container' + marker.id);
                                var $markerId = parseInt(elem.attr('data-marker-id'));
                                var $section_id = parseInt(elem.attr('data-section-name'));

                                updateIcons(markersObj[$markerId]);

                            }
                        })(marker, i));
                        google.maps.event.addListener(marker, 'mouseover', (function (marker, i) {
                            return function () {
                                var elem = $('div#container' + marker.id);
                                var $markerId = parseInt(elem.attr('data-marker-id'));
                                var $section_id = parseInt(elem.attr('data-section-name'));
                                // console.log(elem);
                                // console.log($section_id);
                                updateIcons(markersObj[$markerId]);
                                // $.scrollify.move("#" + $section_id);
                            }
                        })(marker, i));
                        map.setZoom(current_width < 768 ? 15 : 11);

                        map.fitBounds(bounds);
                        // }
                    }

                    $('.page-load').css('display', 'none');
                    starRating();

                    // console.log(markers.length);
                    if (markers.length < 2) {
                        // CHANGE ZOOM LEVEL AFTER FITBOUNDS
                        var zoomChangeBoundsListener = google.maps.event.addListenerOnce(map, 'idle', function (event) {
                            if (this.getZoom()) {
                                this.setZoom(current_width < 768 ? 15 : 14);
                                // map.setCenter(default_position);
                            }
                        });
                        setTimeout(function () {
                            google.maps.event.removeListener(zoomChangeBoundsListener)
                        }, 2000);
                    }
                })

                .catch(err => {
                    console.log(err)
                });


        } else {
            $('all,current').parent().hide();
            $('.page-load').css('display', 'none');

            var html_list = data.current_view === 'list_view' ? data.list_html : data.map_html;

            var container = $('<div></div>', {
                id: 'container',
                class: 'map-div-container',
            });

            var html = '<div class="location-sec" >' + html_list[0] + '</div>';
            container.append(html);
            if (limit > 1) {
                $('#contents').html('').append(container);
            } else {
                $('#mobile-contents').html('').append(container);
            }
            $(".pagination").hide();


            default_position = new google.maps.LatLng(32.7775898, -96.8174749);
            bounds.extend(default_position);
            map.fitBounds(bounds);

            // CHANGE ZOOM LEVEL AFTER FITBOUNDS
            var zoomChangeBoundsListener = google.maps.event.addListenerOnce(map, 'bounds_changed', function (event) {
                if (this.getZoom()) {
                    this.setZoom(11);
                    // map.setCenter(default_position);
                }
            });
            setTimeout(function () {
                google.maps.event.removeListener(zoomChangeBoundsListener)
            }, 2000);


        }
        if (data.no_record_message !== '-1') {
            $('#contents').prepend(
                '<div  class="map-div-container" data-plan="true">' +
                '<div class="location-sec" data-place="0">' +
                '<div class="near-by-location"><span>' + data.no_record_message + '</span></div>' +
                '</div>' +
                '</div>'
            );
        }

        map.addListener("zoom_changed", () => {
            // console.log(map);
            console.log("Zoom: " + map.getZoom());

        });
    });
}

function getMarkersHtml(item_lat, item_lng, startnumber, index, data, items, limit) {


    var html_list = data.current_view === 'list_view' ? data.list_html : data.map_html;
    item_lat = Number.parseFloat(item_lat).toFixed(7);
    item_lng = Number.parseFloat(item_lng).toFixed(7);

    if (item_lat !== 0 && item_lng !== 0) {

        var container = $('<div></div>', {
            id: 'container' + index,
            class: 'map-div-container',
            'data-section-name': index,
            'data-more-result': items.id,
            'data-plan': items.plain,
        });
        var destination_location = {
            lat: item_lat,
            lng: item_lng,
        };
        var current_dis_location = {
            lat: LOCATION_MAP.latitude,
            lng: LOCATION_MAP.longitude,
        };

        var milesDistance = 0;
        if (LOCATION_MAP.latitude !== 0) {
            // console.log(items);
            // console.log('current_dis_location', current_dis_location);
            // console.log('destination_location', destination_location);
            let haversine_distance_in_miles = haversine_distance(current_dis_location, destination_location);
            milesDistance = 'distance_miles' in items ? items.distance_miles : haversine_distance_in_miles;
        }
        var html = '<div class="location-sec" onmouseover="mouse_over(' + index + ')"  data-place="' + index + '">';
        html += '<div class="listing">';
        html += '<h4>' + parseInt(startnumber) + '</h4>';
        html += '<h5 class="item-mile">' + (+milesDistance.toFixed(2)) + ' mile</h5>';
        html += '</div>';
        html += html_list[items.id];
        html += '</div>';

        if ('plain' in items) {
            html = html_list[items.id];
        }

        container.append(html);
        if (limit > 1) {
            $('#contents').append(container);
        } else {
            $('#mobile-contents').html('').append(container);
        }
        markers.push([index, item_lat, item_lng, parseInt(startnumber)]);
    }
    return true;
}

function haversine_distance(coords1, coords2, isMiles) {
    isMiles = true;

    function toRad(x) {
        return x * Math.PI / 180;
    }

    var lon1 = coords1.lng;
    var lat1 = coords1.lat;

    var lon2 = coords2.lng;
    var lat2 = coords2.lat;

    var R = 6371; // km

    var x1 = lat2 - lat1;
    var dLat = toRad(x1);
    var x2 = lon2 - lon1;
    var dLon = toRad(x2)
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c;

    if (isMiles) d /= 1.60934;

    return d;
}

function numberWithCommas(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

function isMobileBrowser() {
    var check = false;
    (function (a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|iPad|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
    })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
}

function attachScroll() {

    $.scrollify({
        scrollSpeed: 1100,
        section: ".map-div-container",
        offset: 0,
        setHeights: false,
        updateHash: false,
        after: function (index, sections) {
            //console.log('After', index);
        },
        before: function (index, sections) {
            var $currentContainer = $.scrollify.current();
            var $markerId = $currentContainer.attr('data-marker-id');
            // console.log($markerId);
            // console.log(markersObj[$markerId]);

            updateIcons(markersObj[$markerId]);
            $.scrollify.update();
        }
    });
    /*FIX for scroll if it in between */
    $("html, body").animate({scrollTop: 0}, 1000);
}

function mouse_over(x) {
    var elem = $('div#container' + x);
    var $markerId = parseInt(elem.attr('data-marker-id'));

    google.maps.event.trigger(markersObj[$markerId], 'mouseover');

}

function updateIcons(marker) {

    if (marker !== undefined) {
        // console.log(marker)
        for (var j = (markersObj[0].id === '-1' ? 1 : 0); j < markersObj.length; j++) {
            var ICON = String(markersObj[j].label.title).length <= 2 ? window.defaultIconSmall : window.defaultIcon;

            markersObj[j].setIcon(ICON);
            markersObj[j].label.color = '#FFFFFF';
            markersObj[j].label.fontSize = '16px';
        }
        marker.label.color = '#0c0c0c';
        marker.label.fontSize = '16px';
        var ICON_ACTIVE = String(marker.label.title).length <= 2 ? window.activeIconSmall : window.activeIcon;
        marker.setIcon(ICON_ACTIVE);
        map.panTo(marker.getPosition());
        // map.setZoom(7);
    }
}

function getUrlParameter(which) {
    let url_string = window.location.href;
    let url = new URL(url_string);
    return url.searchParams.get(which);
    // console.log(c);
}

/***************************************************************************/
// Array.prototype.remove = function (el) {
//     return this.splice(this.indexOf(el), 1);
// };
