jQuery(document).ready(function() {
	$(".messagebox-close a").bind("click", function() {
		$(this).parent("div").parent("div").hide();
		return false;
	});
});

(function($) {
	$.fn.messageBox = function(options) {
		// apply options
		var settings = $.extend({}, $.fn.messageBox.defaults, options);
		
		var $dummy = $('<li class="jquery boo dummy"/>');
		
		// public function
		this.addMessage = function(msg, attrs) {
			$msg = $('<li>' + msg + '</li>').addClass('boo jquery');
			$msg.attr(attrs);
			$list = this.find('.messagebox-list > ol');
			$list.append($msg).children().remove('.dummy');
			this.show();
			return this;
		}
		
		this.merge = function(ol) {
			$list = this.find('.messagebox-list > ol');
			$list.append($(ol).children());
			$list.children().remove('.dummy');
			this.show();
			return this;
		}
		
		this.removeMessage = function(expr) {
			$list = this.find('.messagebox-list > ol');
			$list.find(expr).remove();
			if ($list.children().size() == 0) {
				$list.append($dummy);
				this.hide();
			}
			return this;
		}
		
		// default settings
		$.fn.messageBox.defaults = {};
		
		return this.each(function() {
			$this = $(this);
    	});
		
	};
})(jQuery);