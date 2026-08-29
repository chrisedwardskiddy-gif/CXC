<?php
/**
 * Archive template (categories, tags, dates, custom taxonomies).
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
		<h1><?php the_archive_title(); ?></h1>
		<?php the_archive_description( '<div class="archive-description lead">', '</div>' ); ?>
		<?php cxc_breadcrumbs(); ?>
	</div>
</div>

<div class="has-sidebar">
	<div class="content-area">
		<div id="content" class="site-content">
			<?php if ( have_posts() ) : ?>
				<div class="post-list">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content/content' );
					endwhile;
					?>
				</div>
				<?php cxc_pagination(); ?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content/content-none' ); ?>
			<?php endif; ?>
		</div>

		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
