<?php
/**
 * Footer widget columns.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cxc_columns = absint( get_theme_mod( 'cxc_footer_columns', '4' ) );
$cxc_has_any_widgets = false;
for ( $cxc_i = 1; $cxc_i <= 4; $cxc_i++ ) {
	if ( is_active_sidebar( 'footer-' . $cxc_i ) ) {
		$cxc_has_any_widgets = true;
		break;
	}
}
?>
<div class="footer-widgets">
	<div class="cxc-container">
		<div class="cxc-grid" style="grid-template-columns:1.4fr <?php echo esc_attr( str_repeat( '1fr ', $cxc_columns ) ); ?>;">
			<div class="footer-brand">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					echo '<p class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a></p>';
				}
				$cxc_tagline = get_bloginfo( 'description' );
				if ( $cxc_tagline ) {
					echo '<p>' . esc_html( $cxc_tagline ) . '</p>';
				}
				?>
				<?php cxc_social_links_output( 'footer-social' ); ?>
			</div>

			<?php if ( $cxc_has_any_widgets ) : ?>
				<?php for ( $cxc_i = 1; $cxc_i <= $cxc_columns; $cxc_i++ ) : ?>
					<?php if ( is_active_sidebar( 'footer-' . $cxc_i ) ) : ?>
						<div class="footer-col">
							<?php dynamic_sidebar( 'footer-' . $cxc_i ); ?>
						</div>
					<?php endif; ?>
				<?php endfor; ?>
			<?php else : ?>
				<div class="footer-col">
					<h3 class="widget-title"><?php esc_html_e( 'Explore', 'chrisxcreative' ); ?></h3>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => has_nav_menu( 'footer' ) ? 'footer' : 'primary',
							'container'      => false,
							'menu_class'     => '',
							'items_wrap'     => '<ul>%3$s</ul>',
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
