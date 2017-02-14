;(function($, window, document, undefined) {
	var $win = $(window);
	var $doc = $(document);

	$doc.ready(function() {
		$('.btn-menu').on('click', function (event) {
		    $(this).toggleClass('active');  
		    $('.nav').toggleClass('visible')	
		    event.preventDefault();
		});
	});
})(jQuery, window, document);
