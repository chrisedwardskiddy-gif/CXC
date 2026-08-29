<?php
/**
 * The default template: blog posts index.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<?php if ( ! is_front_page() ) : ?>
	<div class="page-banner">
		<div class="cxc-container">
			<h1><?php is_home() ? esc_html_e( 'From the Blog', 'chrisxcreative' ) : the_archive_title(); ?></h1>
			<?php cxc_breadcrumbs(); ?>
		</div>
	</div>
<?php endif; ?>

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
