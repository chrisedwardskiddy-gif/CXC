<?php
/**
 * ChrisXCreative agency branding: the "Designed & Hosted by ChrisXCreative"
 * credit shown in both the site footer and the wp-admin dashboard footer.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The ChrisXCreative site URL used for the credit link everywhere.
 *
 * @return string
 */
function cxc_agency_url() {
	return 'https://www.chrisxcreative.co.uk';
}

/**
 * Return the "Designed & Hosted by ChrisXCreative" markup, gradient-styled
 * and linking to the agency site. Shared by the site footer and wp-admin.
 *
 * @param string $extra_class Extra class(es) for the wrapping <a>.
 * @return string
 */
function cxc_credit_link_markup( $extra_class = '' ) {
	return sprintf(
		'<a href="%1$s" class="cxc-credit %2$s" target="_blank" rel="noopener noreferrer">%3$s</a>',
		esc_url( cxc_agency_url() ),
		esc_attr( $extra_class ),
		esc_html__( 'Designed & Hosted by ChrisXCreative', 'chrisxcreative' )
	);
}

/**
 * Site footer credit line, used in template-parts/footer/site-info.php.
 */
function cxc_site_credit() {
	echo wp_kses(
		cxc_credit_link_markup(),
		array(
			'a' => array(
				'href'   => true,
				'class'  => true,
				'target' => true,
				'rel'    => true,
			),
		)
	);
}

/**
 * Replace the default wp-admin footer text with the ChrisXCreative credit.
 *
 * @return string
 */
function cxc_admin_footer_text() {
	return cxc_credit_link_markup( 'cxc-admin-credit' );
}
add_filter( 'admin_footer_text', 'cxc_admin_footer_text' );

/**
 * Inline CSS so the gradient credit link renders correctly inside wp-admin,
 * where the theme's own stylesheet is not loaded.
 */
function cxc_admin_credit_style() {
	?>
	<style>
		#wpfooter .cxc-admin-credit,
		#footer-thankyou .cxc-admin-credit{
			background-image:linear-gradient(120deg,#5b3df0 0%,#ff5d73 100%);
			background-size:200% auto;
			-webkit-background-clip:text;
			background-clip:text;
			-webkit-text-fill-color:transparent;
			color:transparent;
			font-weight:700;
			text-decoration:none;
			transition:background-position .5s ease;
		}
		#wpfooter .cxc-admin-credit:hover,
		#wpfooter .cxc-admin-credit:focus{
			background-position:right center;
		}
	</style>
	<?php
}
add_action( 'admin_head', 'cxc_admin_credit_style' );
add_action( 'login_head', 'cxc_admin_credit_style' );

/**
 * Add the same credit to the wp-admin login screen footer for consistency.
 */
function cxc_login_footer() {
	echo '<p style="text-align:center;margin-top:16px;">' . wp_kses(
		cxc_credit_link_markup(),
		array( 'a' => array( 'href' => true, 'class' => true, 'target' => true, 'rel' => true ) )
	) . '</p>';
}
add_action( 'login_footer', 'cxc_login_footer' );
