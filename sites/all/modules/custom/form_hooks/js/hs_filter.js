//limits the available hs select options by context in the content form

(function($){
	Drupal.behaviors.form_hooks = {		
		attach: function (context, settings) { 
			$('.hierarchical-select-wrapper .selects select:first option').each(function(){
				var show = Drupal.settings.form_hooks.filter;
				if($(this).attr('value') !== 'none' && show.indexOf($(this).attr('value')*1) < 0){
					$(this).remove();
				};
			});
		}		
	}
})(jQuery)
