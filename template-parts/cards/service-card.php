<?php
/**
 * Single service card. Expects the loop to be set up (global $post).
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cxc_icon_class = get_post_meta( get_the_ID(), '_cxc_icon', true );
?>
<div class="cxc-card service-card reveal">
	<div class="service-icon">
		<?php if ( $cxc_icon_class ) : ?>
			<span class="dashicons <?php echo esc_attr( $cxc_icon_class ); ?>" aria-hidden="true"></span>
		<?php else : ?>
			<?php cxc_icon( 'arrow' ); ?>
		<?php endif; ?>
	</div>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<div class="text-muted"><?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), 18 ) ); ?></div>
	<a class="service-link" href="<?php the_permalink(); ?>">
		<?php esc_html_e( 'Learn More', 'chrisxcreative' ); ?>
		<?php cxc_icon( 'arrow' ); ?>
	</a>
</div>
