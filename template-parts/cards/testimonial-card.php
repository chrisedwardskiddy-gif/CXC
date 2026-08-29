<?php
/**
 * Single testimonial card. Expects the loop to be set up (global $post).
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cxc_author_name = get_post_meta( get_the_ID(), '_cxc_author_name', true );
$cxc_author_role = get_post_meta( get_the_ID(), '_cxc_author_role', true );
$cxc_rating      = get_post_meta( get_the_ID(), '_cxc_rating', true );
?>
<div class="cxc-card testimonial-card reveal">
	<?php cxc_star_rating( $cxc_rating ? $cxc_rating : 5 ); ?>
	<div class="quote">
		<?php cxc_icon( 'quote' ); ?>
		<?php the_content(); ?>
	</div>
	<div class="testimonial-author">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'thumbnail' ); ?>
		<?php else : ?>
			<?php echo get_avatar( get_the_ID(), 52, '', '', array( 'default' => 'mystery' ) ); ?>
		<?php endif; ?>
		<div>
			<strong><?php echo esc_html( $cxc_author_name ? $cxc_author_name : get_the_title() ); ?></strong>
			<?php if ( $cxc_author_role ) : ?>
				<span><?php echo esc_html( $cxc_author_role ); ?></span>
			<?php endif; ?>
		</div>
	</div>
</div>
