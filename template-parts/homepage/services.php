<?php
/**
 * Homepage services grid, pulled from the Services custom post type.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cxc_services = cxc_get_homepage_posts( 'cxc_service', 6 );
if ( empty( $cxc_services ) ) {
	return;
}
?>
<section class="cxc-section" id="services">
	<div class="cxc-container">
		<div class="cxc-section-header">
			<p class="eyebrow" style="justify-content:center;"><?php esc_html_e( 'What We Do', 'chrisxcreative' ); ?></p>
			<h2><?php esc_html_e( 'Services built around your goals', 'chrisxcreative' ); ?></h2>
			<p class="lead"><?php esc_html_e( 'From strategy to launch, everything you need under one roof.', 'chrisxcreative' ); ?></p>
		</div>

		<div class="cxc-grid grid-3">
			<?php
			global $post;
			foreach ( $cxc_services as $post ) :
				setup_postdata( $post );
				get_template_part( 'template-parts/cards/service-card' );
			endforeach;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
