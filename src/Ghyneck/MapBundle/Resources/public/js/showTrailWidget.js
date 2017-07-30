$(function () {
    $.widget("custom.showtrailwidget", {
        options: {
            existingMapObject: null,
            webPathToGpxFile: null
        },
        _create: function () {
            this._drawTrack(this.options.existingMapObject, this.options.webPathToGpxFile);
        },
        _drawTrack: function(existingMapObject, webPathToGpxFile) {
            var customLayer = L.geoJson(null,{
                style: function() {
                    return { color: 'red' };
                }
            });
            omnivore.gpx(webPathToGpxFile, null, customLayer).addTo(existingMapObject);
        }
    });
});