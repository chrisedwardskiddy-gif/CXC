<?php
/**
 * Custom nav menu walker that adds an accessible expand/collapse button to
 * any item with children, for the off-canvas mobile menu.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class CXC_Mobile_Menu_Walker.
 */
class CXC_Mobile_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Start the element output, adding a submenu-toggle button for parents.
	 *
	 * @param string   $output Passed by reference.
	 * @param WP_Post  $item   Menu item.
	 * @param int      $depth  Depth.
	 * @param stdClass $args   Menu args.
	 * @param int      $id     Item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$has_children = in_array( 'menu-item-has-children', $item->classes, true );
		$indent       = $depth ? str_repeat( "\t", $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$class_names = implode( ' ', array_filter( $classes ) );

		$output .= "{$indent}<li class=\"" . esc_attr( $class_names ) . '">';

		$attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_url( $item->url ) . '"' : '';

		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$output .= '<a' . $attributes . '><span>' . esc_html( $title ) . '</span></a>';

		if ( $has_children ) {
			$output .= '<button type="button" class="mobile-submenu-toggle" aria-expanded="false" aria-label="' . esc_attr__( 'Show submenu', 'chrisxcreative' ) . '"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>';
		}
	}
}
