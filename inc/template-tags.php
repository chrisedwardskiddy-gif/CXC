<?php
/**
 * Template helper functions used throughout the theme.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Print an inline SVG icon. Keeping icons inline (no icon font / library)
 * avoids an extra HTTP request and lets icons inherit `currentColor`.
 *
 * @param string $name Icon name.
 */
function cxc_icon( $name ) {
	$icons = array(
		'menu'      => '<path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',
		'close'     => '<path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',
		'search'    => '<circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',
		'sun'       => '<circle cx="12" cy="12" r="4.5" stroke="currentColor" stroke-width="2"/><path d="M12 2v2.5M12 19.5V22M4.2 4.2l1.8 1.8M18 18l1.8 1.8M2 12h2.5M19.5 12H22M4.2 19.8l1.8-1.8M18 6l1.8-1.8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',
		'moon'      => '<path d="M20 14.5A8.5 8.5 0 1 1 9.5 4a7 7 0 0 0 10.5 10.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>',
		'phone'     => '<path d="M6.6 10.8c1.4 2.8 3.8 5.2 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.9 21 3 13.1 3 4c0-.6.4-1 1-1h3.4c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.4 0 .8-.2 1l-2.2 2.2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>',
		'mail'      => '<rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
		'pin'       => '<path d="M12 22s7-7.4 7-12.5A7 7 0 0 0 5 9.5C5 14.6 12 22 12 22Z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="9.5" r="2.5" stroke="currentColor" stroke-width="1.6"/>',
		'arrow'     => '<path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
		'chevron-up' => '<path d="M5 15l7-7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
		'quote'     => '<path d="M9.3 8.5c-2.5 1-3.9 2.9-3.9 5.4 0 2 1.4 3.4 3.2 3.4 1.7 0 3-1.3 3-3 0-1.6-1.1-2.8-2.6-3 .2-1.1 1.2-2.1 2.6-2.6L9.3 8.5Zm8 0c-2.5 1-3.9 2.9-3.9 5.4 0 2 1.4 3.4 3.2 3.4 1.7 0 3-1.3 3-3 0-1.6-1.1-2.8-2.6-3 .2-1.1 1.2-2.1 2.6-2.6l-2.3-2.2Z" fill="currentColor"/>',
		'facebook'  => '<path d="M14 9h2V6h-2c-1.7 0-3 1.3-3 3v2H9v3h2v6h3v-6h2.2l.8-3H14V9.5c0-.3.2-.5.5-.5H14Z" fill="currentColor"/>',
		'twitter'   => '<path d="M4 4l7.2 9.6L4.4 20H7l5-4.8L16 20h4l-7.6-10L19 4h-2.6l-4.5 4.4L8 4H4Z" fill="currentColor"/>',
		'instagram' => '<rect x="3.5" y="3.5" width="17" height="17" rx="5" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.6"/><circle cx="17.2" cy="6.8" r="1.1" fill="currentColor"/>',
		'linkedin'  => '<rect x="3.5" y="3.5" width="17" height="17" rx="3" stroke="currentColor" stroke-width="1.6"/><path d="M7.5 10v6.5M7.5 7.5v.01M11.5 16.5V13c0-1.4.9-2.3 2-2.3s1.8.9 1.8 2.3v3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
		'youtube'   => '<rect x="3" y="6" width="18" height="12" rx="3" stroke="currentColor" stroke-width="1.6"/><path d="M10.5 9.7v4.6l4-2.3-4-2.3Z" fill="currentColor"/>',
		'tiktok'    => '<path d="M14 4v9.5a2.5 2.5 0 1 1-2-2.45V9a4.5 4.5 0 1 0 4 4.47V9.8a5.4 5.4 0 0 0 3 .9V8.6a3.4 3.4 0 0 1-2.5-1.1A3.4 3.4 0 0 1 15.6 4H14Z" fill="currentColor"/>',
		'dribbble'  => '<circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.6"/><path d="M4.5 10c4.5 1.4 9 1.6 15 .3M8 4.5c2.5 3 4 7 4.2 15M16.3 4.8c-.4 3-2.2 6.5-4.8 8.6-2.3 1.9-5.3 2.9-7.8 3" stroke="currentColor" stroke-width="1.3" fill="none"/>',
		'behance'   => '<path d="M3 7h5.3c2.7 0 3.9 1.3 3.9 3 0 1.2-.6 2-1.6 2.4 1.3.4 2.1 1.3 2.1 2.8 0 2-1.6 3.3-4.2 3.3H3V7Zm2.3 4.6h2.6c1 0 1.7-.5 1.7-1.4 0-.9-.6-1.4-1.7-1.4H5.3v2.8Zm0 4.8h2.8c1.1 0 1.8-.5 1.8-1.5s-.7-1.5-1.8-1.5H5.3v3ZM14 8.3h5v1.3h-5V8.3ZM21 14.8c0-2.7-1.6-4.5-4.1-4.5-2.5 0-4.2 1.9-4.2 4.5 0 2.7 1.7 4.5 4.3 4.5 1.8 0 3.2-.8 3.8-2.3h-2c-.3.5-.9.8-1.7.8-1.1 0-1.9-.7-2-1.9h5.9v-1.1Zm-5.9-.7c.2-1 .9-1.6 1.8-1.6.9 0 1.6.6 1.7 1.6h-3.5Z" fill="currentColor"/>',
		'cart'      => '<circle cx="9" cy="20" r="1.3" fill="currentColor"/><circle cx="17" cy="20" r="1.3" fill="currentColor"/><path d="M3 4h2l2.2 10.5A2 2 0 0 0 9.2 16h7.6a2 2 0 0 0 2-1.6L20 7H6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
	);

	if ( ! isset( $icons[ $name ] ) ) {
		return;
	}

	echo '<svg class="cxc-icon cxc-icon-' . esc_attr( $name ) . '" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">' . wp_kses(
		$icons[ $name ],
		array(
			'path'   => array( 'd' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'fill' => true ),
			'circle' => array( 'cx' => true, 'cy' => true, 'r' => true, 'stroke' => true, 'stroke-width' => true, 'fill' => true ),
			'rect'   => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'stroke' => true, 'stroke-width' => true, 'fill' => true ),
		)
	) . '</svg>';
}

/**
 * Output the configured social icon links.
 *
 * @param string $class Wrapper class name.
 */
function cxc_social_links_output( $class = 'footer-social' ) {
	$networks = array( 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'tiktok', 'dribbble', 'behance' );
	$links    = array();

	foreach ( $networks as $network ) {
		$url = get_theme_mod( "cxc_social_{$network}" );
		if ( $url ) {
			$links[ $network ] = $url;
		}
	}

	if ( empty( $links ) ) {
		return;
	}

	echo '<div class="' . esc_attr( $class ) . '">';
	foreach ( $links as $network => $url ) {
		printf(
			'<a href="%1$s" target="_blank" rel="noopener noreferrer" aria-label="%2$s">',
			esc_url( $url ),
			/* translators: %s: social network name */
			esc_attr( sprintf( __( 'Visit our %s page', 'chrisxcreative' ), ucfirst( $network ) ) )
		);
		cxc_icon( $network );
		echo '</a>';
	}
	echo '</div>';
}

/**
 * Breadcrumb trail, output as a lightweight schema.org list.
 */
function cxc_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	$items = array();
	$items[] = array( home_url( '/' ), __( 'Home', 'chrisxcreative' ) );

	if ( is_singular( 'cxc_portfolio' ) ) {
		$items[] = array( get_post_type_archive_link( 'cxc_portfolio' ), __( 'Portfolio', 'chrisxcreative' ) );
		$items[] = array( '', get_the_title() );
	} elseif ( is_singular( 'post' ) ) {
		$items[] = array( get_permalink( get_option( 'page_for_posts' ) ) ? get_permalink( get_option( 'page_for_posts' ) ) : get_home_url(), __( 'Blog', 'chrisxcreative' ) );
		$items[] = array( '', get_the_title() );
	} elseif ( is_singular() ) {
		$items[] = array( '', get_the_title() );
	} elseif ( is_search() ) {
		/* translators: %s: search query */
		$items[] = array( '', sprintf( __( 'Search results for "%s"', 'chrisxcreative' ), get_search_query() ) );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$items[] = array( '', single_term_title( '', false ) );
	} elseif ( is_post_type_archive() ) {
		$items[] = array( '', post_type_archive_title( '', false ) );
	} elseif ( is_404() ) {
		$items[] = array( '', __( 'Page not found', 'chrisxcreative' ) );
	}

	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'chrisxcreative' ) . '"><span itemscope itemtype="https://schema.org/BreadcrumbList">';
	foreach ( $items as $i => $item ) {
		list( $url, $label ) = $item;
		if ( $i > 0 ) {
			echo ' <span aria-hidden="true">/</span> ';
		}
		echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		if ( $url ) {
			echo '<a itemprop="item" href="' . esc_url( $url ) . '"><span itemprop="name">' . esc_html( $label ) . '</span></a>';
		} else {
			echo '<span itemprop="name">' . esc_html( $label ) . '</span>';
		}
		echo '<meta itemprop="position" content="' . esc_attr( $i + 1 ) . '" /></span>';
	}
	echo '</span></nav>';
}

/**
 * Posted-on meta (date + author + comment count).
 */
function cxc_posted_on() {
	printf(
		'<span class="posted-on"><a href="%1$s">%2$s</a></span>',
		esc_url( get_permalink() ),
		esc_html( get_the_date() )
	);
	printf(
		'<span class="byline"> %1$s <a href="%2$s">%3$s</a></span>',
		esc_html__( 'by', 'chrisxcreative' ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
	if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link(
			esc_html__( 'Leave a comment', 'chrisxcreative' ),
			esc_html__( '1 Comment', 'chrisxcreative' ),
			esc_html__( '% Comments', 'chrisxcreative' )
		);
		echo '</span>';
	}
}

/**
 * Category + tag list at the end of a post.
 */
function cxc_entry_footer() {
	$categories = get_the_category_list( ', ' );
	if ( $categories ) {
		printf( '<div class="cat-badges">%s</div>', wp_kses_post( $categories ) );
	}
	$tags = get_the_tag_list( '', ', ' );
	if ( $tags && ! is_wp_error( $tags ) ) {
		printf( '<div class="entry-tags">%s</div>', wp_kses_post( $tags ) );
	}
}

/**
 * Numeric pagination wrapper.
 */
function cxc_pagination() {
	the_posts_pagination(
		array(
			'mid_size'  => 2,
			'prev_text' => __( '&larr; Prev', 'chrisxcreative' ),
			'next_text' => __( 'Next &rarr;', 'chrisxcreative' ),
			'screen_reader_text' => __( 'Posts navigation', 'chrisxcreative' ),
		)
	);
}

/**
 * Star rating output (1-5), used by testimonial cards.
 *
 * @param int $rating Rating value.
 */
function cxc_star_rating( $rating = 5 ) {
	$rating = min( 5, max( 1, absint( $rating ) ) );
	echo '<div class="stars" aria-label="' . esc_attr(
		/* translators: %d: rating out of 5 */
		sprintf( __( 'Rated %d out of 5', 'chrisxcreative' ), $rating )
	) . '">' . esc_html( str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating ) ) . '</div>';
}

/**
 * Render the copyright / footer text with placeholders replaced.
 */
function cxc_footer_text() {
	$text = get_theme_mod( 'cxc_footer_text', '&copy; {year} {site_name}. All rights reserved.' );
	$text = str_replace(
		array( '{year}', '{site_name}' ),
		array( gmdate( 'Y' ), get_bloginfo( 'name' ) ),
		$text
	);
	echo wp_kses_post( $text );
}
