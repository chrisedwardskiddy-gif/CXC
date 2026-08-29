<?php
/**
 * Front page template.
 *
 * If a static front page has been chosen in Settings > Reading and that
 * page actually has content, we respect it (so page builders / block
 * patterns / Gutenberg content the client added always wins). Otherwise we
 * render the built-in marketing homepage, powered by the Customizer and the
 * Portfolio / Services / Testimonials custom post types, so the site looks
 * complete the moment the theme is activated.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cxc_static_front = ( 'page' === get_option( 'show_on_front' ) ) ? get_post( get_option( 'page_on_front' ) ) : null;

get_header();

if ( $cxc_static_front && ! empty( trim( wp_strip_all_tags( $cxc_static_front->post_content ) ) ) ) :
	?>
	<div class="cxc-content-wrap">
		<div class="cxc-container-narrow">
			<?php
			global $post;
			$post = $cxc_static_front; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			setup_postdata( $post );
			get_template_part( 'template-parts/content/content-page' );
			wp_reset_postdata();
			?>
		</div>
	</div>
	<?php
else :
	get_template_part( 'template-parts/homepage/hero' );
	get_template_part( 'template-parts/homepage/services' );
	get_template_part( 'template-parts/homepage/portfolio' );
	get_template_part( 'template-parts/homepage/testimonials' );
	get_template_part( 'template-parts/homepage/team' );
	get_template_part( 'template-parts/homepage/blog' );
	get_template_part( 'template-parts/homepage/cta' );
endif;

get_footer();
