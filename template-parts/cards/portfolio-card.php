<?php
/**
 * Single portfolio card. Expects the loop to be set up (global $post).
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cxc_terms   = get_the_terms( get_the_ID(), 'cxc_portfolio_category' );
$cxc_cat     = ( $cxc_terms && ! is_wp_error( $cxc_terms ) ) ? $cxc_terms[0]->name : '';
$cxc_slugs   = array();
if ( $cxc_terms && ! is_wp_error( $cxc_terms ) ) {
	foreach ( $cxc_terms as $cxc_term ) {
		$cxc_slugs[] = $cxc_term->slug;
	}
}
?>
<div class="portfolio-item reveal" data-category="<?php echo esc_attr( implode( ' ', $cxc_slugs ) ); ?>">
	<a href="<?php the_permalink(); ?>" class="portfolio-card cxc-card" style="padding:0;">
		<div class="portfolio-thumb">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'cxc-portfolio-thumb' );
			} else {
				echo '<div style="width:100%;height:100%;background:var(--cxc-gradient);"></div>';
			}
			?>
			<div class="portfolio-overlay">
				<?php if ( $cxc_cat ) : ?>
					<span class="portfolio-cat"><?php echo esc_html( $cxc_cat ); ?></span>
				<?php endif; ?>
				<h3><?php the_title(); ?></h3>
			</div>
		</div>
	</a>
</div>
