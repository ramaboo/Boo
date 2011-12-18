// global reference to Boo
var $boo;
jQuery(document).ready(function() {
	$boo = $().boo().init();
	
	// handle external links
	$("a[rel='external']").addClass("external");
	$("a[rel='external']").bind("click", function() {
		window.open((this).href);
		return false;
	});
	
	if ($.browser.msie && $.browser.version < 7) {
		$("*").fixIE6();
	}
});

(function($) {
	$.fn.boo = function(options) {
		// apply options
		var settings = $.extend({}, $.fn.boo.defaults, options);
		
		// init function
		this.init = function() {
			return this;
		}
		
		// default settings
		$.fn.boo.defaults = {};
		
		this.msgError = $('#messagebox-error').messageBox();
		this.msgSuccess = $('#messagebox-success').messageBox();
		this.msgWarning = $('#messagebox-warning').messageBox();
		this.msgGlobal = $('#messagebox-global').messageBox();
		
		return this.each(function() {});
	};
})(jQuery);




