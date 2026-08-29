<?php
/**
 * Theme Customizer: colors, header, footer, homepage & social settings.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Customizer panel, sections and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function cxc_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => static function () {
					bloginfo( 'name' );
				},
			)
		);
	}

	$wp_customize->add_panel(
		'cxc_theme_options',
		array(
			'title'       => __( 'ChrisXCreative Theme Options', 'chrisxcreative' ),
			'description' => __( 'Colours, header, footer, homepage content and social links for your ChrisXCreative theme.', 'chrisxcreative' ),
			'priority'    => 10,
		)
	);

	/* ---------------------------------------------------------------
	 * Colours & Style
	 * ------------------------------------------------------------- */
	$wp_customize->add_section(
		'cxc_colors',
		array(
			'title' => __( 'Colours & Style', 'chrisxcreative' ),
			'panel' => 'cxc_theme_options',
		)
	);

	$wp_customize->add_setting(
		'cxc_color_primary',
		array(
			'default'           => '#5b3df0',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'cxc_color_primary',
			array(
				'label'   => __( 'Primary Colour', 'chrisxcreative' ),
				'section' => 'cxc_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'cxc_color_secondary',
		array(
			'default'           => '#00c2a8',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'cxc_color_secondary',
			array(
				'label'   => __( 'Secondary Colour', 'chrisxcreative' ),
				'section' => 'cxc_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'cxc_color_accent',
		array(
			'default'           => '#ff5d73',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'cxc_color_accent',
			array(
				'label'   => __( 'Accent Colour', 'chrisxcreative' ),
				'section' => 'cxc_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'cxc_dark_mode_default',
		array(
			'default'           => 'off',
			'sanitize_callback' => 'cxc_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'cxc_dark_mode_default',
		array(
			'label'   => __( 'Default to dark mode for new visitors', 'chrisxcreative' ),
			'section' => 'cxc_colors',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'cxc_enable_dark_toggle',
		array(
			'default'           => 'on',
			'sanitize_callback' => 'cxc_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'cxc_enable_dark_toggle',
		array(
			'label'   => __( 'Show light/dark mode switch in the header', 'chrisxcreative' ),
			'section' => 'cxc_colors',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'cxc_load_google_fonts',
		array(
			'default'           => 'on',
			'sanitize_callback' => 'cxc_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'cxc_load_google_fonts',
		array(
			'label'       => __( 'Load Google Fonts (Plus Jakarta Sans + Inter)', 'chrisxcreative' ),
			'description' => __( 'Turn off to use system fonts only, for maximum speed / GDPR-friendliness.', 'chrisxcreative' ),
			'section'     => 'cxc_colors',
			'type'        => 'checkbox',
		)
	);

	/* ---------------------------------------------------------------
	 * Header
	 * ------------------------------------------------------------- */
	$wp_customize->add_section(
		'cxc_header',
		array(
			'title' => __( 'Header', 'chrisxcreative' ),
			'panel' => 'cxc_theme_options',
		)
	);

	$wp_customize->add_setting(
		'cxc_show_topbar',
		array(
			'default'           => 'on',
			'sanitize_callback' => 'cxc_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'cxc_show_topbar',
		array(
			'label'   => __( 'Show top bar (phone, email, social)', 'chrisxcreative' ),
			'section' => 'cxc_header',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'cxc_topbar_phone',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'cxc_topbar_phone',
		array(
			'label'   => __( 'Top bar phone number', 'chrisxcreative' ),
			'section' => 'cxc_header',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'cxc_topbar_email',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'cxc_topbar_email',
		array(
			'label'   => __( 'Top bar email address', 'chrisxcreative' ),
			'section' => 'cxc_header',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'cxc_sticky_header',
		array(
			'default'           => 'on',
			'sanitize_callback' => 'cxc_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'cxc_sticky_header',
		array(
			'label'   => __( 'Sticky header on scroll', 'chrisxcreative' ),
			'section' => 'cxc_header',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'cxc_show_search_icon',
		array(
			'default'           => 'on',
			'sanitize_callback' => 'cxc_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'cxc_show_search_icon',
		array(
			'label'   => __( 'Show search icon in header', 'chrisxcreative' ),
			'section' => 'cxc_header',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'cxc_header_cta_text',
		array(
			'default'           => __( 'Get a Quote', 'chrisxcreative' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'cxc_header_cta_text',
		array(
			'label'   => __( 'Header button text (leave blank to hide)', 'chrisxcreative' ),
			'section' => 'cxc_header',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'cxc_header_cta_url',
		array(
			'default'           => '#contact',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'cxc_header_cta_url',
		array(
			'label'   => __( 'Header button link', 'chrisxcreative' ),
			'section' => 'cxc_header',
			'type'    => 'url',
		)
	);

	/* ---------------------------------------------------------------
	 * Homepage
	 * ------------------------------------------------------------- */
	$wp_customize->add_section(
		'cxc_homepage',
		array(
			'title' => __( 'Homepage Content', 'chrisxcreative' ),
			'panel' => 'cxc_theme_options',
		)
	);

	$homepage_fields = array(
		'cxc_hero_eyebrow'      => array( 'label' => __( 'Hero eyebrow text', 'chrisxcreative' ), 'default' => __( 'Welcome to ChrisXCreative', 'chrisxcreative' ), 'type' => 'text' ),
		'cxc_hero_heading'      => array( 'label' => __( 'Hero heading', 'chrisxcreative' ), 'default' => __( 'We design and build brands people remember.', 'chrisxcreative' ), 'type' => 'textarea' ),
		'cxc_hero_subheading'   => array( 'label' => __( 'Hero subheading', 'chrisxcreative' ), 'default' => __( 'A bespoke studio crafting fast, beautiful and high-converting websites, brands and digital products.', 'chrisxcreative' ), 'type' => 'textarea' ),
		'cxc_hero_btn_text'     => array( 'label' => __( 'Hero primary button text', 'chrisxcreative' ), 'default' => __( 'Start a Project', 'chrisxcreative' ), 'type' => 'text' ),
		'cxc_hero_btn_url'      => array( 'label' => __( 'Hero primary button link', 'chrisxcreative' ), 'default' => '#contact', 'type' => 'url' ),
		'cxc_hero_btn2_text'    => array( 'label' => __( 'Hero secondary button text', 'chrisxcreative' ), 'default' => __( 'View Our Work', 'chrisxcreative' ), 'type' => 'text' ),
		'cxc_hero_btn2_url'     => array( 'label' => __( 'Hero secondary button link', 'chrisxcreative' ), 'default' => '#portfolio', 'type' => 'url' ),
		'cxc_cta_heading'       => array( 'label' => __( 'Call-to-action heading', 'chrisxcreative' ), 'default' => __( "Got a project in mind? Let's build it.", 'chrisxcreative' ), 'type' => 'text' ),
		'cxc_cta_text'          => array( 'label' => __( 'Call-to-action text', 'chrisxcreative' ), 'default' => __( 'Tell us about your goals and we will get back to you within one business day.', 'chrisxcreative' ), 'type' => 'textarea' ),
		'cxc_cta_btn_text'      => array( 'label' => __( 'Call-to-action button text', 'chrisxcreative' ), 'default' => __( 'Get In Touch', 'chrisxcreative' ), 'type' => 'text' ),
		'cxc_cta_btn_url'       => array( 'label' => __( 'Call-to-action button link', 'chrisxcreative' ), 'default' => '#contact', 'type' => 'url' ),
	);

	foreach ( $homepage_fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => 'url' === $field['type'] ? 'esc_url_raw' : ( 'textarea' === $field['type'] ? 'wp_kses_post' : 'sanitize_text_field' ),
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $field['label'],
				'section' => 'cxc_homepage',
				'type'    => $field['type'],
			)
		);
	}

	$wp_customize->add_setting(
		'cxc_hero_image',
		array(
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'cxc_hero_image',
			array(
				'label'   => __( 'Hero image', 'chrisxcreative' ),
				'section' => 'cxc_homepage',
				'mime_type' => 'image',
			)
		)
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		$wp_customize->add_setting(
			"cxc_hero_stat_number_{$i}",
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"cxc_hero_stat_number_{$i}",
			array(
				/* translators: %d: stat number */
				'label'   => sprintf( __( 'Hero stat #%d — number', 'chrisxcreative' ), $i ),
				'section' => 'cxc_homepage',
				'type'    => 'text',
			)
		);
		$wp_customize->add_setting(
			"cxc_hero_stat_label_{$i}",
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"cxc_hero_stat_label_{$i}",
			array(
				/* translators: %d: stat number */
				'label'   => sprintf( __( 'Hero stat #%d — label', 'chrisxcreative' ), $i ),
				'section' => 'cxc_homepage',
				'type'    => 'text',
			)
		);
	}

	/* ---------------------------------------------------------------
	 * Footer
	 * ------------------------------------------------------------- */
	$wp_customize->add_section(
		'cxc_footer',
		array(
			'title' => __( 'Footer', 'chrisxcreative' ),
			'panel' => 'cxc_theme_options',
		)
	);

	$wp_customize->add_setting(
		'cxc_footer_columns',
		array(
			'default'           => '4',
			'sanitize_callback' => 'cxc_sanitize_footer_columns',
		)
	);
	$wp_customize->add_control(
		'cxc_footer_columns',
		array(
			'label'   => __( 'Footer widget columns', 'chrisxcreative' ),
			'section' => 'cxc_footer',
			'type'    => 'select',
			'choices' => array(
				'1' => __( '1 Column', 'chrisxcreative' ),
				'2' => __( '2 Columns', 'chrisxcreative' ),
				'3' => __( '3 Columns', 'chrisxcreative' ),
				'4' => __( '4 Columns', 'chrisxcreative' ),
			),
		)
	);

	$wp_customize->add_setting(
		'cxc_footer_text',
		array(
			'default'           => __( '&copy; {year} {site_name}. All rights reserved.', 'chrisxcreative' ),
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'cxc_footer_text',
		array(
			'label'       => __( 'Copyright text', 'chrisxcreative' ),
			'description' => __( 'You can use {year} and {site_name} as placeholders.', 'chrisxcreative' ),
			'section'     => 'cxc_footer',
			'type'        => 'text',
		)
	);

	/* ---------------------------------------------------------------
	 * Social Links
	 * ------------------------------------------------------------- */
	$wp_customize->add_section(
		'cxc_social',
		array(
			'title' => __( 'Social Links', 'chrisxcreative' ),
			'panel' => 'cxc_theme_options',
		)
	);

	$networks = array(
		'facebook'  => 'Facebook',
		'twitter'   => 'X / Twitter',
		'instagram' => 'Instagram',
		'linkedin'  => 'LinkedIn',
		'youtube'   => 'YouTube',
		'tiktok'    => 'TikTok',
		'dribbble'  => 'Dribbble',
		'behance'   => 'Behance',
	);

	foreach ( $networks as $key => $label ) {
		$wp_customize->add_setting(
			"cxc_social_{$key}",
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"cxc_social_{$key}",
			array(
				/* translators: %s: social network name */
				'label'   => sprintf( __( '%s URL', 'chrisxcreative' ), $label ),
				'section' => 'cxc_social',
				'type'    => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'cxc_customize_register' );

/**
 * Sanitize a checkbox value.
 *
 * @param string $input Raw value.
 * @return string
 */
function cxc_sanitize_checkbox( $input ) {
	return ( 'on' === $input ) ? 'on' : 'off';
}

/**
 * Sanitize the footer columns select.
 *
 * @param string $input Raw value.
 * @return string
 */
function cxc_sanitize_footer_columns( $input ) {
	return in_array( $input, array( '1', '2', '3', '4' ), true ) ? $input : '4';
}

/**
 * Output Customizer settings as CSS custom properties + small inline overrides.
 */
function cxc_customizer_css() {
	$primary   = get_theme_mod( 'cxc_color_primary', '#5b3df0' );
	$secondary = get_theme_mod( 'cxc_color_secondary', '#00c2a8' );
	$accent    = get_theme_mod( 'cxc_color_accent', '#ff5d73' );
	?>
	<style id="cxc-customizer-css">
		:root{
			--cxc-primary: <?php echo esc_html( $primary ); ?>;
			--cxc-secondary: <?php echo esc_html( $secondary ); ?>;
			--cxc-accent: <?php echo esc_html( $accent ); ?>;
			--cxc-gradient: linear-gradient(120deg, <?php echo esc_html( $primary ); ?> 0%, <?php echo esc_html( $secondary ); ?> 100%);
			--cxc-gradient-accent: linear-gradient(120deg, <?php echo esc_html( $primary ); ?> 0%, <?php echo esc_html( $accent ); ?> 100%);
		}
	</style>
	<?php
}
add_action( 'wp_head', 'cxc_customizer_css', 20 );

/**
 * Enqueue the live-preview JS handling postMessage updates in the Customizer.
 */
function cxc_customize_preview_js() {
	wp_enqueue_script( 'chrisxcreative-customizer', CXC_URI . '/assets/js/customizer-preview.js', array( 'customize-preview' ), CXC_VERSION, true );
}
add_action( 'customize_preview_init', 'cxc_customize_preview_js' );
