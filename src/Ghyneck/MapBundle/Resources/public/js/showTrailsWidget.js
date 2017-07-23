$(function () {
    $.widget("custom.showtrailswidget", {
        options: {
            mapId: 'map',
            imagePath: null,            
            webPathToGpxFile: null,
            centerPoint: null,
            tours: null,
            mapUrl: ''
        },        
        _create: function () {
            this.map = this._createMap(this.options.mapUrl, this.options.centerPoint);
            this._addMarkers(this.options.tours);
        },
        _createMap: function(mapUrl, centerPoint) {
            var map = L.map(this.options.mapId).setView([centerPoint.lat, centerPoint.lon], 10);
            L.tileLayer(
                mapUrl, {
                    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
                    maxZoom: 18
                })
                .addTo(map);
            return map;
        },
        _addMarkers: function(tours) {
            L.Icon.Default.imagePath = this.options.imagePath;
            for(i = 0; i < tours.length; i++){
                var tour = tours[i];
                var marker = L.marker(
                    [tour.lat, tour.lon],
                    {
                        'title': tour.title
                    }
                ).addTo(this.map);
                marker.bindPopup(tour.markerText).openPopup();
            }


        }
    });
});