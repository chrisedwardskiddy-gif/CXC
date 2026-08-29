<?php
/**
 * Homepage call-to-action band.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! get_theme_mod( 'cxc_cta_heading' ) ) {
	return;
}
?>
<section class="cxc-section" id="contact">
	<div class="cxc-container">
		<div class="cxc-cta reveal">
			<h2><?php echo esc_html( get_theme_mod( 'cxc_cta_heading' ) ); ?></h2>
			<p class="lead"><?php echo esc_html( get_theme_mod( 'cxc_cta_text' ) ); ?></p>
			<?php if ( get_theme_mod( 'cxc_cta_btn_text' ) ) : ?>
				<a class="btn" href="<?php echo esc_url( get_theme_mod( 'cxc_cta_btn_url', '#' ) ); ?>"><?php echo esc_html( get_theme_mod( 'cxc_cta_btn_text' ) ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
