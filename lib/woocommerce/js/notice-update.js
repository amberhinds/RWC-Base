/**
 * Trigger AJAX request to save state when the WooCommerce notice is dismissed.
 *
 * @version 2.3.0
 *
 * @author Road Warrior Creative
 * @license GPL-2.0-or-later
 * @package RWC Base
 */

jQuery( document ).on(
	'click', '.rwc-base-woocommerce-notice .notice-dismiss', function() {

		jQuery.ajax(
			{
				url: ajaxurl,
				data: {
					action: 'rwc_base_dismiss_woocommerce_notice'
				}
			}
		);

	}
);
