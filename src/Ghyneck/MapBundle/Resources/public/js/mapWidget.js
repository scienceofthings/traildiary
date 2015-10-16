$(function () {
    $.widget("custom.leafletwidget", {
        options: {
            mapId: 'map',
            imagePath: null,            
            webPathToGpxFile: null,
            // callbacks
            change: null,
            random: null
        },        
        _create: function () {
            this._drawTracks(this.options.webPathToGpxFile);
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
        _drawTracks: function(webPathToGpxFile) {
            var map = L.map(this.options.mapId).setView([47.923672, 7.895910], 13);
            L.tileLayer(                        
                        'http://b.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png', {
                            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
                            maxZoom: 18
                        })
            .addTo(map);
            var customLayer = L.geoJson(null,{
                style: function(feature) {
                    return { color: 'red' };
                }
            });
            L.Icon.Default.imagePath = this.options.imagePath;
            omnivore.gpx(webPathToGpxFile, null, customLayer).addTo(map);
            //L.marker([47.923672, 7.895910]).addTo(map);
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