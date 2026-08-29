<?php
/**
 * Single team member card. Expects the loop to be set up (global $post).
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cxc_role = get_post_meta( get_the_ID(), '_cxc_role', true );
$cxc_socials = array(
	'facebook'  => get_post_meta( get_the_ID(), '_cxc_social_facebook', true ),
	'twitter'   => get_post_meta( get_the_ID(), '_cxc_social_twitter', true ),
	'linkedin'  => get_post_meta( get_the_ID(), '_cxc_social_linkedin', true ),
	'instagram' => get_post_meta( get_the_ID(), '_cxc_social_instagram', true ),
);
?>
<div class="cxc-card team-card reveal">
	<div class="team-photo">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'medium' );
		} else {
			echo get_avatar( get_the_ID(), 140, '', '', array( 'default' => 'mystery' ) );
		}
		?>
	</div>
	<h3><?php the_title(); ?></h3>
	<?php if ( $cxc_role ) : ?>
		<div class="team-role"><?php echo esc_html( $cxc_role ); ?></div>
	<?php endif; ?>
	<div class="team-social">
		<?php
		foreach ( $cxc_socials as $network => $url ) {
			if ( $url ) {
				echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr( $network ) . '">';
				cxc_icon( $network );
				echo '</a>';
			}
		}
		?>
	</div>
</div>
