<?php
/**
 * The footer for the theme.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main><!-- #primary -->

<footer id="colophon" class="site-footer">
	<?php get_template_part( 'template-parts/footer/widgets' ); ?>
	<?php get_template_part( 'template-parts/footer/site-info' ); ?>
</footer>

<button type="button" class="back-to-top" data-cxc-back-to-top aria-label="<?php esc_attr_e( 'Back to top', 'chrisxcreative' ); ?>">
	<svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
