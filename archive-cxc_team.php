<?php
/**
 * Team archive.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="page-banner">
	<div class="cxc-container">
		<h1><?php esc_html_e( 'Our Team', 'chrisxcreative' ); ?></h1>
		<?php cxc_breadcrumbs(); ?>
	</div>
</div>

<div class="cxc-section">
	<div class="cxc-container">
		<?php if ( have_posts() ) : ?>
			<div class="cxc-grid grid-4">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/cards/team-card' );
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
