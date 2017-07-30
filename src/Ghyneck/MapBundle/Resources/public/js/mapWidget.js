$(function () {
    $.widget("custom.leafletwidget", {
        options: {
            mapId: 'map',
            imagePath: null,            
            webPathToGpxFile: null,
            centerPoint: null,
            mapUrl: '',
            // callbacks
            change: null
        },        
        _create: function () {
            var map = this._createMap(this.options.mapUrl, this.options.centerPoint);
            this._drawTrack(map, this.options.webPathToGpxFile);
            //this._refresh();
        },
        _drawTrack: function(map, webPathToGpxFile) {
            var customLayer = L.geoJson(null,{
                style: function() {
                    return { color: 'red' };
                }
            });
            omnivore.gpx(webPathToGpxFile, null, customLayer).addTo(map);
        },
        _createMap: function(mapUrl, centerPoint) {
            var map = L.map(this.options.mapId, {
                fullscreenControl: {
                    pseudoFullscreen: true
                }
            });

            map.setView([centerPoint.lat, centerPoint.lon], 13);
            L.tileLayer(
                mapUrl, {
                    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
                    maxZoom: 18
                })
                .addTo(map);
            L.Icon.Default.imagePath = this.options.imagePath;
            return map;
        },
        // _setOptions is called with a hash of all options that are changing
        // always refresh when changing options
        _setOptions: function () {
        // _super and _superApply handle keeping the right this-context
            this._superApply(arguments);
            this._refresh();
        },
        // _setOption is called for each individual option that is changing
        _setOption: function (key, value) {
            this._super(key, value);
        }
    });
});