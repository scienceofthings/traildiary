$(function () {
    $.widget("custom.showtrailswidget", {
        options: {
            existingMapObject: null,
            tours: null,
            imagePath: null,
        },        
        _create: function () {
            this._addMarkers(this.options.existingMapObject, this.options.tours, this.options.imagePath);
        },
        _addMarkers: function(existingMapObject, tours, imagePath) {
            L.Icon.Default.imagePath = imagePath;
            for(i = 0; i < tours.length; i++){
                var tour = tours[i];
                var marker = L.marker(
                    [tour.lat, tour.lon],
                    {
                        'title': tour.title
                    }
                ).addTo(existingMapObject);
                marker.bindPopup(tour.markerText).openPopup();
            }


        }
    });
});