<?php
/**
 * Homepage testimonials carousel.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cxc_testimonials = cxc_get_homepage_posts( 'cxc_testimonial', 9 );
if ( empty( $cxc_testimonials ) ) {
	return;
}
?>
<section class="cxc-section">
	<div class="cxc-container">
		<div class="cxc-section-header">
			<p class="eyebrow" style="justify-content:center;"><?php esc_html_e( 'Testimonials', 'chrisxcreative' ); ?></p>
			<h2><?php esc_html_e( 'Trusted by ambitious teams', 'chrisxcreative' ); ?></h2>
		</div>

		<div class="cxc-testimonial-track" data-cxc-testimonial-track>
			<?php
			global $post;
			foreach ( $cxc_testimonials as $post ) :
				setup_postdata( $post );
				get_template_part( 'template-parts/cards/testimonial-card' );
			endforeach;
			wp_reset_postdata();
			?>
		</div>

		<?php if ( count( $cxc_testimonials ) > 2 ) : ?>
			<div class="cxc-testimonial-nav">
				<button type="button" data-cxc-testimonial-prev aria-label="<?php esc_attr_e( 'Previous testimonial', 'chrisxcreative' ); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</button>
				<button type="button" data-cxc-testimonial-next aria-label="<?php esc_attr_e( 'Next testimonial', 'chrisxcreative' ); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</button>
			</div>
		<?php endif; ?>
	</div>
</section>
