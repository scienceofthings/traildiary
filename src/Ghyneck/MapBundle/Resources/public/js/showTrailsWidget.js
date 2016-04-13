$(function () {
    $.widget("custom.showtrailswidget", {
        options: {
            mapId: 'map',
            imagePath: null,            
            webPathToGpxFile: null,
            centerPoint: null,
            // callbacks
            change: null,
            random: null
        },        
        _create: function () {
            var map = this._createMap(this.options.centerPoint);
            //this._drawTrack(map, this.options.webPathToGpxFile);
        },
        // called when created, and later when changing options
        _refresh: function () {
            this._trigger("change");
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
            L.Icon.Default.imagePath = this.options.imagePath;
            var marker = L.marker(
                [47.99366, 7.83992],
                {
                    'title': 'erste Tour',
                    'alt': 'alt-Text erste Tour'
                }
            ).addTo(map);
            marker.bindPopup("<b>Hello world!</b><br>I am a popup.<a href='http://www.google.de'>Google</a>").openPopup();

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
        // prevent invalid color values
            if (/red|green|blue/.test(key) && (value < 0 || value > 255)) {
                return;
            }
            this._super(key, value);
        }
    });
});