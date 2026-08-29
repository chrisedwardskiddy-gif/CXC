<?php
/**
 * Template Name: Contact Page
 * Template Post Type: page
 *
 * Two-column contact layout: info + form on one side, an optional embedded
 * map (paste a Google Maps embed URL as post content, or edit below).
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
		<h1><?php the_title(); ?></h1>
		<?php cxc_breadcrumbs(); ?>
	</div>
</div>

<div class="cxc-section">
	<div class="cxc-container">
		<div class="cxc-grid grid-2" style="align-items:start;">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Get In Touch', 'chrisxcreative' ); ?></p>
				<h2><?php esc_html_e( "Let's talk about your project", 'chrisxcreative' ); ?></h2>

				<?php
				while ( have_posts() ) :
					the_post();
					if ( trim( wp_strip_all_tags( get_the_content() ) ) ) {
						the_content();
					}
				endwhile;
				?>

				<ul class="contact-info-list">
					<?php if ( get_theme_mod( 'cxc_topbar_phone' ) ) : ?>
						<li>
							<span class="icon"><?php cxc_icon( 'phone' ); ?></span>
							<span>
								<strong><?php esc_html_e( 'Phone', 'chrisxcreative' ); ?></strong><br>
								<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', get_theme_mod( 'cxc_topbar_phone' ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'cxc_topbar_phone' ) ); ?></a>
							</span>
						</li>
					<?php endif; ?>
					<?php if ( get_theme_mod( 'cxc_topbar_email' ) ) : ?>
						<li>
							<span class="icon"><?php cxc_icon( 'mail' ); ?></span>
							<span>
								<strong><?php esc_html_e( 'Email', 'chrisxcreative' ); ?></strong><br>
								<a href="mailto:<?php echo esc_attr( get_theme_mod( 'cxc_topbar_email' ) ); ?>"><?php echo esc_html( get_theme_mod( 'cxc_topbar_email' ) ); ?></a>
							</span>
						</li>
					<?php endif; ?>
				</ul>

				<?php cxc_social_links_output( 'footer-social' ); ?>
			</div>

			<div>
				<?php echo cxc_contact_form_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- self-authored, escaped internally. ?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
