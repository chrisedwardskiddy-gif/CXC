<?php
/**
 * The header for the theme.
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
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-cxc-theme="<?php echo esc_attr( 'on' === get_theme_mod( 'cxc_dark_mode_default', 'off' ) ? 'dark' : 'light' ); ?>">
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'chrisxcreative' ); ?></a>

<?php if ( 'on' === get_theme_mod( 'cxc_show_topbar', 'on' ) && ( get_theme_mod( 'cxc_topbar_phone' ) || get_theme_mod( 'cxc_topbar_email' ) || is_active_sidebar( 'header-top' ) ) ) : ?>
	<div class="cxc-topbar">
		<div class="cxc-container">
			<div class="cxc-topbar-info">
				<?php if ( get_theme_mod( 'cxc_topbar_phone' ) ) : ?>
					<span><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', get_theme_mod( 'cxc_topbar_phone' ) ) ); ?>"><?php cxc_icon( 'phone' ); ?> <?php echo esc_html( get_theme_mod( 'cxc_topbar_phone' ) ); ?></a></span>
				<?php endif; ?>
				<?php if ( get_theme_mod( 'cxc_topbar_email' ) ) : ?>
					<span><a href="mailto:<?php echo esc_attr( get_theme_mod( 'cxc_topbar_email' ) ); ?>"><?php cxc_icon( 'mail' ); ?> <?php echo esc_html( get_theme_mod( 'cxc_topbar_email' ) ); ?></a></span>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'header-top' ) ) : ?>
					<?php dynamic_sidebar( 'header-top' ); ?>
				<?php endif; ?>
			</div>
			<div class="cxc-topbar-social">
				<?php cxc_social_links_output( 'cxc-topbar-social-inner' ); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<header id="masthead" class="site-header" data-sticky="<?php echo esc_attr( get_theme_mod( 'cxc_sticky_header', 'on' ) ); ?>">
	<div class="cxc-container">
		<div class="site-branding">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) {
					?>
					<p class="site-description"><?php echo esc_html( $description ); ?></p>
					<?php
				}
			}
			?>
		</div>

		<div class="header-inner">
			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'chrisxcreative' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'primary-menu',
						'container'      => false,
						'fallback_cb'    => false,
						'depth'          => 3,
					)
				);
				?>
			</nav>

			<div class="header-actions">
				<?php if ( 'on' === get_theme_mod( 'cxc_show_search_icon', 'on' ) ) : ?>
					<button type="button" class="cxc-search-toggle" aria-haspopup="true" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open search', 'chrisxcreative' ); ?>">
						<?php cxc_icon( 'search' ); ?>
					</button>
				<?php endif; ?>

				<?php if ( 'on' === get_theme_mod( 'cxc_enable_dark_toggle', 'on' ) ) : ?>
					<button type="button" class="cxc-theme-toggle" aria-label="<?php esc_attr_e( 'Toggle dark mode', 'chrisxcreative' ); ?>">
						<span class="icon-moon"><?php cxc_icon( 'moon' ); ?></span>
						<span class="icon-sun"><?php cxc_icon( 'sun' ); ?></span>
					</button>
				<?php endif; ?>

				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<a class="cxc-cart-toggle" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'View cart', 'chrisxcreative' ); ?>" style="display:inline-flex;align-items:center;justify-content:center;width:44px;height:44px;">
						<?php cxc_icon( 'cart' ); ?>
					</a>
				<?php endif; ?>

				<?php if ( get_theme_mod( 'cxc_header_cta_text' ) ) : ?>
					<a class="btn btn-sm header-cta" href="<?php echo esc_url( get_theme_mod( 'cxc_header_cta_url', '#' ) ); ?>">
						<?php echo esc_html( get_theme_mod( 'cxc_header_cta_text' ) ); ?>
					</a>
				<?php endif; ?>

				<button type="button" class="cxc-menu-toggle" aria-controls="cxc-mobile-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open menu', 'chrisxcreative' ); ?>">
					<span></span>
				</button>
			</div>
		</div>
	</div>
</header>

<?php get_template_part( 'template-parts/header/mobile-menu' ); ?>
<?php if ( 'on' === get_theme_mod( 'cxc_show_search_icon', 'on' ) ) : ?>
	<?php get_template_part( 'template-parts/header/search-overlay' ); ?>
<?php endif; ?>

<main id="primary" class="site-main">
