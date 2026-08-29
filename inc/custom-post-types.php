<?php
/**
 * Custom post types & taxonomies: Portfolio, Services, Testimonials, Team.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Portfolio, Service, Testimonial and Team Member post types.
 */
function cxc_register_post_types() {

	register_post_type(
		'cxc_portfolio',
		array(
			'labels'             => array(
				'name'               => __( 'Portfolio', 'chrisxcreative' ),
				'singular_name'      => __( 'Portfolio Item', 'chrisxcreative' ),
				'add_new_item'       => __( 'Add New Portfolio Item', 'chrisxcreative' ),
				'edit_item'          => __( 'Edit Portfolio Item', 'chrisxcreative' ),
				'all_items'          => __( 'Portfolio', 'chrisxcreative' ),
				'featured_image'     => __( 'Project Image', 'chrisxcreative' ),
			),
			'public'             => true,
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => 'portfolio' ),
			'menu_icon'          => 'dashicons-portfolio',
			'menu_position'      => 20,
			'show_in_rest'       => true,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
		)
	);

	register_post_type(
		'cxc_service',
		array(
			'labels'        => array(
				'name'          => __( 'Services', 'chrisxcreative' ),
				'singular_name' => __( 'Service', 'chrisxcreative' ),
				'add_new_item'  => __( 'Add New Service', 'chrisxcreative' ),
				'edit_item'     => __( 'Edit Service', 'chrisxcreative' ),
				'all_items'     => __( 'Services', 'chrisxcreative' ),
			),
			'public'        => true,
			'has_archive'   => true,
			'rewrite'       => array( 'slug' => 'services' ),
			'menu_icon'     => 'dashicons-hammer',
			'menu_position' => 21,
			'show_in_rest'  => true,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
		)
	);

	register_post_type(
		'cxc_testimonial',
		array(
			'labels'        => array(
				'name'          => __( 'Testimonials', 'chrisxcreative' ),
				'singular_name' => __( 'Testimonial', 'chrisxcreative' ),
				'add_new_item'  => __( 'Add New Testimonial', 'chrisxcreative' ),
				'edit_item'     => __( 'Edit Testimonial', 'chrisxcreative' ),
				'all_items'     => __( 'Testimonials', 'chrisxcreative' ),
			),
			'public'        => true,
			'has_archive'   => false,
			'rewrite'       => array( 'slug' => 'testimonials' ),
			'menu_icon'     => 'dashicons-format-quote',
			'menu_position' => 22,
			'show_in_rest'  => true,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		)
	);

	register_post_type(
		'cxc_team',
		array(
			'labels'        => array(
				'name'          => __( 'Team Members', 'chrisxcreative' ),
				'singular_name' => __( 'Team Member', 'chrisxcreative' ),
				'add_new_item'  => __( 'Add New Team Member', 'chrisxcreative' ),
				'edit_item'     => __( 'Edit Team Member', 'chrisxcreative' ),
				'all_items'     => __( 'Team', 'chrisxcreative' ),
			),
			'public'        => true,
			'has_archive'   => true,
			'rewrite'       => array( 'slug' => 'team' ),
			'menu_icon'     => 'dashicons-groups',
			'menu_position' => 23,
			'show_in_rest'  => true,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
		)
	);

	register_taxonomy(
		'cxc_portfolio_category',
		'cxc_portfolio',
		array(
			'labels'            => array(
				'name'          => __( 'Portfolio Categories', 'chrisxcreative' ),
				'singular_name' => __( 'Portfolio Category', 'chrisxcreative' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'portfolio-category' ),
		)
	);
}
add_action( 'init', 'cxc_register_post_types' );

/**
 * Flush rewrite rules once after the theme is switched to (so the CPT
 * archive & taxonomy permalinks work immediately).
 */
function cxc_flush_rewrites_on_switch() {
	cxc_register_post_types();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'cxc_flush_rewrites_on_switch' );

/**
 * Add "Feature on homepage" as a quick-editable column for Portfolio & Services.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function cxc_cpt_columns( $columns ) {
	$columns['cxc_featured'] = __( 'Featured', 'chrisxcreative' );
	return $columns;
}
add_filter( 'manage_cxc_portfolio_posts_columns', 'cxc_cpt_columns' );
add_filter( 'manage_cxc_service_posts_columns', 'cxc_cpt_columns' );
add_filter( 'manage_cxc_testimonial_posts_columns', 'cxc_cpt_columns' );

/**
 * Render the "Featured" column value.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function cxc_cpt_columns_content( $column, $post_id ) {
	if ( 'cxc_featured' === $column ) {
		echo get_post_meta( $post_id, '_cxc_featured', true ) ? '&#9733;' : '&#8212;';
	}
}
add_action( 'manage_cxc_portfolio_posts_custom_column', 'cxc_cpt_columns_content', 10, 2 );
add_action( 'manage_cxc_service_posts_custom_column', 'cxc_cpt_columns_content', 10, 2 );
add_action( 'manage_cxc_testimonial_posts_custom_column', 'cxc_cpt_columns_content', 10, 2 );

/**
 * Helper: get a limited list of "featured on homepage" posts for a CPT,
 * falling back to the most recent posts if none are flagged as featured.
 *
 * @param string $post_type Post type slug.
 * @param int    $number    Number of posts to return.
 * @return WP_Post[]
 */
function cxc_get_homepage_posts( $post_type, $number = 6 ) {
	$featured = new WP_Query(
		array(
			'post_type'      => $post_type,
			'posts_per_page' => $number,
			'meta_key'       => '_cxc_featured',
			'meta_value'     => '1',
			'orderby'        => 'menu_order date',
			'order'          => 'ASC',
			'no_found_rows'  => true,
		)
	);

	if ( $featured->have_posts() ) {
		return $featured->posts;
	}

	$latest = new WP_Query(
		array(
			'post_type'      => $post_type,
			'posts_per_page' => $number,
			'orderby'        => 'menu_order date',
			'order'          => 'ASC',
			'no_found_rows'  => true,
		)
	);

	return $latest->posts;
}
