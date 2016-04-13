$(function () {
    $.widget("custom.showtrailswidget", {
        options: {
            mapId: 'map',
            imagePath: null,            
            webPathToGpxFile: null,
            centerPoint: null,
            tours: null
        },        
        _create: function () {
            this.map = this._createMap(this.options.centerPoint);
            this._addMarkers(this.options.tours);
            //this._drawTrack(map, this.options.webPathToGpxFile);
        },
        _drawTrack: function(map, webPathToGpxFile) {
            var customLayer = L.geoJson(null,{
                style: function(feature) {
                    return { color: 'red' };
                }
            });
            omnivore.gpx(webPathToGpxFile, null, customLayer).addTo(map);
        },
        _createMap: function(centerPoint) {
            var map = L.map(this.options.mapId).setView([centerPoint.lat, centerPoint.lon], 10);
            L.tileLayer(
                'http://b.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png', {
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
                        'title': tour.title,
                    }
                ).addTo(this.map);
                marker.bindPopup(tour.markerText).openPopup();
            }


        }
    });
});