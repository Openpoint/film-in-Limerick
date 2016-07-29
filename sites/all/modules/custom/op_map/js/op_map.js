(function($){

	var timeout;
	
	Drupal.behaviors.op_map = {		
		attach: function (context, settings) {
			op_map.settings = settings
			
			$('body').once('op_map',function(){
				
				op_map.context = context;
				if(!op_map.context.location.origin){
					op_map.context.location.origin = op_map.context.location.protocol+'//'+op_map.context.location.host;
				}
				op_map.init();
				
				//only run if we are on a filter select page			
				if($("#edit-shs-term-node-tid-depth").length){
					
					//make the map with the initial view @zoom level 12 centered on Limerick
					op_map.makeMap(12,[-8.618602752685547, 52.66024653406791]);
					op_map.addLayer('points');
										
				//only run if we are on a single location page
				}else if($('#op_map_latlon').length){
					var lonlat = JSON.parse($('#op_map_latlon').html());
					op_map.makeMap(14,lonlat);
					op_map.addLayer('points');
					op_map.addLayer('location');
					var data = {
						type:'FeatureCollection',
						features:[
							{
								type:'Feature',
								geometry:{
									type:'Point',
									coordinates:lonlat
								},
								properties:{}
								
							}
						]
					}
					op_map.setLayer(data,'location');					
					op_map.layers.location.setStyle(op_map.styles.single);										
				}
				

				$('.ol-full-screen-false').addClass('material-icons').html('&#xE5D0;');
				
				var maskout;
				$(window).scroll(function(){
					clearTimeout(maskout);
					$('#op_mapWrapper .mask').show().css('opacity',1);
					maskout = setTimeout(function(){
						$('#op_mapWrapper .mask').css('opacity',0);
						setTimeout(function(){
							$('#op_mapWrapper .mask').hide();
							
						},100);
						
						
					},500);
				});					
			})
			
			timeout = setTimeout(function(){
				clearTimeout(timeout);

				if (
					document.fullscreenEnabled || 
					document.webkitFullscreenEnabled || 
					document.mozFullScreenEnabled ||
					document.msFullscreenEnabled
				) {
					if($('#fullscreen').length){
						var fullscreen2= new ol.control.FullScreen({
							target: document.querySelector('#fullscreen')
						});
						op_map.map.addControl(fullscreen2);
					}
				}else{
					$('#fullscreen').hide();
				}
				$('.ol-full-screen-false, .ol-full-screen-true').click(function(){
					setTimeout(function(){
						$('.ol-full-screen-true').addClass('material-icons').html('&#xE5D1;');
						$('.ol-full-screen-false').not('#fullscreen .ol-full-screen-false').addClass('material-icons').html('&#xE5D0;');
					},300);
					
				});
				op_map.getFeed('points','cluster');
				if($("#edit-shs-term-node-tid-depth").length){
					
				}else if($('#op_map_latlon').length){
					
				}							
			},0);

		}
	}
})(jQuery);
