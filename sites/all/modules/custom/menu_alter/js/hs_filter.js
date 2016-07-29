(function($){
	Drupal.behaviors.op_map = {		
		attach: function (context, settings) { 
			$('.hierarchical-select-wrapper .selects select:first option').each(function(){
				var show = Drupal.settings.form_hooks.filter;
				console.log($(this).attr('value'));
				if($(this).attr('value') !== 'none' && show.indexOf($(this).attr('value')*1) < 0){
					$(this).remove();
				};
			});
		}		
	}
})(jQuery)
