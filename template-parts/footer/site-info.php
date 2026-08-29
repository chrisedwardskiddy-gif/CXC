<?php
/**
 * Bottom bar: copyright text, legal menu and the ChrisXCreative credit.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="site-info">
	<div class="cxc-container">
		<div class="site-info-copyright">
			<?php cxc_footer_text(); ?>
			&nbsp;&mdash;&nbsp;<?php cxc_site_credit(); ?>
		</div>

		<?php if ( has_nav_menu( 'legal' ) ) : ?>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'legal',
					'container'      => false,
					'menu_class'     => 'footer-legal-menu',
					'depth'          => 1,
					'fallback_cb'    => false,
				)
			);
			?>
		<?php endif; ?>
	</div>
</div>
