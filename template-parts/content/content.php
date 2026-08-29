<?php
/**
 * Post card used on the blog index / archives / search results.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="post-thumb">
			<?php the_post_thumbnail( 'cxc-blog-list' ); ?>
		</a>
	<?php endif; ?>

	<div class="post-card-body">
		<div class="post-meta">
			<?php cxc_posted_on(); ?>
		</div>
		<?php
		$categories = get_the_category_list( ', ' );
		if ( $categories ) {
			echo '<div class="cat-badges">' . wp_kses_post( $categories ) . '</div>';
		}
		?>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>
		<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline"><?php esc_html_e( 'Read More', 'chrisxcreative' ); ?></a>
	</div>
</article>
