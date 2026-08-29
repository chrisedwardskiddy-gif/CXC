<?php
/**
 * Single team member profile.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="cxc-content-wrap">
		<div class="cxc-container-narrow">
			<div class="text-center" style="margin-bottom:40px;">
				<div class="team-photo" style="width:180px;height:180px;margin:0 auto 20px;">
					<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'medium' );
					} else {
						echo get_avatar( get_the_ID(), 180 );
					}
					?>
				</div>
				<h1><?php the_title(); ?></h1>
				<?php $cxc_role = get_post_meta( get_the_ID(), '_cxc_role', true ); ?>
				<?php if ( $cxc_role ) : ?>
					<p class="text-gradient" style="font-weight:700;"><?php echo esc_html( $cxc_role ); ?></p>
				<?php endif; ?>
				<div class="team-social" style="justify-content:center;">
					<?php
					$cxc_socials = array(
						'facebook'  => get_post_meta( get_the_ID(), '_cxc_social_facebook', true ),
						'twitter'   => get_post_meta( get_the_ID(), '_cxc_social_twitter', true ),
						'linkedin'  => get_post_meta( get_the_ID(), '_cxc_social_linkedin', true ),
						'instagram' => get_post_meta( get_the_ID(), '_cxc_social_instagram', true ),
					);
					foreach ( $cxc_socials as $cxc_network => $cxc_url ) {
						if ( $cxc_url ) {
							echo '<a href="' . esc_url( $cxc_url ) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr( $cxc_network ) . '">';
							cxc_icon( $cxc_network );
							echo '</a>';
						}
					}
					?>
				</div>
			</div>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
	<?php
endwhile;

get_footer();
