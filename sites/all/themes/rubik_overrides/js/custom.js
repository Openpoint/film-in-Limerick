/*
(function ($) {
	
	Drupal.behaviors.AJAX = {		
		attach: function (context, settings) {
    // Load all Ajax behaviors specified in the settings.
    for (var base in settings.ajax) {
      if (!$('#' + base + '.ajax-processed').length) {
        var element_settings = settings.ajax[base];

        if (typeof element_settings.selector == 'undefined') {
          element_settings.selector = '#' + base;
        }
        $(element_settings.selector).each(function () {
          element_settings.element = this;
          Drupal.ajax[base] = new Drupal.ajax(base, this, element_settings);
        });

        $('#' + base).addClass('ajax-processed');
      }
    }

    // Bind Ajax behaviors to all items showing the class.
    $('.use-ajax:not(.ajax-processed)').addClass('ajax-processed').each(function () {
      var element_settings = {};
      // Clicked links look better with the throbber than the progress bar.
      element_settings.progress = { 'type': 'throbber' };

      // For anchor tags, these will go to the target of the anchor rather
      // than the usual location.
      if ($(this).attr('href')) {
        element_settings.url = $(this).attr('href');
        element_settings.event = 'click';
      }
      var base = $(this).attr('id');
      Drupal.ajax[base] = new Drupal.ajax(base, this, element_settings);
    });

    // This class means to submit the form to the action using Ajax.
    $('.use-ajax-submit:not(.ajax-processed)').addClass('ajax-processed').each(function () {
      var element_settings = {};

      // Ajax submits specified in this manner automatically submit to the
      // normal form action.
      element_settings.url = $(this.form).attr('action');
      // Form submit button clicks need to tell the form what was clicked so
      // it gets passed in the POST request.
      element_settings.setClick = true;
      // Form buttons use the 'click' event rather than mousedown.
      element_settings.event = 'click';
      // Clicked form buttons look better with the throbber than the progress bar.
      element_settings.progress = { 'type': 'throbber' };

      var base = $(this).attr('id');
      Drupal.ajax[base] = new Drupal.ajax(base, this, element_settings);
    });

			Drupal.ajax.prototype.beforeSend = function (xmlhttprequest, options) {
				// For forms without file inputs, the jQuery Form plugin serializes the form
				// values, and then calls jQuery's $.ajax() function, which invokes this
				// handler. In this circumstance, options.extraData is never used. For forms
				// with file inputs, the jQuery Form plugin uses the browser's normal form
				// submission mechanism, but captures the response in a hidden IFRAME. In this
				// circumstance, it calls this handler first, and then appends hidden fields
				// to the form to submit the values in options.extraData. There is no simple
				// way to know which submission mechanism will be used, so we add to extraData
				// regardless, and allow it to be ignored in the former case.
				if (this.form) {
					options.extraData = options.extraData || {};

					// Let the server know when the IFRAME submission mechanism is used. The
					// server can use this information to wrap the JSON response in a TEXTAREA,
					// as per http://jquery.malsup.com/form/#file-upload.
					options.extraData.ajax_iframe_upload = '1';

					// The triggering element is about to be disabled (see below), but if it
					// contains a value (e.g., a checkbox, textfield, select, etc.), ensure that
					// value is included in the submission. As per above, submissions that use
					// $.ajax() are already serialized prior to the element being disabled, so
					// this is only needed for IFRAME submissions.
					var v = $.fieldValue(this.element);

					if (v !== null && typeof v == "object") {
						var name = this.element.name;
						$.each(v, function(i, value) {
							var key = name.replace(/\[\]/, '[' + value + ']');
							options.extraData[key] = value;
						});
					}else if (v !== null) {
						options.extraData[this.element.name] = Drupal.checkPlain(v);
					}
				}
			}
			
		}
	}


}(jQuery));
*/
