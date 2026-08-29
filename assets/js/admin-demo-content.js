/**
 * Drives the "Install Demo Content" button on Appearance > Theme Setup.
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var btn = document.getElementById( 'cxc-install-demo' );
		if ( ! btn || 'undefined' === typeof cxcDemoData ) {
			return;
		}

		var spinner = document.querySelector( '.cxc-setup-card .spinner' );
		var log     = document.getElementById( 'cxc-install-log' );

		btn.addEventListener( 'click', function () {
			if ( ! window.confirm( cxcDemoData.confirm ) ) {
				return;
			}

			btn.disabled = true;
			spinner && spinner.classList.add( 'is-active' );
			log.innerHTML = '<p>' + cxcDemoData.working + '</p>';

			var formData = new FormData();
			formData.append( 'action', 'cxc_install_demo_content' );
			formData.append( 'nonce', cxcDemoData.nonce );

			fetch( cxcDemoData.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				body: formData,
			} )
				.then( function ( response ) { return response.json(); } )
				.then( function ( data ) {
					if ( data.success ) {
						log.innerHTML = '<div class="notice notice-success inline"><p>' + cxcDemoData.done + '</p></div>';
					} else {
						log.innerHTML = '<div class="notice notice-error inline"><p>' + ( ( data.data && data.data.message ) || 'Error' ) + '</p></div>';
					}
				} )
				.catch( function () {
					log.innerHTML = '<div class="notice notice-error inline"><p>Something went wrong. Please try again.</p></div>';
				} )
				.finally( function () {
					btn.disabled = false;
					spinner && spinner.classList.remove( 'is-active' );
				} );
		} );
	} );
} )();
