<?php
/**
 * Template Name: Landing Page (Blank Canvas)
 * Template Post Type: page
 *
 * A minimal wrapper with no header/footer chrome, ideal for campaign
 * landing pages built entirely with block patterns.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'cxc-landing-page' ); ?>>
<?php wp_body_open(); ?>

<main id="primary">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
</main>

<div class="site-info" style="background:var(--cxc-heading);">
	<div class="cxc-container">
		<div class="site-info-copyright" style="color:#c4c6d6;">
			<?php cxc_footer_text(); ?>
			&nbsp;&mdash;&nbsp;<?php cxc_site_credit(); ?>
		</div>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
