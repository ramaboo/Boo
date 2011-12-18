(function($) {
	$.fn.fixIE6 = function() {
		if ($.browser.msie && $.browser.version < 7) {
			return this.each(function() {
				if ($(this).css("float") === "left" || $(this).css("float") === "right") {
					if ($(this).css("display") !== "none") {
						$(this).css("display", "inline");
					}
				}
			});
		} else {
			return this.each(function() {});
		}
	};
})(jQuery);