jQuery(document).ready(function($) {

	/**
	 *	Process request to dismiss our admin notice
	 */
	$('#jetpack-notice .notice-dismiss').click(function() {

		//* Data to make available via the $_POST variable
		data = {
			action: 'edin_jetpack_admin_notice',
			edin_jetpack_admin_nonce: edin_jetpack_admin.edin_jetpack_admin_nonce
		};

		//* Process the AJAX POST request
		$.post( ajaxurl, data );

		return false;
	});
});