<?php
/**
 * Default page template.
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
	<div class="has-sidebar<?php echo comments_open() ? '' : ' no-sidebar'; ?>">
		<div class="content-area cxc-container-narrow" style="display:block;">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/content-page' );

				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			endwhile;
			?>
		</div>
	</div>
</div>

<?php
get_footer();
