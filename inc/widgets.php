<?php
/**
 * Bundled widgets: Social Icons, Contact Info, Recent Portfolio.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Social icons widget — pulls from the Customizer social links by default,
 * but can be dropped into any widget area (e.g. the footer).
 */
class CXC_Widget_Social_Icons extends WP_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct(
			'cxc_social_icons',
			__( 'CXC: Social Icons', 'chrisxcreative' ),
			array( 'description' => __( 'Displays your social media icons from Customizer > Social Links.', 'chrisxcreative' ) )
		);
	}

	/**
	 * Front-end output.
	 *
	 * @param array $args     Widget args.
	 * @param array $instance Saved values.
	 */
	public function widget( $args, $instance ) {
		echo wp_kses_post( $args['before_widget'] );
		if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] ) . esc_html( $instance['title'] ) . wp_kses_post( $args['after_title'] );
		}
		cxc_social_links_output( 'footer-social' );
		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Admin form.
	 *
	 * @param array $instance Saved values.
	 */
	public function form( $instance ) {
		$title = $instance['title'] ?? __( 'Follow Us', 'chrisxcreative' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'chrisxcreative' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p><em><?php esc_html_e( 'Manage the actual links in Customizer > ChrisXCreative Theme Options > Social Links.', 'chrisxcreative' ); ?></em></p>
		<?php
	}

	/**
	 * Save handler.
	 *
	 * @param array $new_instance New values.
	 * @param array $old_instance Old values.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		return $instance;
	}
}

/**
 * Contact info widget — address, phone, email with icons.
 */
class CXC_Widget_Contact_Info extends WP_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct(
			'cxc_contact_info',
			__( 'CXC: Contact Info', 'chrisxcreative' ),
			array( 'description' => __( 'Address, phone and email with icons — great for the footer.', 'chrisxcreative' ) )
		);
	}

	/**
	 * Front-end output.
	 *
	 * @param array $args     Widget args.
	 * @param array $instance Saved values.
	 */
	public function widget( $args, $instance ) {
		echo wp_kses_post( $args['before_widget'] );
		if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] ) . esc_html( $instance['title'] ) . wp_kses_post( $args['after_title'] );
		}
		?>
		<ul class="contact-info-list">
			<?php if ( ! empty( $instance['address'] ) ) : ?>
				<li><span class="icon" aria-hidden="true"><?php cxc_icon( 'pin' ); ?></span><span><?php echo wp_kses_post( nl2br( esc_html( $instance['address'] ) ) ); ?></span></li>
			<?php endif; ?>
			<?php if ( ! empty( $instance['phone'] ) ) : ?>
				<li><span class="icon" aria-hidden="true"><?php cxc_icon( 'phone' ); ?></span><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $instance['phone'] ) ); ?>"><?php echo esc_html( $instance['phone'] ); ?></a></li>
			<?php endif; ?>
			<?php if ( ! empty( $instance['email'] ) ) : ?>
				<li><span class="icon" aria-hidden="true"><?php cxc_icon( 'mail' ); ?></span><a href="mailto:<?php echo esc_attr( $instance['email'] ); ?>"><?php echo esc_html( $instance['email'] ); ?></a></li>
			<?php endif; ?>
		</ul>
		<?php
		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Admin form.
	 *
	 * @param array $instance Saved values.
	 */
	public function form( $instance ) {
		$title   = $instance['title'] ?? __( 'Get In Touch', 'chrisxcreative' );
		$address = $instance['address'] ?? '';
		$phone   = $instance['phone'] ?? '';
		$email   = $instance['email'] ?? '';
		?>
		<p><label><?php esc_html_e( 'Title:', 'chrisxcreative' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"></p>
		<p><label><?php esc_html_e( 'Address:', 'chrisxcreative' ); ?></label>
			<textarea class="widefat" rows="3" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>"><?php echo esc_textarea( $address ); ?></textarea></p>
		<p><label><?php esc_html_e( 'Phone:', 'chrisxcreative' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>"></p>
		<p><label><?php esc_html_e( 'Email:', 'chrisxcreative' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="email" value="<?php echo esc_attr( $email ); ?>"></p>
		<?php
	}

	/**
	 * Save handler.
	 *
	 * @param array $new_instance New values.
	 * @param array $old_instance Old values.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		return array(
			'title'   => sanitize_text_field( $new_instance['title'] ),
			'address' => sanitize_textarea_field( $new_instance['address'] ),
			'phone'   => sanitize_text_field( $new_instance['phone'] ),
			'email'   => sanitize_email( $new_instance['email'] ),
		);
	}
}

/**
 * Recent portfolio widget — small thumbnail grid.
 */
class CXC_Widget_Recent_Portfolio extends WP_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct(
			'cxc_recent_portfolio',
			__( 'CXC: Recent Portfolio', 'chrisxcreative' ),
			array( 'description' => __( 'A small thumbnail grid of your latest portfolio items.', 'chrisxcreative' ) )
		);
	}

	/**
	 * Front-end output.
	 *
	 * @param array $args     Widget args.
	 * @param array $instance Saved values.
	 */
	public function widget( $args, $instance ) {
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 6;

		$query = new WP_Query(
			array(
				'post_type'      => 'cxc_portfolio',
				'posts_per_page' => $number,
				'no_found_rows'  => true,
				'ignore_sticky_posts' => true,
			)
		);

		if ( ! $query->have_posts() ) {
			return;
		}

		echo wp_kses_post( $args['before_widget'] );
		if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] ) . esc_html( $instance['title'] ) . wp_kses_post( $args['after_title'] );
		}
		echo '<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;">';
		while ( $query->have_posts() ) {
			$query->the_post();
			printf(
				'<a href="%1$s" style="display:block;border-radius:8px;overflow:hidden;aspect-ratio:1/1;" title="%2$s">%3$s</a>',
				esc_url( get_permalink() ),
				esc_attr( get_the_title() ),
				get_the_post_thumbnail( get_the_ID(), 'thumbnail', array( 'style' => 'width:100%;height:100%;object-fit:cover;' ) )
			);
		}
		echo '</div>';
		wp_reset_postdata();
		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Admin form.
	 *
	 * @param array $instance Saved values.
	 */
	public function form( $instance ) {
		$title  = $instance['title'] ?? __( 'Recent Work', 'chrisxcreative' );
		$number = $instance['number'] ?? 6;
		?>
		<p><label><?php esc_html_e( 'Title:', 'chrisxcreative' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"></p>
		<p><label><?php esc_html_e( 'Number of items:', 'chrisxcreative' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" min="3" max="12" value="<?php echo esc_attr( $number ); ?>"></p>
		<?php
	}

	/**
	 * Save handler.
	 *
	 * @param array $new_instance New values.
	 * @param array $old_instance Old values.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		return array(
			'title'  => sanitize_text_field( $new_instance['title'] ),
			'number' => min( 12, max( 3, absint( $new_instance['number'] ) ) ),
		);
	}
}

/**
 * Register the bundled widgets.
 */
function cxc_register_widgets() {
	register_widget( 'CXC_Widget_Social_Icons' );
	register_widget( 'CXC_Widget_Contact_Info' );
	register_widget( 'CXC_Widget_Recent_Portfolio' );
}
add_action( 'widgets_init', 'cxc_register_widgets' );
