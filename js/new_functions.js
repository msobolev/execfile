;(function($, window, document, undefined) {
	var $win = $(window);
	var $doc = $(document);

	$doc.ready(function() {
		// This class will be added to the expanded item
		var activeItemClass = 'widget-expanded';
		var accordionItemSelector = '.widget';
		var toggleSelector = '.widget-head';

		
		
			    

			//	tooltip
			function tooltipHelper () {
				var isTouch = false;
				if($win.width() > 1024) {
					if(isTouch) {
						return;
					}

					isTouch = true;

					$(document).tooltip();
				} else {
					if(!isTouch) {
						return;
					}

					isTouch = false;
				}
			}

			
			
			



		/**
		*	JS Class
		*/
		var jsClass = function($btn) {
			$btn.on('click', function(e) {
				e.preventDefault();

				var $target = getTraverse($(this));
				var type = $(this).data('type');
				var className = $(this).data('class');

				switch(type) {
	                case 'add':
	                    $target.addClass(className);
	                    break;
	                case 'remove':
	                    $target.removeClass(className);
	                    break;
	                default:
	                    $target.toggleClass(className);
	                    break;
	            }
			});

			function getTraverse($btn) {
				var traverse = $btn.data('traverse') ? $btn.data('traverse').split('~') : '';
				var match = traverse[0];
				var target = $btn.data('target');

				switch(match) {
		            case 'parent':
		                return $btn.parents(target);
		                break;
		            case 'find':
		                return $btn.find(target);
		                break;
		            case 'sibling':
		                return $btn.siblings(target);
		                break;
		            default:
		                return $(target);
		        }
			};
		};

		jsClass($('.js-class'));
	});
})(jQuery, window, document);
