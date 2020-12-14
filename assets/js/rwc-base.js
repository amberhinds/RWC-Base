/**
 * RWC Base entry point.
 *
 * @package RWC Base JS
 * @author  Road Warrior Creative
 * @license GPL-2.0-or-later
 */

var rwcBase = ( function( $ ) {
	'use strict';

	/**
	 * detect IE
	 */
	var ua = window.navigator.userAgent;
	var isIE = /MSIE|Trident/.test(ua);
	if ( isIE ) {
		var answer = confirm("You are using an outdated browser. Please upgrade your browser to improve your experience.")
		if(answer){
			window.location="http://browsehappy.com";
		}
	}

	/**
	 * Adjust site inner margin top to compensate for sticky header height.
	 *
	 * @since 2.6.0
	 */
	var moveContentBelowFixedHeader = function() {
		var siteInnerMarginTop = 0;

		if( $('.site-header').css('position') === 'fixed' ) {
			siteInnerMarginTop = $('.site-header').outerHeight();
		}

		$('.site-inner').css('margin-top', siteInnerMarginTop);
	},

	/**
	 * Initialize RWC Base.
	 *
	 * Internal functions to execute on full page load.
	 *
	 * @since 2.6.0
	 */
	load = function() {
		moveContentBelowFixedHeader();

		$( window ).resize(function() {
			moveContentBelowFixedHeader();
		});

		// Run after the Customizer updates.
		// 1.5s delay is to allow logo area reflow.
		if (typeof wp != "undefined" && typeof wp.customize != "undefined") {
			wp.customize.bind( 'change', function ( setting ) {
				setTimeout(function() {
					moveContentBelowFixedHeader();
				  }, 1500);
			});
		}
	};

	// Search toggle
	$('.nav-primary .search-toggle').click(function(e){
		e.preventDefault();
		$(this).parent().toggleClass('active').find('input[type="search"]').focus();
	});
	$('.search-submit').click(function(e){
		if( $(this).parent().find('.search-field').val() == '' ) {
			e.preventDefault();
			$(this).parent().parent().removeClass('active');
		}
	});

	// Expose the load and ready functions.
	return {
		load: load
	};

})( jQuery );

jQuery( window ).on( 'load', rwcBase.load );
