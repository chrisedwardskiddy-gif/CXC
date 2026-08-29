<?php
/**
 * Template Name: Full Width (No Sidebar)
 * Template Post Type: page
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<?php if ( ! has_post_thumbnail() ) : ?>
	<div class="page-banner">
		<div class="cxc-container">
			<h1><?php the_title(); ?></h1>
			<?php cxc_breadcrumbs(); ?>
		</div>
	</div>
<?php endif; ?>

<div class="cxc-content-wrap">
	<div class="cxc-container">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</div>
</div>

<?php
get_footer();
