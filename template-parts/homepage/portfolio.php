<?php
/**
 * Homepage portfolio grid with client-side category filtering.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cxc_portfolio = cxc_get_homepage_posts( 'cxc_portfolio', 8 );
if ( empty( $cxc_portfolio ) ) {
	return;
}

$cxc_cats = get_terms(
	array(
		'taxonomy'   => 'cxc_portfolio_category',
		'hide_empty' => true,
	)
);
?>
<section class="cxc-section cxc-section-alt" id="portfolio">
	<div class="cxc-container">
		<div class="cxc-section-header">
			<p class="eyebrow" style="justify-content:center;"><?php esc_html_e( 'Our Work', 'chrisxcreative' ); ?></p>
			<h2><?php esc_html_e( 'Recent projects we are proud of', 'chrisxcreative' ); ?></h2>
			<p class="lead"><?php esc_html_e( 'A selection of brands, products and experiences we have helped bring to life.', 'chrisxcreative' ); ?></p>
		</div>

		<?php if ( ! is_wp_error( $cxc_cats ) && count( $cxc_cats ) > 1 ) : ?>
			<div class="cxc-portfolio-filters" data-cxc-portfolio-filters>
				<button type="button" class="is-active" data-filter="*"><?php esc_html_e( 'All', 'chrisxcreative' ); ?></button>
				<?php foreach ( $cxc_cats as $cxc_cat ) : ?>
					<button type="button" data-filter="<?php echo esc_attr( $cxc_cat->slug ); ?>"><?php echo esc_html( $cxc_cat->name ); ?></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="cxc-grid grid-4" data-cxc-portfolio-grid>
			<?php
			global $post;
			foreach ( $cxc_portfolio as $post ) :
				setup_postdata( $post );
				get_template_part( 'template-parts/cards/portfolio-card' );
			endforeach;
			wp_reset_postdata();
			?>
		</div>

		<div class="text-center" style="margin-top:48px;">
			<a class="btn btn-outline" href="<?php echo esc_url( get_post_type_archive_link( 'cxc_portfolio' ) ); ?>"><?php esc_html_e( 'View All Projects', 'chrisxcreative' ); ?></a>
		</div>
	</div>
</section>
