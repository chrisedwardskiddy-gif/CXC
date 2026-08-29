<?php
/**
 * Single service page.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$cxc_icon_class = get_post_meta( get_the_ID(), '_cxc_icon', true );
	?>
	<div class="page-banner">
		<div class="cxc-container">
			<?php if ( $cxc_icon_class ) : ?>
				<div class="service-icon" style="margin:0 auto 20px;"><span class="dashicons <?php echo esc_attr( $cxc_icon_class ); ?>" aria-hidden="true"></span></div>
			<?php endif; ?>
			<h1><?php the_title(); ?></h1>
			<?php cxc_breadcrumbs(); ?>
		</div>
	</div>

	<div class="cxc-content-wrap">
		<div class="cxc-container-narrow">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-thumb alignwide"><?php the_post_thumbnail( 'large' ); ?></div>
			<?php endif; ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</div>
	</div>

	<?php get_template_part( 'template-parts/homepage/cta' ); ?>

	<?php
endwhile;

get_footer();
