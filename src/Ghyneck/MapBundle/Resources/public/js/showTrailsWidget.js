$(function () {
    $.widget("custom.showtrailswidget", {
        options: {
            mapId: 'map',
            imagePath: null,            
            webPathToGpxFile: null,
            centerPoint: null,
        },        
        _create: function () {
            this.map = this._createMap(this.options.centerPoint);
            this._addMarkers();
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
        _addMarkers: function() {
            L.Icon.Default.imagePath = this.options.imagePath;
            var marker = L.marker(
                [47.99366, 7.83992],
                {
                    'title': 'erste Tour',
                    'alt': 'alt-Text erste Tour'
                }
            ).addTo(this.map);
            marker.bindPopup("<b>Hello world!</b><br>I am a popup.<a href='http://www.google.de'>Goossgle</a>").openPopup();
        }
    });
});