<?php
/**
 * Search form template.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="search-field-<?php echo esc_attr( wp_unique_id() ); ?>"><?php esc_html_e( 'Search for:', 'chrisxcreative' ); ?></label>
	<div style="display:flex;gap:10px;">
		<input type="search" id="search-field-<?php echo esc_attr( wp_unique_id() ); ?>" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'chrisxcreative' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
		<button type="submit"><?php cxc_icon( 'search' ); ?></button>
	</div>
</form>
