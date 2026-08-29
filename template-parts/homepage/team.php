<?php
/**
 * Homepage team grid.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cxc_team = get_posts(
	array(
		'post_type'      => 'cxc_team',
		'posts_per_page' => 8,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);
if ( empty( $cxc_team ) ) {
	return;
}
?>
<section class="cxc-section cxc-section-alt" id="team">
	<div class="cxc-container">
		<div class="cxc-section-header">
			<p class="eyebrow" style="justify-content:center;"><?php esc_html_e( 'Our Team', 'chrisxcreative' ); ?></p>
			<h2><?php esc_html_e( 'Meet the people behind the work', 'chrisxcreative' ); ?></h2>
		</div>

		<div class="cxc-grid grid-4">
			<?php
			global $post;
			foreach ( $cxc_team as $post ) :
				setup_postdata( $post );
				get_template_part( 'template-parts/cards/team-card' );
			endforeach;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
