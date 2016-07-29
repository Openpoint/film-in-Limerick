var op_map = {
	
	'layers':{},
	'styleCache':{},
	'styles':{},
};

(function($){
	
	var count = 0;
	var count2 = 0;
	var circle_style = false;
	
	//Initialise the map
	op_map.init=function(){
		op_map.styles.icon = new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
			anchor: [0.5, 1],
			size: [28, 40],
			opacity: .75,
			src: '/'+op_map.settings.op_map.module_path+'/location.png'
		}));
		
			
		op_map.styles.circle = new ol.style.Circle({
			radius: 15,
			stroke: new ol.style.Stroke({
				color: '#fff'
			}),
			fill: new ol.style.Fill({
				color: 'rgba(225,30,112,.9)'
			})
		})
		op_map.styles.circle2 = new ol.style.Circle({
			radius: 15,
			stroke: new ol.style.Stroke({
				color: '#fff'
			}),
			fill: new ol.style.Fill({
				color: 'rgba(0,169,219,.9)'
			})
		})
		op_map.styles.single=new ol.style.Style({
			image: op_map.styles.icon,
		})
		op_map.styles.cluster = function(feature, resolution) {
					
			var size = feature.get('features').length;
			var style = op_map.styleCache[size];
			if (!style) {
				
				var popup = {};
				if(size > 1){
					if(circle_style){
						var image = op_map.styles.circle2;
					}else{
						var image = op_map.styles.circle;
					}
					var text=size.toString();					
				}else{
					
					if(circle_style){
						var image = op_map.styles.circle2;
						var text=size.toString();
					}else{
						var image = op_map.styles.icon;
						var text='';
					}					
					
				};

				style = [
					new ol.style.Style({
						image: image,
						text: new ol.style.Text({
							text: text,
							fill: new ol.style.Fill({
								color: '#fff'
							})
						})
					})
				
				];
				
				op_map.styleCache[size] = style;
				
			}
			return style;
		}
	}	

	
	//create map
	op_map.makeMap = function(zoom, center){
		
		op_map.map = new ol.Map({
			target: 'op_map',
			layers: [
				new ol.layer.Tile({
					source: new ol.source.Stamen({layer: 'toner'}),					
				})
			],
			view: new ol.View({
				center: ol.proj.fromLonLat(center),
				zoom: zoom
			}),

		});
		var fullscreen = new ol.control.FullScreen();
		
		op_map.map.addControl(fullscreen);
		
		
		//add the overlay for popups
		var container = document.getElementById('popup');
		var content = document.getElementById('popup-content');
		var closer = document.getElementById('popup-closer');
		var popup = new ol.Overlay({
			element: container,
			autoPan: true,
			autoPanAnimation: {
				duration: 250
			}
		});
		closer.onclick = function() {
			popup.setPosition(undefined);
			closer.blur();
			return false;
		};
		op_map.map.addOverlay(popup);
		
		//triggers for interacting with features and overlay
		
		var pointertime;
		var pointer = function(e){
			
			var pixel = op_map.map.getEventPixel(e.originalEvent);
			var hit = op_map.map.hasFeatureAtPixel(pixel);
			$('#op_map')[0].style.cursor = hit ? 'pointer' : '';
			clearTimeout('pointertime');			
		}
			
		
		op_map.map.on('pointermove', function(e) {
			clearTimeout(pointertime);


			if (e.dragging) {
				popup.setPosition(undefined);
				return;
			}	
			setTimeout(function(){
				$('#op_map')[0].style.cursor = null;
			},50);		
			pointertime=setTimeout(function(){
				pointer(e);				
			},50);

		});
				
		op_map.map.on('click', function(evt) {
			var feature = op_map.map.forEachFeatureAtPixel(evt.pixel, function(feature) {
				return feature;
			});

			popup.setPosition(undefined);
			if (feature && feature.get('features')) {
				if(feature.get('features').length > 1){
					var text = '<ul>\n';						
					$(feature.get('features')).each(function(){
						text = text+'<li class="c1 text">'+this.getProperties().name+'</li>\n';
					});
					text = text + '</ul>\n';
				}else{
					var props = $(feature.get('features'))[0].getProperties();
					text='<div class="inside w100 image c1 bdr">'+props.description +'</div><div class="inside c1 text">'+props.name+'</div>';
				}
				
				var coordinate = feature.getGeometry().getCoordinates();
				content.innerHTML = text;
				popup.setPosition(coordinate);
				
			} else {

			}
		});	
			
	}
	
	//add layers to a map
	op_map.addLayer=function(layer){

		op_map.layers[layer] = new ol.layer.Vector;
		op_map.layers[layer].setProperties({'id':layer});
		op_map.map.addLayer(op_map.layers[layer]);
		op_map.layers[layer].setZIndex(2);
						
	}
	
	//add vector source from json to layer
	op_map.setLayer = function(geojson,layer){
		for(i=0; i < geojson.features.length; i++){
			geojson.features[i].geometry.coordinates = ol.proj.fromLonLat(geojson.features[i].geometry.coordinates);
		}
		var map_source = new ol.source.Vector({
			features: (new ol.format.GeoJSON()).readFeatures(geojson)
		});		
		
		op_map.layers[layer].setSource(map_source);		
	}
	
	//cluster features on map
	op_map.cluster = function(layer, cluster){
		
		var layerSource = op_map.layers[layer].getSource();
		var clusterSource = new ol.source.Cluster({
			distance: 30,
			source: layerSource
		});
		if(!op_map.layers[cluster]){
			op_map.addLayer(cluster);
			op_map.layers[cluster].setStyle(op_map.styles.cluster);
			op_map.layers[layer].setStyle(null);
		}
		
		op_map.layers[cluster].setSource(clusterSource);
		op_map.layers[cluster].setZIndex(1);
		
	}
	
	//get the json from feed
	op_map.getFeed = function(layer,cluster){

		if($("#edit-shs-term-node-tid-depth").length){
			tid = $("#edit-shs-term-node-tid-depth").serializeArray()[0].value;

			if(tid == 0 || count2 === 0){
				tid = op_map.context.location.search.split('=')[1];
				count2++;
			}

			if(tid === "All"){
				tid = false;
			};
			var nid = false;
			//construct the GEOjson feed url
					
			var feedurl = op_map.context.location.origin+'/'+Drupal.settings.op_map.feed_path+'/'+(tid || '')+'?cachbust='+new Date().getTime();

		}else if($('#op_map_nid').length){
			var nid = $('#op_map_nid').html();
			var tid = false;
			//construct the GEOjson feed url	
			var feedurl = op_map.context.location.origin+'/'+Drupal.settings.op_map.feed_path+'/'+(nid || '')+'?cachbust='+new Date().getTime();
			circle_style = true;
			
		}else{
			return null;
		}
		

		//get the GEOjson feed

		$.support.cors = true;
		$.ajax({
			type:'POST',
			url: feedurl,
			dataType: 'json',
			data: 'js=1',
			success: function(data) {
				if(data.features.length > 0){
					//update the layer with GEOjson features
					op_map.setLayer(data,layer);
					if(cluster){
						op_map.cluster(layer, cluster, circle_style);
					}				
					//fit the big location map view to features only after initial - initial view is focussed on Limerick
					if(count > 0 || tid){
						op_map.fitZoom([layer]);
					}else if(nid){
						op_map.fitZoom([layer,'location']);
					}else{
						count++;
						count2++;
					}
				}
			}
		});	
	}
	
	//zoom the map to fit features
	op_map.fitZoom = function(layer){
		var extent = ol.extent.createEmpty();
		for(i=0; i < layer.length; i++){			
			if(op_map.layers[layer[i]]){
				var extent1 = op_map.layers[layer[i]].getSource().getExtent();
				ol.extent.extend(extent, extent1);
			}
		};
		
		
		op_map.map.getView().fit(extent, op_map.map.getSize());
		if(op_map.map.getView().getZoom() > 15){
			op_map.map.getView().setZoom(15);
		}
	}
})(jQuery);
