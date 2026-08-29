<?php
/**
 * Filters that tweak markup produced by WordPress core.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Extra body classes for styling hooks.
 *
 * @param array $classes Existing classes.
 * @return array
 */
function cxc_body_classes( $classes ) {
	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/template-full-width.php' ) || is_page_template( 'page-templates/template-landing.php' ) ) {
		$classes[] = 'no-sidebar';
	}
	$classes[] = 'has-sidebar';

	if ( 'on' === get_theme_mod( 'cxc_dark_mode_default', 'off' ) ) {
		$classes[] = 'cxc-dark-default';
	}

	if ( is_page_template( 'page-templates/template-landing.php' ) ) {
		$classes[] = 'cxc-landing-page';
	}

	return $classes;
}
add_filter( 'body_class', 'cxc_body_classes' );

/**
 * Add sensible attributes to nav menu <ul> for the primary menu.
 *
 * @param array $args Nav menu args.
 * @return array
 */
function cxc_nav_menu_args( $args ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$args->link_before = '<span>';
		$args->link_after  = '</span>';
	}
	return $args;
}
add_filter( 'wp_nav_menu_args', 'cxc_nav_menu_args' );

/**
 * Add "menu-item-has-children" is already core; here we ensure sub-menu
 * items get an accessible toggle button in the mobile menu context via JS,
 * so nothing else is required server-side.
 */

/**
 * Widen the excerpt length slightly for card layouts.
 *
 * @param int $length Default length.
 * @return int
 */
function cxc_excerpt_length( $length ) {
	return is_admin() ? $length : 22;
}
add_filter( 'excerpt_length', 'cxc_excerpt_length' );

/**
 * Custom excerpt "more" marker.
 *
 * @return string
 */
function cxc_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'cxc_excerpt_more' );

/**
 * Register oEmbed / REST-friendly title fallback for CPT archives so
 * `wp_get_document_title()` reads well.
 *
 * @param string $title Existing title.
 * @return string
 */
function cxc_document_title_parts( $title ) {
	if ( is_post_type_archive( 'cxc_portfolio' ) && empty( $title['title'] ) ) {
		$title['title'] = __( 'Portfolio', 'chrisxcreative' );
	}
	return $title;
}
add_filter( 'document_title_parts', 'cxc_document_title_parts' );

/**
 * Basic Open Graph tags for singular content, skipped automatically if an
 * SEO plugin (Yoast, RankMath, AIOSEO, SEOPress) is already handling it.
 */
function cxc_open_graph_tags() {
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) ) {
		return;
	}
	if ( ! is_singular() ) {
		return;
	}

	global $post;
	$title       = get_the_title( $post );
	$description = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( wp_strip_all_tags( $post->post_content ), 30 );
	$image       = has_post_thumbnail( $post ) ? get_the_post_thumbnail_url( $post, 'large' ) : '';

	printf( '<meta property="og:type" content="article" />' . "\n" );
	printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $description ) );
	printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( get_permalink( $post ) ) );
	if ( $image ) {
		printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $image ) );
	}
	printf( '<meta name="twitter:card" content="%s" />' . "\n", esc_attr( $image ? 'summary_large_image' : 'summary' ) );
}
add_action( 'wp_head', 'cxc_open_graph_tags' );

/**
 * Add the theme colour scheme + viewport meta.
 */
function cxc_meta_viewport() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";
	echo '<meta name="theme-color" content="' . esc_attr( get_theme_mod( 'cxc_color_primary', '#5b3df0' ) ) . '" />' . "\n";
}
add_action( 'wp_head', 'cxc_meta_viewport', 1 );
