<?php
/**
 * Homepage hero section, content controlled via the Customizer.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cxc_hero_image_id = get_theme_mod( 'cxc_hero_image' );
$cxc_has_image      = $cxc_hero_image_id && wp_get_attachment_image_src( $cxc_hero_image_id, 'large' );
?>
<section class="cxc-hero<?php echo $cxc_has_image ? '' : ' hero-center'; ?>">
	<div class="cxc-container">
		<div class="cxc-hero-content">
			<?php if ( get_theme_mod( 'cxc_hero_eyebrow' ) ) : ?>
				<p class="eyebrow"><?php echo esc_html( get_theme_mod( 'cxc_hero_eyebrow' ) ); ?></p>
			<?php endif; ?>

			<h1><?php echo wp_kses_post( get_theme_mod( 'cxc_hero_heading', __( 'We design and build brands people remember.', 'chrisxcreative' ) ) ); ?></h1>

			<p class="lead"><?php echo wp_kses_post( get_theme_mod( 'cxc_hero_subheading' ) ); ?></p>

			<div class="cxc-hero-actions">
				<?php if ( get_theme_mod( 'cxc_hero_btn_text' ) ) : ?>
					<a class="btn" href="<?php echo esc_url( get_theme_mod( 'cxc_hero_btn_url', '#' ) ); ?>"><?php echo esc_html( get_theme_mod( 'cxc_hero_btn_text' ) ); ?></a>
				<?php endif; ?>
				<?php if ( get_theme_mod( 'cxc_hero_btn2_text' ) ) : ?>
					<a class="btn btn-outline" href="<?php echo esc_url( get_theme_mod( 'cxc_hero_btn2_url', '#' ) ); ?>"><?php echo esc_html( get_theme_mod( 'cxc_hero_btn2_text' ) ); ?></a>
				<?php endif; ?>
			</div>

			<?php
			$cxc_has_stats = get_theme_mod( 'cxc_hero_stat_number_1' ) || get_theme_mod( 'cxc_hero_stat_number_2' ) || get_theme_mod( 'cxc_hero_stat_number_3' );
			if ( $cxc_has_stats ) :
				?>
				<div class="cxc-hero-stats">
					<?php for ( $cxc_i = 1; $cxc_i <= 3; $cxc_i++ ) : ?>
						<?php if ( get_theme_mod( "cxc_hero_stat_number_{$cxc_i}" ) ) : ?>
							<div>
								<strong><?php echo esc_html( get_theme_mod( "cxc_hero_stat_number_{$cxc_i}" ) ); ?></strong>
								<span><?php echo esc_html( get_theme_mod( "cxc_hero_stat_label_{$cxc_i}" ) ); ?></span>
							</div>
						<?php endif; ?>
					<?php endfor; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $cxc_has_image ) : ?>
			<div class="cxc-hero-media reveal">
				<?php echo wp_get_attachment_image( $cxc_hero_image_id, 'large', false, array( 'loading' => 'eager', 'fetchpriority' => 'high' ) ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
