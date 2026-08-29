<?php
/**
 * Single testimonial (rarely visited directly, but kept fully styled).
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
			<?php get_template_part( 'template-parts/cards/testimonial-card' ); ?>
		</div>
	</div>
	<?php
endwhile;

get_footer();
