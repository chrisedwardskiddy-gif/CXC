<?php
/**
 * Lightweight custom fields (meta boxes) for the bundled post types.
 *
 * Deliberately framework-free (no ACF dependency) so the theme keeps working
 * out of the box for clients.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Field definitions per post type. Keeping this data-driven means one
 * render/save routine handles every post type.
 *
 * @return array
 */
function cxc_meta_fields() {
	return array(
		'cxc_portfolio'   => array(
			'_cxc_client'      => array( 'label' => __( 'Client Name', 'chrisxcreative' ), 'type' => 'text' ),
			'_cxc_project_url' => array( 'label' => __( 'Live Project URL', 'chrisxcreative' ), 'type' => 'url' ),
			'_cxc_project_date' => array( 'label' => __( 'Project Date', 'chrisxcreative' ), 'type' => 'text', 'placeholder' => 'January 2026' ),
			'_cxc_featured'    => array( 'label' => __( 'Feature on homepage', 'chrisxcreative' ), 'type' => 'checkbox' ),
		),
		'cxc_service'     => array(
			'_cxc_icon'     => array( 'label' => __( 'Dashicon class', 'chrisxcreative' ), 'type' => 'text', 'placeholder' => 'dashicons-art', 'help' => __( 'Any class name from developer.wordpress.org/resource/dashicons', 'chrisxcreative' ) ),
			'_cxc_featured' => array( 'label' => __( 'Feature on homepage', 'chrisxcreative' ), 'type' => 'checkbox' ),
		),
		'cxc_testimonial' => array(
			'_cxc_author_name' => array( 'label' => __( 'Author Name', 'chrisxcreative' ), 'type' => 'text' ),
			'_cxc_author_role' => array( 'label' => __( 'Author Role / Company', 'chrisxcreative' ), 'type' => 'text' ),
			'_cxc_rating'      => array( 'label' => __( 'Rating (1-5)', 'chrisxcreative' ), 'type' => 'number' ),
			'_cxc_featured'    => array( 'label' => __( 'Feature on homepage', 'chrisxcreative' ), 'type' => 'checkbox' ),
		),
		'cxc_team'        => array(
			'_cxc_role'         => array( 'label' => __( 'Job Title / Role', 'chrisxcreative' ), 'type' => 'text' ),
			'_cxc_social_facebook'  => array( 'label' => __( 'Facebook URL', 'chrisxcreative' ), 'type' => 'url' ),
			'_cxc_social_twitter'   => array( 'label' => __( 'X / Twitter URL', 'chrisxcreative' ), 'type' => 'url' ),
			'_cxc_social_linkedin'  => array( 'label' => __( 'LinkedIn URL', 'chrisxcreative' ), 'type' => 'url' ),
			'_cxc_social_instagram' => array( 'label' => __( 'Instagram URL', 'chrisxcreative' ), 'type' => 'url' ),
		),
	);
}

/**
 * Register the meta boxes.
 */
function cxc_add_meta_boxes() {
	$labels = array(
		'cxc_portfolio'   => __( 'Project Details', 'chrisxcreative' ),
		'cxc_service'     => __( 'Service Details', 'chrisxcreative' ),
		'cxc_testimonial' => __( 'Testimonial Details', 'chrisxcreative' ),
		'cxc_team'        => __( 'Team Member Details', 'chrisxcreative' ),
	);

	foreach ( $labels as $post_type => $label ) {
		add_meta_box( 'cxc_' . $post_type . '_details', $label, 'cxc_render_meta_box', $post_type, 'side', 'default' );
	}
}
add_action( 'add_meta_boxes', 'cxc_add_meta_boxes' );

/**
 * Render a meta box for the given post type using the field map above.
 *
 * @param WP_Post $post Current post.
 */
function cxc_render_meta_box( $post ) {
	$fields = cxc_meta_fields();
	if ( empty( $fields[ $post->post_type ] ) ) {
		return;
	}

	wp_nonce_field( 'cxc_save_meta_box', 'cxc_meta_box_nonce' );

	foreach ( $fields[ $post->post_type ] as $key => $field ) {
		$value = get_post_meta( $post->ID, $key, true );
		echo '<p>';
		echo '<label for="' . esc_attr( $key ) . '" style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html( $field['label'] ) . '</label>';

		if ( 'checkbox' === $field['type'] ) {
			echo '<label><input type="checkbox" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="1" ' . checked( $value, '1', false ) . ' /> ' . esc_html__( 'Yes', 'chrisxcreative' ) . '</label>';
		} elseif ( 'number' === $field['type'] ) {
			echo '<input type="number" min="1" max="5" style="width:100%" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" />';
		} else {
			$type = 'url' === $field['type'] ? 'url' : 'text';
			echo '<input type="' . esc_attr( $type ) . '" style="width:100%" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr( $field['placeholder'] ?? '' ) . '" />';
		}

		if ( ! empty( $field['help'] ) ) {
			echo '<span style="display:block;color:#777;font-size:12px;margin-top:4px;">' . esc_html( $field['help'] ) . '</span>';
		}
		echo '</p>';
	}
}

/**
 * Save meta box values.
 *
 * @param int $post_id Post ID being saved.
 */
function cxc_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['cxc_meta_box_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cxc_meta_box_nonce'] ) ), 'cxc_save_meta_box' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$post_type = get_post_type( $post_id );
	$fields    = cxc_meta_fields();
	if ( empty( $fields[ $post_type ] ) ) {
		return;
	}

	foreach ( $fields[ $post_type ] as $key => $field ) {
		if ( 'checkbox' === $field['type'] ) {
			update_post_meta( $post_id, $key, isset( $_POST[ $key ] ) ? '1' : '0' );
			continue;
		}

		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}

		$raw = wp_unslash( $_POST[ $key ] );

		if ( 'url' === $field['type'] ) {
			update_post_meta( $post_id, $key, esc_url_raw( $raw ) );
		} elseif ( 'number' === $field['type'] ) {
			update_post_meta( $post_id, $key, min( 5, max( 1, absint( $raw ) ) ) );
		} else {
			update_post_meta( $post_id, $key, sanitize_text_field( $raw ) );
		}
	}
}
add_action( 'save_post', 'cxc_save_meta_box' );
