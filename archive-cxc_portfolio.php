<?php
/**
 * Portfolio archive, with client-side category filtering.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$cxc_cats = get_terms(
	array(
		'taxonomy'   => 'cxc_portfolio_category',
		'hide_empty' => true,
	)
);
?>

<div class="page-banner">
	<div class="cxc-container">
		<h1><?php esc_html_e( 'Portfolio', 'chrisxcreative' ); ?></h1>
		<?php cxc_breadcrumbs(); ?>
	</div>
</div>

<div class="cxc-section">
	<div class="cxc-container">
		<?php if ( ! is_wp_error( $cxc_cats ) && count( $cxc_cats ) > 1 ) : ?>
			<div class="cxc-portfolio-filters" data-cxc-portfolio-filters>
				<button type="button" class="is-active" data-filter="*"><?php esc_html_e( 'All', 'chrisxcreative' ); ?></button>
				<?php foreach ( $cxc_cats as $cxc_cat ) : ?>
					<button type="button" data-filter="<?php echo esc_attr( $cxc_cat->slug ); ?>"><?php echo esc_html( $cxc_cat->name ); ?></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<div class="cxc-grid grid-4" data-cxc-portfolio-grid>
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/cards/portfolio-card' );
				endwhile;
				?>
			</div>
			<?php cxc_pagination(); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content/content-none' ); ?>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
