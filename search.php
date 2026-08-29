<?php
/**
 * Search results template.
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
		<h1>
			<?php
			printf(
				/* translators: %s: search query */
				esc_html__( 'Search Results for: %s', 'chrisxcreative' ),
				'<span>' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>
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
