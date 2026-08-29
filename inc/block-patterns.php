<?php
/**
 * Gutenberg block pattern category & bundled patterns, built entirely from
 * core blocks so clients can build pages without a page-builder plugin.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the pattern category and patterns.
 */
function cxc_register_block_patterns() {
	register_block_pattern_category(
		'chrisxcreative',
		array( 'label' => __( 'ChrisXCreative', 'chrisxcreative' ) )
	);

	$patterns = array(
		'hero-split'      => array(
			'title'   => __( 'Hero — Split with Image', 'chrisxcreative' ),
			'content' => cxc_pattern_hero_split(),
		),
		'cta-band'        => array(
			'title'   => __( 'Call to Action Band', 'chrisxcreative' ),
			'content' => cxc_pattern_cta_band(),
		),
		'services-grid'   => array(
			'title'   => __( 'Services — 3 Column Grid', 'chrisxcreative' ),
			'content' => cxc_pattern_services_grid(),
		),
		'pricing-table'   => array(
			'title'   => __( 'Pricing Table — 3 Plans', 'chrisxcreative' ),
			'content' => cxc_pattern_pricing_table(),
		),
		'faq-accordion'   => array(
			'title'   => __( 'FAQ Accordion', 'chrisxcreative' ),
			'content' => cxc_pattern_faq(),
		),
		'stats-band'      => array(
			'title'   => __( 'Stats / Numbers Band', 'chrisxcreative' ),
			'content' => cxc_pattern_stats(),
		),
		'contact-section' => array(
			'title'   => __( 'Contact Form Section', 'chrisxcreative' ),
			'content' => cxc_pattern_contact(),
		),
	);

	foreach ( $patterns as $slug => $pattern ) {
		register_block_pattern(
			'chrisxcreative/' . $slug,
			array(
				'title'      => $pattern['title'],
				'categories' => array( 'chrisxcreative' ),
				'content'    => $pattern['content'],
			)
		);
	}
}
add_action( 'init', 'cxc_register_block_patterns' );

/**
 * Hero split pattern.
 *
 * @return string
 */
function cxc_pattern_hero_split() {
	return '<!-- wp:group {"className":"cxc-hero","layout":{"type":"constrained"}} -->
	<div class="wp-block-group cxc-hero"><!-- wp:columns {"verticalAlignment":"center"} -->
	<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
	<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"eyebrow"} -->
	<p class="eyebrow">' . esc_html__( 'Welcome', 'chrisxcreative' ) . '</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1} -->
	<h1 class="wp-block-heading">' . esc_html__( 'A headline that tells visitors exactly what you do', 'chrisxcreative' ) . '</h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"className":"lead"} -->
	<p class="lead">' . esc_html__( 'Add a short, benefit-led sentence here that supports the headline above and invites people to keep reading.', 'chrisxcreative' ) . '</p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons"><!-- wp:button -->
	<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Get Started', 'chrisxcreative' ) . '</a></div>
	<!-- /wp:button -->

	<!-- wp:button {"className":"is-style-outline"} -->
	<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Learn More', 'chrisxcreative' ) . '</a></div>
	<!-- /wp:button --></div>
	<!-- /wp:buttons --></div>
	<!-- /wp:column -->

	<!-- wp:column {"verticalAlignment":"center"} -->
	<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"sizeSlug":"large","className":"reveal"} -->
	<figure class="wp-block-image size-large reveal"><img src="' . esc_url( CXC_URI . '/assets/images/placeholder-hero.svg' ) . '" alt="" /></figure>
	<!-- /wp:image --></div>
	<!-- /wp:column --></div>
	<!-- /wp:columns --></div>
	<!-- /wp:group -->';
}

/**
 * CTA band pattern.
 *
 * @return string
 */
function cxc_pattern_cta_band() {
	return '<!-- wp:group {"className":"cxc-section","layout":{"type":"constrained"}} -->
	<div class="wp-block-group cxc-section"><!-- wp:group {"className":"cxc-cta","layout":{"type":"constrained"}} -->
	<div class="wp-block-group cxc-cta"><!-- wp:heading {"textAlign":"center","level":2} -->
	<h2 class="wp-block-heading has-text-align-center">' . esc_html__( "Ready to start your next project?", 'chrisxcreative' ) . '</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center"} -->
	<p class="has-text-align-center">' . esc_html__( 'Tell us about your goals and we will get back to you within one business day.', 'chrisxcreative' ) . '</p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons"><!-- wp:button -->
	<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Contact Us', 'chrisxcreative' ) . '</a></div>
	<!-- /wp:button --></div>
	<!-- /wp:buttons --></div>
	<!-- /wp:group --></div>
	<!-- /wp:group -->';
}

/**
 * Services grid pattern (3 columns, reusable for any icon-box content).
 *
 * @return string
 */
function cxc_pattern_services_grid() {
	$card = static function ( $title, $text ) {
		return '<!-- wp:column -->
		<div class="wp-block-column"><!-- wp:group {"className":"cxc-card service-card","layout":{"type":"constrained"}} -->
		<div class="wp-block-group cxc-card service-card"><!-- wp:heading {"level":3} -->
		<h3 class="wp-block-heading">' . esc_html( $title ) . '</h3>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"className":"text-muted"} -->
		<p class="text-muted">' . esc_html( $text ) . '</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group --></div>
		<!-- /wp:column -->';
	};

	return '<!-- wp:group {"className":"cxc-section","layout":{"type":"constrained"}} -->
	<div class="wp-block-group cxc-section"><!-- wp:heading {"textAlign":"center","level":2} -->
	<h2 class="wp-block-heading has-text-align-center">' . esc_html__( 'What we offer', 'chrisxcreative' ) . '</h2>
	<!-- /wp:heading -->

	<!-- wp:columns -->
	<div class="wp-block-columns">'
	. $card( __( 'Strategy', 'chrisxcreative' ), __( 'Research, positioning and a roadmap built around measurable outcomes.', 'chrisxcreative' ) )
	. $card( __( 'Design', 'chrisxcreative' ), __( 'Modern, accessible interfaces that make your brand memorable.', 'chrisxcreative' ) )
	. $card( __( 'Development', 'chrisxcreative' ), __( 'Fast, secure builds on WordPress engineered to scale with you.', 'chrisxcreative' ) ) .
	'</div>
	<!-- /wp:columns --></div>
	<!-- /wp:group -->';
}

/**
 * Pricing table pattern.
 *
 * @return string
 */
function cxc_pattern_pricing_table() {
	$plan = static function ( $name, $price, $features, $featured = false ) {
		$class = 'pricing-card' . ( $featured ? ' is-featured' : '' );
		$items = '';
		foreach ( $features as $feature ) {
			$items .= '<!-- wp:list-item --><li>' . esc_html( $feature ) . '</li><!-- /wp:list-item -->';
		}
		return '<!-- wp:column -->
		<div class="wp-block-column"><!-- wp:group {"className":"' . esc_attr( $class ) . '","layout":{"type":"constrained"}} -->
		<div class="wp-block-group ' . esc_attr( $class ) . '"><!-- wp:heading {"level":3,"textAlign":"center"} -->
		<h3 class="wp-block-heading has-text-align-center">' . esc_html( $name ) . '</h3>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","className":"price"} -->
		<p class="has-text-align-center price">' . esc_html( $price ) . '</p>
		<!-- /wp:paragraph -->

		<!-- wp:list -->
		<ul>' . $items . '</ul>
		<!-- /wp:list -->

		<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Choose Plan', 'chrisxcreative' ) . '</a></div>
		<!-- /wp:button --></div>
		<!-- /wp:buttons --></div>
		<!-- /wp:group --></div>
		<!-- /wp:column -->';
	};

	return '<!-- wp:group {"className":"cxc-section cxc-section-alt","layout":{"type":"constrained"}} -->
	<div class="wp-block-group cxc-section cxc-section-alt"><!-- wp:heading {"textAlign":"center","level":2} -->
	<h2 class="wp-block-heading has-text-align-center">' . esc_html__( 'Simple, transparent pricing', 'chrisxcreative' ) . '</h2>
	<!-- /wp:heading -->

	<!-- wp:columns -->
	<div class="wp-block-columns">'
	. $plan( __( 'Starter', 'chrisxcreative' ), '£999', array( __( '5 page website', 'chrisxcreative' ), __( 'Basic SEO setup', 'chrisxcreative' ), __( '2 weeks delivery', 'chrisxcreative' ) ) )
	. $plan( __( 'Growth', 'chrisxcreative' ), '£2,499', array( __( '10 page website', 'chrisxcreative' ), __( 'Custom design system', 'chrisxcreative' ), __( 'Blog & portfolio setup', 'chrisxcreative' ) ), true )
	. $plan( __( 'Enterprise', 'chrisxcreative' ), 'POA', array( __( 'Unlimited pages', 'chrisxcreative' ), __( 'Bespoke integrations', 'chrisxcreative' ), __( 'Dedicated support', 'chrisxcreative' ) ) ) .
	'</div>
	<!-- /wp:columns --></div>
	<!-- /wp:group -->';
}

/**
 * FAQ accordion pattern, using the native core/details block.
 *
 * @return string
 */
function cxc_pattern_faq() {
	$faqs = array(
		array( __( 'How long does a typical project take?', 'chrisxcreative' ), __( 'Most websites take between two and six weeks depending on scope, from discovery through to launch.', 'chrisxcreative' ) ),
		array( __( 'Do you provide hosting?', 'chrisxcreative' ), __( 'Yes — every ChrisXCreative site includes fast, secure managed hosting so you never have to think about it.', 'chrisxcreative' ) ),
		array( __( 'Can I edit the site myself afterwards?', 'chrisxcreative' ), __( 'Absolutely. The theme was built specifically to be easy to manage from the WordPress dashboard.', 'chrisxcreative' ) ),
	);

	$blocks = '';
	foreach ( $faqs as $faq ) {
		list( $question, $answer ) = $faq;
		$blocks .= '<!-- wp:details {"className":"cxc-faq-item"} -->
		<details class="wp-block-details cxc-faq-item"><summary>' . esc_html( $question ) . '</summary><!-- wp:paragraph -->
		<p>' . esc_html( $answer ) . '</p>
		<!-- /wp:paragraph --></details>
		<!-- /wp:details -->';
	}

	return '<!-- wp:group {"className":"cxc-section cxc-container-narrow","layout":{"type":"constrained"}} -->
	<div class="wp-block-group cxc-section cxc-container-narrow"><!-- wp:heading {"textAlign":"center","level":2} -->
	<h2 class="wp-block-heading has-text-align-center">' . esc_html__( 'Frequently asked questions', 'chrisxcreative' ) . '</h2>
	<!-- /wp:heading -->' . $blocks . '</div>
	<!-- /wp:group -->';
}

/**
 * Stats band pattern.
 *
 * @return string
 */
function cxc_pattern_stats() {
	$stat = static function ( $number, $label ) {
		return '<!-- wp:column -->
		<div class="wp-block-column" style="text-align:center"><!-- wp:heading {"level":3,"textAlign":"center","className":"text-gradient"} -->
		<h3 class="wp-block-heading has-text-align-center text-gradient">' . esc_html( $number ) . '</h3>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","className":"text-muted"} -->
		<p class="has-text-align-center text-muted">' . esc_html( $label ) . '</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:column -->';
	};

	return '<!-- wp:group {"className":"cxc-section","layout":{"type":"constrained"}} -->
	<div class="wp-block-group cxc-section"><!-- wp:columns -->
	<div class="wp-block-columns">'
	. $stat( '250+', __( 'Projects Delivered', 'chrisxcreative' ) )
	. $stat( '98%', __( 'Client Satisfaction', 'chrisxcreative' ) )
	. $stat( '12', __( 'Years Experience', 'chrisxcreative' ) )
	. $stat( '4.9/5', __( 'Average Rating', 'chrisxcreative' ) ) .
	'</div>
	<!-- /wp:columns --></div>
	<!-- /wp:group -->';
}

/**
 * Contact section pattern (drops in the theme's built-in AJAX form).
 *
 * @return string
 */
function cxc_pattern_contact() {
	return '<!-- wp:group {"className":"cxc-section cxc-container-narrow","layout":{"type":"constrained"}} -->
	<div class="wp-block-group cxc-section cxc-container-narrow"><!-- wp:heading {"textAlign":"center","level":2} -->
	<h2 class="wp-block-heading has-text-align-center">' . esc_html__( "Let's work together", 'chrisxcreative' ) . '</h2>
	<!-- /wp:heading -->

	<!-- wp:shortcode -->
	[cxc_contact_form]
	<!-- /wp:shortcode --></div>
	<!-- /wp:group -->';
}
