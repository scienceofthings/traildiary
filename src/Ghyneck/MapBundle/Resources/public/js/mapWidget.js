$(function () {
    $.widget("custom.mapwidget", {
        options: {
            mapId: 'map',
            centerPoint: null,
            mapUrl: '',
            zoom: ''
        },        
        _create: function () {
            this.map = this._createMap(this.options.mapUrl, this.options.centerPoint, this.options.zoom);
        },
        getMap: function() {
          return this.map;
        },
        _createMap: function(mapUrl, centerPoint, zoom) {
            var map = L.map(this.options.mapId, {
                fullscreenControl: {
                    pseudoFullscreen: true
                }
            });

            map.setView([centerPoint.lat, centerPoint.lon], zoom);
            L.tileLayer(
                mapUrl, {
                    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
                    maxZoom: 18
                })
                .addTo(map);
            return map;
        }
    });
});