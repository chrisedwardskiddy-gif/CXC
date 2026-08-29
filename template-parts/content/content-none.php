<?php
/**
 * Shown when no posts match the current query.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="no-results not-found cxc-container-narrow" style="padding:80px 24px;text-align:center;">
	<h1><?php esc_html_e( 'Nothing found', 'chrisxcreative' ); ?></h1>

	<?php if ( is_search() ) : ?>
		<p><?php esc_html_e( 'Sorry, nothing matched your search. Try again with some different keywords.', 'chrisxcreative' ); ?></p>
		<?php get_search_form(); ?>
	<?php elseif ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
		<p>
			<?php
			printf(
				wp_kses(
					/* translators: 1: link to new post */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'chrisxcreative' ),
					array( 'a' => array( 'href' => true ) )
				),
				esc_url( admin_url( 'post-new.php' ) )
			);
			?>
		</p>
	<?php else : ?>
		<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'chrisxcreative' ); ?></p>
		<a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Homepage', 'chrisxcreative' ); ?></a>
	<?php endif; ?>
</section>
