<?php
/**
 * Single post template.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>
		<header class="entry-header">
			<?php
			$categories = get_the_category_list( ', ' );
			if ( $categories ) {
				echo '<div class="cat-badges" style="justify-content:center;">' . wp_kses_post( $categories ) . '</div>';
			}
			?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="post-meta" style="justify-content:center;">
				<?php cxc_posted_on(); ?>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="entry-thumb">
				<?php the_post_thumbnail( 'large' ); ?>
			</div>
		<?php endif; ?>

		<div class="entry-content">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'chrisxcreative' ),
					'after'  => '</div>',
				)
			);
			?>

			<?php cxc_entry_footer(); ?>

			<?php
			$author_bio = get_the_author_meta( 'description' );
			if ( $author_bio ) :
				?>
				<div class="author-box">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
					<div>
						<h3 style="margin-bottom:.2em;"><?php the_author(); ?></h3>
						<p class="text-muted" style="margin-bottom:0;"><?php echo esc_html( $author_bio ); ?></p>
					</div>
				</div>
			<?php endif; ?>

			<nav class="post-nav" aria-label="<?php esc_attr_e( 'Post navigation', 'chrisxcreative' ); ?>">
				<div class="post-nav-prev">
					<?php
					$prev = get_previous_post();
					if ( $prev ) :
						?>
						<span><?php esc_html_e( 'Previous', 'chrisxcreative' ); ?></span>
						<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>"><?php echo esc_html( get_the_title( $prev ) ); ?></a>
					<?php endif; ?>
				</div>
				<div class="post-nav-next" style="text-align:right;">
					<?php
					$next = get_next_post();
					if ( $next ) :
						?>
						<span><?php esc_html_e( 'Next', 'chrisxcreative' ); ?></span>
						<a href="<?php echo esc_url( get_permalink( $next ) ); ?>"><?php echo esc_html( get_the_title( $next ) ); ?></a>
					<?php endif; ?>
				</div>
			</nav>
		</div>
	</article>

	<?php if ( comments_open() || get_comments_number() ) : ?>
		<?php comments_template(); ?>
	<?php endif; ?>

	<?php
endwhile;

get_footer();
