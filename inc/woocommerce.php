<?php
/**
 * Light-touch WooCommerce compatibility. Only loads if WooCommerce is
 * active, and simply wraps its default templates in our container /
 * spacing classes rather than overriding templates wholesale.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Declare WooCommerce support.
 */
function cxc_woocommerce_support() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 600,
			'gallery_thumbnail_image_width' => 150,
			'single_image_width'    => 800,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 5,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'cxc_woocommerce_support' );

if ( ! function_exists( 'is_woocommerce_active' ) ) {
	/**
	 * Small guard for the hooks below (WooCommerce not required).
	 *
	 * @return bool
	 */
	function cxc_is_woocommerce_active() {
		return class_exists( 'WooCommerce' );
	}
}

/**
 * Swap WooCommerce's default wrappers for our own container so shop pages
 * match the rest of the site instead of running full-bleed.
 */
function cxc_woocommerce_wrapper_start() {
	echo '<div class="cxc-content-wrap"><div class="cxc-container woocommerce-page-wrap">';
}
function cxc_woocommerce_wrapper_end() {
	echo '</div></div>';
}

if ( cxc_is_woocommerce_active() ) {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	add_action( 'woocommerce_before_main_content', 'cxc_woocommerce_wrapper_start', 10 );
	add_action( 'woocommerce_after_main_content', 'cxc_woocommerce_wrapper_end', 10 );

	// Give WooCommerce's own sale/product badges our brand gradient.
	add_filter(
		'woocommerce_sale_flash',
		static function () {
			return '<span class="onsale" style="background:var(--cxc-gradient,linear-gradient(120deg,#5b3df0,#00c2a8));">' . esc_html__( 'Sale!', 'chrisxcreative' ) . '</span>';
		}
	);

	// Default number of products per row/page to match our 4-col grid.
	add_filter( 'loop_shop_columns', static fn() => 4 );
}
