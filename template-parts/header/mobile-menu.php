<?php
/**
 * Off-canvas mobile menu.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="cxc-mobile-backdrop" data-cxc-mobile-backdrop></div>
<div id="cxc-mobile-menu" class="cxc-mobile-menu" aria-hidden="true">
	<div class="cxc-mobile-menu-header">
		<span class="site-title"><?php bloginfo( 'name' ); ?></span>
		<button type="button" class="cxc-menu-toggle" data-cxc-mobile-close aria-label="<?php esc_attr_e( 'Close menu', 'chrisxcreative' ); ?>">
			<?php cxc_icon( 'close' ); ?>
		</button>
	</div>

	<nav aria-label="<?php esc_attr_e( 'Mobile menu', 'chrisxcreative' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => has_nav_menu( 'mobile' ) ? 'mobile' : 'primary',
				'menu_id'        => 'mobile-menu',
				'menu_class'     => 'mobile-menu',
				'container'      => false,
				'fallback_cb'    => false,
				'depth'          => 3,
				'walker'         => new CXC_Mobile_Menu_Walker(),
			)
		);
		?>
	</nav>

	<?php if ( get_theme_mod( 'cxc_header_cta_text' ) ) : ?>
		<a class="btn" style="width:100%;margin-top:24px;" href="<?php echo esc_url( get_theme_mod( 'cxc_header_cta_url', '#' ) ); ?>">
			<?php echo esc_html( get_theme_mod( 'cxc_header_cta_text' ) ); ?>
		</a>
	<?php endif; ?>

	<?php cxc_social_links_output( 'footer-social' ); ?>
</div>
