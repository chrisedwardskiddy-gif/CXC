<?php
/**
 * ChrisXCreative Theme bootstrap.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CXC_VERSION', '1.0.0' );
define( 'CXC_DIR', get_template_directory() );
define( 'CXC_URI', get_template_directory_uri() );

/**
 * Required theme files.
 */
$cxc_includes = array(
	'inc/class-mobile-menu-walker.php', // Nav walker for the off-canvas mobile menu.
	'inc/setup.php',              // Theme supports, menus, sidebars, image sizes.
	'inc/enqueue.php',             // Styles & scripts.
	'inc/performance.php',         // Speed & clean-up tweaks.
	'inc/template-tags.php',       // Template helper functions.
	'inc/template-functions.php',  // Body classes, filters.
	'inc/customizer.php',          // Customizer sections/controls.
	'inc/custom-post-types.php',   // Portfolio, Services, Testimonials, Team.
	'inc/meta-boxes.php',          // Custom fields for the CPTs above.
	'inc/widgets.php',             // Bundled widgets.
	'inc/block-patterns.php',      // Gutenberg block patterns & categories.
	'inc/contact-form.php',        // Built-in AJAX contact form handler.
	'inc/branding.php',            // wp-admin + site footer "Designed & Hosted by" credit.
	'inc/demo-content.php',        // One-click demo content importer.
	'inc/woocommerce.php',         // Light WooCommerce compatibility.
);

foreach ( $cxc_includes as $cxc_file ) {
	$cxc_path = CXC_DIR . '/' . $cxc_file;
	if ( file_exists( $cxc_path ) ) {
		require_once $cxc_path;
	}
}
unset( $cxc_includes, $cxc_file, $cxc_path );
