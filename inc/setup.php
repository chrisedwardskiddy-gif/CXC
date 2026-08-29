<?php
/**
 * Core theme setup: supports, menus, sidebars, image sizes.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme setup.
 */
function cxc_setup() {
	load_theme_textdomain( 'chrisxcreative', CXC_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'appearance-tools' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 220,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'ffffff',
		)
	);
	add_theme_support(
		'custom-header',
		array(
			'width'       => 1920,
			'height'      => 900,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_editor_style( 'assets/css/editor-style.css' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'chrisxcreative' ),
			'mobile'  => __( 'Mobile Menu (optional, falls back to Primary)', 'chrisxcreative' ),
			'footer'  => __( 'Footer Menu', 'chrisxcreative' ),
			'legal'   => __( 'Legal / Bottom Bar Menu', 'chrisxcreative' ),
		)
	);

	add_image_size( 'cxc-portfolio-thumb', 800, 600, true );
	add_image_size( 'cxc-portfolio-large', 1600, 1000, true );
	add_image_size( 'cxc-blog-thumb', 600, 450, true );
	add_image_size( 'cxc-blog-list', 400, 300, true );
	add_image_size( 'cxc-hero', 1400, 1000, false );

	set_post_thumbnail_size( 1200, 800, true );
}
add_action( 'after_setup_theme', 'cxc_setup' );

/**
 * Register widget areas.
 */
function cxc_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar', 'chrisxcreative' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Displayed on blog posts and archives.', 'chrisxcreative' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array(
				/* translators: %d: footer column number */
				'name'          => sprintf( __( 'Footer Column %d', 'chrisxcreative' ), $i ),
				'id'            => 'footer-' . $i,
				'description'   => __( 'Widget area in the site footer.', 'chrisxcreative' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	register_sidebar(
		array(
			'name'          => __( 'Header Top Bar', 'chrisxcreative' ),
			'id'            => 'header-top',
			'description'   => __( 'Small widget area inside the header top bar (e.g. an icon list or text).', 'chrisxcreative' ),
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="screen-reader-text">',
			'after_title'   => '</span>',
		)
	);
}
add_action( 'widgets_init', 'cxc_widgets_init' );

/**
 * Register block pattern / editor color palette via theme.json is preferred,
 * but we also declare legacy support flags for older cores.
 */
function cxc_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cxc_content_width', 820 );
}
add_action( 'after_setup_theme', 'cxc_content_width', 0 );
