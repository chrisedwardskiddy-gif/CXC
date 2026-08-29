<?php
/**
 * 404 error page.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="cxc-container-narrow" style="padding:120px 24px;text-align:center;">
	<p class="eyebrow" style="justify-content:center;"><?php esc_html_e( 'Error 404', 'chrisxcreative' ); ?></p>
	<h1 class="text-gradient" style="font-size:clamp(4rem,10vw,7rem);"><?php esc_html_e( 'Page Not Found', 'chrisxcreative' ); ?></h1>
	<p class="lead"><?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'chrisxcreative' ); ?></p>

	<div class="cxc-hero-actions" style="justify-content:center;">
		<a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Homepage', 'chrisxcreative' ); ?></a>
	</div>

	<div style="max-width:480px;margin:48px auto 0;">
		<?php get_search_form(); ?>
	</div>
</div>

<?php
get_footer();
