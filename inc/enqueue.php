<?php
/**
 * Styles, scripts and web fonts.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end assets.
 */
function cxc_scripts() {
	wp_enqueue_style( 'chrisxcreative-fonts', cxc_fonts_url(), array(), null );
	wp_enqueue_style( 'chrisxcreative-style', get_stylesheet_uri(), array(), CXC_VERSION );
	wp_style_add_data( 'chrisxcreative-style', 'rtl', 'replace' );

	wp_enqueue_script( 'chrisxcreative-main', CXC_URI . '/assets/js/main.js', array(), CXC_VERSION, true );
	wp_script_add_data( 'chrisxcreative-main', 'defer', true );

	wp_localize_script(
		'chrisxcreative-main',
		'cxcData',
		array(
			'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
			'nonce'        => wp_create_nonce( 'cxc_contact_form' ),
			'homeUrl'      => home_url( '/' ),
			'darkModeText' => __( 'Toggle dark mode', 'chrisxcreative' ),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cxc_scripts' );

/**
 * Google Fonts URL, respecting a "no external fonts" privacy toggle.
 *
 * @return string
 */
function cxc_fonts_url() {
	if ( 'off' === get_theme_mod( 'cxc_load_google_fonts', 'on' ) ) {
		return CXC_URI . '/assets/css/system-fonts.css';
	}

	$query_args = array(
		'family'  => rawurlencode( 'Plus Jakarta Sans:wght@500;700;800' ) . '|' . rawurlencode( 'Inter:wght@400;500;600;700' ),
		'display' => 'swap',
	);

	return add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
}

/**
 * Preconnect to the Google Fonts origin for faster loading.
 *
 * @param array  $urls          Resource hints.
 * @param string $relation_type Type of resource hint.
 * @return array
 */
function cxc_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type && 'off' !== get_theme_mod( 'cxc_load_google_fonts', 'on' ) ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'cxc_resource_hints', 10, 2 );

/**
 * Admin (wp-admin) assets used by our meta boxes, demo importer & branding.
 *
 * @param string $hook Current admin page.
 */
function cxc_admin_scripts( $hook ) {
	wp_enqueue_style( 'chrisxcreative-admin', CXC_URI . '/assets/css/admin.css', array(), CXC_VERSION );
}
add_action( 'admin_enqueue_scripts', 'cxc_admin_scripts' );

/**
 * Editor style tweaks so Gutenberg matches the front end.
 */
function cxc_block_editor_assets() {
	wp_enqueue_style( 'chrisxcreative-fonts', cxc_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'cxc_block_editor_assets' );
