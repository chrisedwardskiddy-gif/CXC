<?php
/**
 * Performance & head clean-up tweaks so pages load quickly on every device.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Strip out the default cruft WordPress prints in wp_head.
 */
function cxc_head_cleanup() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
}
add_action( 'init', 'cxc_head_cleanup' );

/**
 * Disable the emoji script/style unless a client actively wants it.
 */
function cxc_disable_emojis() {
	if ( apply_filters( 'cxc_keep_emoji_scripts', false ) ) {
		return;
	}
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'cxc_disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'cxc_disable_emojis_dns_prefetch', 10, 2 );
}
add_action( 'init', 'cxc_disable_emojis' );

/**
 * Remove the emoji plugin from TinyMCE.
 *
 * @param array $plugins TinyMCE plugins.
 * @return array
 */
function cxc_disable_emojis_tinymce( $plugins ) {
	return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
}

/**
 * Remove emoji CDN from DNS prefetch hints.
 *
 * @param array  $urls          Resource hints.
 * @param string $relation_type Type of resource hint.
 * @return array
 */
function cxc_disable_emojis_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		$urls = array_filter(
			$urls,
			static function ( $url ) {
				return false === strpos( $url, 'https://s.w.org/images/core/emoji/' );
			}
		);
	}
	return $urls;
}

/**
 * Remove the WP block library CSS on pages that contain no blocks, and drop
 * jQuery Migrate from the front end (core jQuery stays, since third-party
 * plugins may still need it).
 */
function cxc_dequeue_unused_assets() {
	if ( is_admin() ) {
		return;
	}

	wp_deregister_script( 'jquery-migrate' );

	if ( ! is_singular() || ! has_blocks() ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'classic-theme-styles' );
	}
}
add_action( 'wp_enqueue_scripts', 'cxc_dequeue_unused_assets', 100 );

/**
 * Add async/defer attributes to selected script handles without extra deps.
 *
 * @param string $tag    The <script> tag.
 * @param string $handle The script's registered handle.
 * @return string
 */
function cxc_add_defer_attribute( $tag, $handle ) {
	$defer_handles = apply_filters( 'cxc_defer_script_handles', array( 'chrisxcreative-main' ) );

	if ( in_array( $handle, $defer_handles, true ) && false === strpos( $tag, 'defer' ) ) {
		$tag = str_replace( ' src', ' defer src', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'cxc_add_defer_attribute', 10, 2 );

/**
 * Ensure native lazy-loading stays enabled for images/iframes (core default,
 * declared explicitly so it can't be disabled by a mu-plugin without notice).
 */
add_filter( 'wp_lazy_loading_enabled', '__return_true' );

/**
 * Limit post revisions & extend autosave interval slightly to reduce DB writes.
 */
if ( ! defined( 'WP_POST_REVISIONS' ) ) {
	define( 'WP_POST_REVISIONS', 6 );
}

/**
 * Add width/height + fetchpriority hints are handled by core since WP 6.3;
 * we simply make sure oEmbed responses are cached and heartbeat is throttled
 * in the front end to save resources on shared hosting.
 *
 * @param array $settings Heartbeat settings.
 * @return array
 */
function cxc_heartbeat_settings( $settings ) {
	$settings['interval'] = 60;
	return $settings;
}
add_filter( 'heartbeat_settings', 'cxc_heartbeat_settings' );

/**
 * Disable heartbeat on the front end entirely (front end has no need for it).
 */
function cxc_disable_front_end_heartbeat() {
	if ( ! is_admin() ) {
		wp_deregister_script( 'heartbeat' );
	}
}
add_action( 'init', 'cxc_disable_front_end_heartbeat', 1 );
