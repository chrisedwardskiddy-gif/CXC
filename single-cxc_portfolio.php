<?php
/**
 * Single portfolio project.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$cxc_client   = get_post_meta( get_the_ID(), '_cxc_client', true );
	$cxc_url      = get_post_meta( get_the_ID(), '_cxc_project_url', true );
	$cxc_date     = get_post_meta( get_the_ID(), '_cxc_project_date', true );
	$cxc_terms    = get_the_terms( get_the_ID(), 'cxc_portfolio_category' );
	?>
	<div class="page-banner">
		<div class="cxc-container">
			<?php if ( $cxc_terms && ! is_wp_error( $cxc_terms ) ) : ?>
				<p class="eyebrow" style="justify-content:center;"><?php echo esc_html( $cxc_terms[0]->name ); ?></p>
			<?php endif; ?>
			<h1><?php the_title(); ?></h1>
			<?php cxc_breadcrumbs(); ?>
		</div>
	</div>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="cxc-container-wide" style="margin-top:-24px;">
			<?php the_post_thumbnail( 'cxc-portfolio-large', array( 'style' => 'width:100%;height:auto;border-radius:var(--cxc-radius-lg);' ) ); ?>
		</div>
	<?php endif; ?>

	<div class="cxc-content-wrap">
		<div class="has-sidebar">
			<div class="content-area" style="grid-template-columns:1fr 320px;">
				<div class="entry-content">
					<?php the_content(); ?>
				</div>

				<aside class="widget-area">
					<div class="widget">
						<h3 class="widget-title"><?php esc_html_e( 'Project Details', 'chrisxcreative' ); ?></h3>
						<ul style="list-style:none;margin:0;padding:0;">
							<?php if ( $cxc_client ) : ?>
								<li style="padding:10px 0;border-bottom:1px solid var(--cxc-border);"><strong><?php esc_html_e( 'Client', 'chrisxcreative' ); ?></strong><br><?php echo esc_html( $cxc_client ); ?></li>
							<?php endif; ?>
							<?php if ( $cxc_date ) : ?>
								<li style="padding:10px 0;border-bottom:1px solid var(--cxc-border);"><strong><?php esc_html_e( 'Date', 'chrisxcreative' ); ?></strong><br><?php echo esc_html( $cxc_date ); ?></li>
							<?php endif; ?>
							<?php if ( $cxc_terms && ! is_wp_error( $cxc_terms ) ) : ?>
								<li style="padding:10px 0;border-bottom:1px solid var(--cxc-border);"><strong><?php esc_html_e( 'Category', 'chrisxcreative' ); ?></strong><br>
									<?php echo esc_html( wp_list_pluck( $cxc_terms, 'name' ) ? implode( ', ', wp_list_pluck( $cxc_terms, 'name' ) ) : '' ); ?>
								</li>
							<?php endif; ?>
						</ul>
						<?php if ( $cxc_url ) : ?>
							<a class="btn" style="width:100%;margin-top:16px;" href="<?php echo esc_url( $cxc_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Visit Live Site', 'chrisxcreative' ); ?></a>
						<?php endif; ?>
					</div>
				</aside>
			</div>
		</div>
	</div>

	<?php
	$cxc_related = new WP_Query(
		array(
			'post_type'      => 'cxc_portfolio',
			'posts_per_page' => 3,
			'post__not_in'   => array( get_the_ID() ),
			'orderby'        => 'rand',
			'no_found_rows'  => true,
		)
	);
	if ( $cxc_related->have_posts() ) :
		?>
		<section class="cxc-section cxc-section-alt">
			<div class="cxc-container">
				<div class="cxc-section-header"><h2><?php esc_html_e( 'More Projects', 'chrisxcreative' ); ?></h2></div>
				<div class="cxc-grid grid-3">
					<?php
					while ( $cxc_related->have_posts() ) :
						$cxc_related->the_post();
						get_template_part( 'template-parts/cards/portfolio-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
		<?php
	endif;

endwhile;

get_footer();
