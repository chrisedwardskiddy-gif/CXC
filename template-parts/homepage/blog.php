<?php
/**
 * Homepage "from the blog" preview.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cxc_posts = get_posts(
	array(
		'posts_per_page' => 3,
		'no_found_rows'  => true,
		'ignore_sticky_posts' => true,
	)
);
if ( empty( $cxc_posts ) ) {
	return;
}
?>
<section class="cxc-section cxc-section-alt">
	<div class="cxc-container">
		<div class="cxc-section-header">
			<p class="eyebrow" style="justify-content:center;"><?php esc_html_e( 'Insights', 'chrisxcreative' ); ?></p>
			<h2><?php esc_html_e( 'Latest from the blog', 'chrisxcreative' ); ?></h2>
		</div>

		<div class="cxc-grid grid-3">
			<?php
			global $post;
			foreach ( $cxc_posts as $post ) :
				setup_postdata( $post );
				?>
				<div class="cxc-card reveal" style="overflow:hidden;">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" style="display:block;aspect-ratio:4/3;overflow:hidden;">
							<?php the_post_thumbnail( 'cxc-blog-thumb', array( 'style' => 'width:100%;height:100%;object-fit:cover;' ) ); ?>
						</a>
					<?php endif; ?>
					<div style="padding:26px;">
						<div class="post-meta"><?php echo esc_html( get_the_date() ); ?></div>
						<h3 style="font-size:1.15rem;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p class="text-muted"><?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), 14 ) ); ?></p>
					</div>
				</div>
				<?php
			endforeach;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
