/* global wp */
/**
 * Live preview bindings for the Customizer.
 */
( function ( wp ) {
	'use strict';

	if ( ! wp || ! wp.customize ) {
		return;
	}

	wp.customize( 'blogdescription', function ( value ) {
		value.bind( function ( to ) {
			document.querySelectorAll( '.site-description' ).forEach( function ( el ) {
				el.textContent = to;
			} );
		} );
	} );

	function bindColor( setting, cssVar ) {
		wp.customize( setting, function ( value ) {
			value.bind( function ( to ) {
				document.documentElement.style.setProperty( cssVar, to );
			} );
		} );
	}
	bindColor( 'cxc_color_primary', '--cxc-primary' );
	bindColor( 'cxc_color_secondary', '--cxc-secondary' );
	bindColor( 'cxc_color_accent', '--cxc-accent' );

	function bindText( setting, selector ) {
		wp.customize( setting, function ( value ) {
			value.bind( function ( to ) {
				document.querySelectorAll( selector ).forEach( function ( el ) {
					el.textContent = to;
				} );
			} );
		} );
	}
	bindText( 'cxc_hero_eyebrow', '.cxc-hero .eyebrow' );
	bindText( 'cxc_hero_heading', '.cxc-hero h1' );
	bindText( 'cxc_hero_subheading', '.cxc-hero .lead' );
	bindText( 'cxc_hero_btn_text', '.cxc-hero-actions .btn:not(.btn-outline)' );
	bindText( 'cxc_hero_btn2_text', '.cxc-hero-actions .btn-outline' );
	bindText( 'cxc_cta_heading', '.cxc-cta h2' );
	bindText( 'cxc_cta_text', '.cxc-cta p' );
	bindText( 'cxc_cta_btn_text', '.cxc-cta .btn' );
} )( window.wp );
