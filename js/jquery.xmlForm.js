jQuery(document).ready(function() {
	
});

(function($) {
	$.fn.xmlForm = function(options) {
		// apply options
		var settings = $.extend({}, $.fn.xmlForm.defaults, options);

		
		// public function
		
		this.validate = function() {
			
			return this;
		}
		
		// default settings
		$.fn.xmlForm.defaults = {
			formSuccessCallback: function(data) {},
			formErrorCallback: function(data) {}
			
		};
		
		return this.each(function() {
			$this = $(this);
			
			$this.bind('submit', function() {
				
				$boo.msgError.removeMessage('*');
				$boo.msgSuccess.removeMessage('*');
				
				$.ajax({
					url: $this.attr('action'),
					type: 'POST',
					dataType: 'json',
					data: $this.serialize(),
					success: function(data, textStatus) {
						
						if (data.valid) {
							$boo.msgSuccess.addMessage(data.success);
							settings.formSuccessCallback(data);
						} else {
							
							$boo.msgError.merge(data.errors);
							
							//$.each(data.errors, function(i, val) {
							//	$boo.msgError.addMessage(val);
							//});
							
							
							settings.formErrorCallback(data);
						}
						
						
					}, error : function(XMLHttpRequest, textStatus, errorThrown) {
						$boo.msgError.addMessage('Error please try again!');
					}
					
				});
				
				return false;
			});
			
    	});
		
	};
})(jQuery);