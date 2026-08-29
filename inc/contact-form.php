<?php
/**
 * Built-in AJAX contact form — no Contact Form 7 / plugin dependency.
 * Nonce-protected, honeypot spam trap, sends via wp_mail().
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render the contact form markup. Usable as a template part or via the
 * [cxc_contact_form] shortcode.
 *
 * @return string
 */
function cxc_contact_form_markup() {
	ob_start();
	?>
	<form class="cxc-contact-form" id="cxc-contact-form" method="post" novalidate>
		<div class="cxc-form-notice-wrap" aria-live="polite"></div>

		<div class="form-row">
			<p>
				<label for="cxc-name"><?php esc_html_e( 'Full Name', 'chrisxcreative' ); ?> <span aria-hidden="true">*</span></label>
				<input type="text" id="cxc-name" name="cxc_name" required autocomplete="name" />
			</p>
			<p>
				<label for="cxc-email"><?php esc_html_e( 'Email Address', 'chrisxcreative' ); ?> <span aria-hidden="true">*</span></label>
				<input type="email" id="cxc-email" name="cxc_email" required autocomplete="email" />
			</p>
		</div>

		<div class="form-row">
			<p>
				<label for="cxc-phone"><?php esc_html_e( 'Phone (optional)', 'chrisxcreative' ); ?></label>
				<input type="tel" id="cxc-phone" name="cxc_phone" autocomplete="tel" />
			</p>
			<p>
				<label for="cxc-subject"><?php esc_html_e( 'Subject', 'chrisxcreative' ); ?></label>
				<input type="text" id="cxc-subject" name="cxc_subject" />
			</p>
		</div>

		<p>
			<label for="cxc-message"><?php esc_html_e( 'Message', 'chrisxcreative' ); ?> <span aria-hidden="true">*</span></label>
			<textarea id="cxc-message" name="cxc_message" rows="5" required></textarea>
		</p>

		<p class="cxc-form-hp">
			<label for="cxc-website"><?php esc_html_e( 'Leave this field empty', 'chrisxcreative' ); ?></label>
			<input type="text" id="cxc-website" name="cxc_website" tabindex="-1" autocomplete="off" />
		</p>

		<?php wp_nonce_field( 'cxc_contact_form', 'cxc_contact_nonce' ); ?>

		<button type="submit" class="btn">
			<span class="btn-text"><?php esc_html_e( 'Send Message', 'chrisxcreative' ); ?></span>
		</button>
	</form>
	<?php
	return ob_get_clean();
}

/**
 * [cxc_contact_form] shortcode so the form can be dropped into any page or
 * block via the Shortcode block.
 *
 * @return string
 */
function cxc_contact_form_shortcode() {
	return cxc_contact_form_markup();
}
add_shortcode( 'cxc_contact_form', 'cxc_contact_form_shortcode' );

/**
 * Handle the AJAX submission for both logged-in and logged-out visitors.
 */
function cxc_handle_contact_form() {
	check_ajax_referer( 'cxc_contact_form', 'nonce' );

	// Honeypot: bots fill every field, humans never see this one.
	if ( ! empty( $_POST['cxc_website'] ) ) {
		wp_send_json_success( array( 'message' => __( 'Thank you! Your message has been sent.', 'chrisxcreative' ) ) );
	}

	$name    = isset( $_POST['cxc_name'] ) ? sanitize_text_field( wp_unslash( $_POST['cxc_name'] ) ) : '';
	$email   = isset( $_POST['cxc_email'] ) ? sanitize_email( wp_unslash( $_POST['cxc_email'] ) ) : '';
	$phone   = isset( $_POST['cxc_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['cxc_phone'] ) ) : '';
	$subject = isset( $_POST['cxc_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['cxc_subject'] ) ) : '';
	$message = isset( $_POST['cxc_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['cxc_message'] ) ) : '';

	if ( empty( $name ) || empty( $message ) || ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please fill in your name, a valid email address and a message.', 'chrisxcreative' ) ) );
	}

	$to = apply_filters( 'cxc_contact_form_recipient', get_option( 'admin_email' ) );

	$mail_subject = $subject ? $subject : sprintf(
		/* translators: %s: site name */
		__( 'New enquiry from %s', 'chrisxcreative' ),
		get_bloginfo( 'name' )
	);

	$body  = sprintf( "%s: %s\n", __( 'Name', 'chrisxcreative' ), $name );
	$body .= sprintf( "%s: %s\n", __( 'Email', 'chrisxcreative' ), $email );
	if ( $phone ) {
		$body .= sprintf( "%s: %s\n", __( 'Phone', 'chrisxcreative' ), $phone );
	}
	$body .= "\n" . $message;

	$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, wp_strip_all_tags( $mail_subject ), $body, $headers );

	if ( $sent ) {
		/**
		 * Fires after a contact form submission has been emailed successfully.
		 *
		 * @param array $fields Sanitized form fields.
		 */
		do_action( 'cxc_contact_form_sent', compact( 'name', 'email', 'phone', 'subject', 'message' ) );

		wp_send_json_success( array( 'message' => __( 'Thank you! Your message has been sent — we will be in touch shortly.', 'chrisxcreative' ) ) );
	}

	wp_send_json_error( array( 'message' => __( 'Sorry, something went wrong sending your message. Please try again or email us directly.', 'chrisxcreative' ) ) );
}
add_action( 'wp_ajax_cxc_contact_form', 'cxc_handle_contact_form' );
add_action( 'wp_ajax_nopriv_cxc_contact_form', 'cxc_handle_contact_form' );
