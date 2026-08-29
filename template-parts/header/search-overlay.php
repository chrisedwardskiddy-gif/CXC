<?php
/**
 * Full-screen search overlay.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="cxc-search-overlay" data-cxc-search-overlay>
	<button type="button" class="cxc-search-close" data-cxc-search-close aria-label="<?php esc_attr_e( 'Close search', 'chrisxcreative' ); ?>">
		<?php cxc_icon( 'close' ); ?>
	</button>
	<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="screen-reader-text" for="cxc-search-field"><?php esc_html_e( 'Search for:', 'chrisxcreative' ); ?></label>
		<input type="search" id="cxc-search-field" placeholder="<?php esc_attr_e( 'Search the site…', 'chrisxcreative' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
		<button type="submit" aria-label="<?php esc_attr_e( 'Submit search', 'chrisxcreative' ); ?>"><?php cxc_icon( 'arrow' ); ?></button>
	</form>
</div>
