$(function () {
    $.widget("custom.leafletwidget", {
    // default options
        options: {
            mapId: 'map',
            imagePath: null,            
            trackPoints: null,
            // callbacks
            change: null,
            random: null
        },        
        _create: function () {                        
            this._drawTracks(this.options.trackPoints);
            //this._refresh();
        },
        // called when created, and later when changing options
        _refresh: function () {
            this.element.css("background-color", "rgb(" +
                    this.options.red + "," +
                    this.options.green + "," +
                    this.options.blue + ")"
                    );
            // trigger a callback/event
            this._trigger("change");
        },
        // a public method to change the color to a random value
        // can be called directly via .colorize( "random" )
        random: function (event) {
            var colors = {
                red: Math.floor(Math.random() * 256),
                green: Math.floor(Math.random() * 256),
                blue: Math.floor(Math.random() * 256)
            };
            // trigger an event, check if it's canceled
            if (this._trigger("random", event, colors) !== false) {
                this.option(colors);
            }
        },
        _drawTracks: function(trackPointsInLeafletFormat) {
            var map = L.map(this.options.mapId).setView([47.923672, 7.895910], 13);
            L.tileLayer(                        
                        'http://b.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png', {
                            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
                            maxZoom: 18
                        })
            .addTo(map);
            L.Icon.Default.imagePath = this.options.imagePath;
            L.marker([47.923672, 7.895910]).addTo(map);
            
            var pointList = trackPointsInLeafletFormat;               
            L.polyline(pointList, {color: 'red'}).addTo(map);
        },
        // events bound via _on are removed automatically
        // revert other modifications here
        _destroy: function () {
        // remove generated elements
            this.changer.remove();
            this.element
                    .removeClass("custom-colorize")
                    .enableSelection()
                    .css("background-color", "transparent");
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