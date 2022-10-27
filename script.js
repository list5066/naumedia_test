
function ready() {
    ymaps.ready(init);
    function init() {
        let myMap = new ymaps.Map("map", {
            center: [55.76, 37.64],
            zoom: 10
        });

        for (let addr in top.pointsData)
        {
            let goods = top.pointsData[addr];

            ymaps.geocode('Москва, ' + addr, {
                results: 1
            }).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0),
                    coords = firstGeoObject.geometry.getCoordinates(),
                    bounds = firstGeoObject.properties.get('boundedBy');
    
                firstGeoObject.options.set('preset', 'islands#darkBlueDotIconWithCaption');
                firstGeoObject.properties.set('iconCaption', goods.join(", "));
    
                var myPlacemark = new ymaps.Placemark(coords, {
                    iconContent: '',
                    iconCaption: goods.join(", "),
                    balloonContent: "<b>" + firstGeoObject.getAddressLine() + "</b><br>\n"
                                    + addr + "<br>\n"
                                    + goods.join(", ")
                    });

                myMap.geoObjects.add(myPlacemark);
            });
        }
    }

}

document.addEventListener("DOMContentLoaded", ready);