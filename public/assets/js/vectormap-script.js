
	$(function(){
				$.ajax({
				url: server+"/analytics/visitors",
				type: "GET",
				dataType:"json",
				success: function(data){
					
				var markers_array = [];
				$.each(data.countries, function(key, value) {
					
						var countries = {};
						countries.latLng=[value.latitude, value.longitude];
						countries.name=value.country +':'+ value.count;
						countries.style={fill: '#26c6da'};
						markers_array.push(countries);
				});
				map(markers_array);
				}
			})

		function map(markers_array){
			
   jQuery('#world-map-markers').vectorMap({
        map: 'world_mill_en'
        , backgroundColor: '#383f47'
        , borderColor: '#ccc'
        , borderOpacity: 0.9
        , borderWidth: 1
        , zoomOnScroll : false
        , color: '#ddd'
        , regionStyle: {
            initial: {
                fill: '#fff' 
            }
        }
        , markerStyle: {
            initial: {
            /*    r: 8
                , 'fill': '#26c6da'
                , 'fill-opacity': 1
                , 'stroke': '#000'
                , 'stroke-width': 0
                , 'stroke-opacity': 1*/

				 image: server+'/images/location.jpg',
            }
        , }
        , enableZoom: true
        , hoverColor: false
        , markers:markers_array
        , hoverOpacity: null
        , normalizeFunction: 'linear'
        , selectedRegions: []
        , showTooltip: true
        , onRegionClick: function (element, code, region) {
            //var message = 'You clicked "' + region + '" which has the code: ' + code.toUpperCase();
            //alert(message);
        }
    });	
}

});