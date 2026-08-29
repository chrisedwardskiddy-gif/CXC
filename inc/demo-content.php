<?php
/**
 * One-click demo content installer — creates sample pages, portfolio
 * items, services, testimonials, team members, posts and menus so a new
 * client site looks complete the moment the theme is activated.
 *
 * @package ChrisXCreative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Find a post by exact title + post type (replacement for the deprecated
 * get_page_by_title(), used throughout the demo installer to stay idempotent).
 *
 * @param string $title     Post title to match.
 * @param string $post_type Post type slug.
 * @return WP_Post|null
 */
function cxc_get_post_by_title( $title, $post_type ) {
	$query = new WP_Query(
		array(
			'post_type'              => $post_type,
			'title'                  => $title,
			'post_status'            => 'any',
			'posts_per_page'         => 1,
			'no_found_rows'          => true,
			'ignore_sticky_posts'    => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	return ! empty( $query->posts ) ? $query->posts[0] : null;
}

/**
 * Register the "Theme Setup" admin page under Appearance.
 */
function cxc_demo_content_admin_menu() {
	add_theme_page(
		__( 'ChrisXCreative Setup', 'chrisxcreative' ),
		__( 'Theme Setup', 'chrisxcreative' ),
		'manage_options',
		'cxc-theme-setup',
		'cxc_demo_content_admin_page'
	);
}
add_action( 'admin_menu', 'cxc_demo_content_admin_menu' );

/**
 * Render the admin page.
 */
function cxc_demo_content_admin_page() {
	$installed = get_option( 'cxc_demo_content_installed' );
	?>
	<div class="wrap cxc-setup-wrap">
		<h1><?php esc_html_e( 'ChrisXCreative — Theme Setup', 'chrisxcreative' ); ?></h1>
		<p class="description"><?php esc_html_e( 'Welcome! Use the button below to install one-click demo content — sample pages, portfolio projects, services, testimonials, team members and blog posts — so your new site looks complete from day one. You can safely edit or delete anything afterwards.', 'chrisxcreative' ); ?></p>

		<?php if ( $installed ) : ?>
			<div class="notice notice-success inline"><p><?php esc_html_e( 'Demo content has already been installed on this site.', 'chrisxcreative' ); ?></p></div>
		<?php endif; ?>

		<div class="cxc-setup-card">
			<h2><?php esc_html_e( '1. Install Demo Content', 'chrisxcreative' ); ?></h2>
			<p><?php esc_html_e( 'Creates demo pages, a Services/Portfolio/Testimonials/Team library, sample blog posts, and sets up your navigation menus automatically.', 'chrisxcreative' ); ?></p>
			<button type="button" class="button button-primary button-hero" id="cxc-install-demo"><?php esc_html_e( 'Install Demo Content', 'chrisxcreative' ); ?></button>
			<span class="spinner" style="float:none;"></span>
			<div id="cxc-install-log" style="margin-top:16px;"></div>
		</div>

		<div class="cxc-setup-card">
			<h2><?php esc_html_e( '2. Customise Your Site', 'chrisxcreative' ); ?></h2>
			<p><?php esc_html_e( 'Head to the Customizer to set your logo, brand colours, header, footer and homepage text.', 'chrisxcreative' ); ?></p>
			<a class="button" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'Open Customizer', 'chrisxcreative' ); ?></a>
		</div>

		<div class="cxc-setup-card">
			<h2><?php esc_html_e( '3. Manage Your Content', 'chrisxcreative' ); ?></h2>
			<p><?php esc_html_e( 'Portfolio, Services, Testimonials and Team all have their own menu in the dashboard sidebar — add, edit or remove entries any time.', 'chrisxcreative' ); ?></p>
		</div>
	</div>
	<?php
}

/**
 * Enqueue the small admin script that drives the "Install Demo Content" button.
 *
 * @param string $hook Current admin page hook.
 */
function cxc_demo_content_admin_script( $hook ) {
	if ( 'appearance_page_cxc-theme-setup' !== $hook ) {
		return;
	}
	wp_enqueue_script( 'chrisxcreative-demo-admin', CXC_URI . '/assets/js/admin-demo-content.js', array(), CXC_VERSION, true );
	wp_localize_script(
		'chrisxcreative-demo-admin',
		'cxcDemoData',
		array(
			'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'cxc_install_demo_content' ),
			'confirm'  => __( 'This will create sample pages, posts and portfolio items. Continue?', 'chrisxcreative' ),
			'working'  => __( 'Installing demo content…', 'chrisxcreative' ),
			'done'     => __( 'All done! Your demo content has been installed.', 'chrisxcreative' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'cxc_demo_content_admin_script' );

/**
 * AJAX handler: runs the full demo content installation.
 */
function cxc_ajax_install_demo_content() {
	check_ajax_referer( 'cxc_install_demo_content', 'nonce' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => __( 'You do not have permission to do this.', 'chrisxcreative' ) ) );
	}

	cxc_run_demo_content_install();

	wp_send_json_success( array( 'message' => __( 'Demo content installed successfully.', 'chrisxcreative' ) ) );
}
add_action( 'wp_ajax_cxc_install_demo_content', 'cxc_ajax_install_demo_content' );

/**
 * Orchestrates demo content creation.
 */
function cxc_run_demo_content_install() {
	$term_ids     = cxc_demo_create_portfolio_terms();
	cxc_demo_create_services();
	cxc_demo_create_portfolio( $term_ids );
	cxc_demo_create_testimonials();
	cxc_demo_create_team();
	cxc_demo_create_posts();
	cxc_demo_create_pages_and_menus();

	flush_rewrite_rules();

	update_option( 'cxc_demo_content_installed', current_time( 'mysql' ) );
}

/**
 * Create portfolio category terms.
 *
 * @return array slug => term_id
 */
function cxc_demo_create_portfolio_terms() {
	$terms = array( 'Branding', 'Web Design', 'Development', 'Marketing' );
	$ids   = array();

	foreach ( $terms as $term ) {
		$existing = term_exists( $term, 'cxc_portfolio_category' );
		if ( $existing ) {
			$ids[ sanitize_title( $term ) ] = (int) $existing['term_id'];
			continue;
		}
		$result = wp_insert_term( $term, 'cxc_portfolio_category' );
		if ( ! is_wp_error( $result ) ) {
			$ids[ sanitize_title( $term ) ] = (int) $result['term_id'];
		}
	}

	return $ids;
}

/**
 * Create sample services.
 */
function cxc_demo_create_services() {
	$services = array(
		array( 'Brand Strategy', 'dashicons-lightbulb', 'We uncover what makes your business unique and translate it into a brand strategy that guides every decision — from your logo to your tone of voice.' ),
		array( 'Web Design', 'dashicons-art', 'Modern, conversion-focused websites designed around your customers, tailored to your brand and built to work beautifully on every device.' ),
		array( 'Development', 'dashicons-editor-code', 'Fast, secure, scalable builds on WordPress with clean code, sensible architecture and long-term maintainability in mind.' ),
		array( 'SEO & Growth', 'dashicons-chart-line', 'Technical SEO, content strategy and conversion optimisation to help the right people find you and take action.' ),
		array( 'E-Commerce', 'dashicons-cart', 'Beautiful, high-converting online stores built on WooCommerce with secure payments and smooth checkout experiences.' ),
		array( 'Brand Identity', 'dashicons-admin-customizer', 'Logo design, colour systems and visual identity guidelines that keep your brand consistent everywhere it appears.' ),
	);

	foreach ( $services as $i => $service ) {
		list( $title, $icon, $desc ) = $service;

		if ( cxc_get_post_by_title( $title, 'cxc_service' ) ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'cxc_service',
				'post_title'   => $title,
				'post_content' => $desc,
				'post_excerpt' => $desc,
				'post_status'  => 'publish',
				'menu_order'   => $i,
			)
		);

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, '_cxc_icon', $icon );
			update_post_meta( $post_id, '_cxc_featured', $i < 3 ? '1' : '0' );
		}
	}
}

/**
 * Create sample portfolio projects.
 *
 * @param array $term_ids Portfolio category term IDs, keyed by slug.
 */
function cxc_demo_create_portfolio( $term_ids ) {
	$projects = array(
		array( 'Aurora Skincare Rebrand', 'branding', 'Client A', 'A complete brand identity refresh for a modern skincare label, including logo, packaging and a new visual language.' ),
		array( 'Northbank Real Estate', 'web-design', 'Client B', 'A bold, image-led website that lets luxury properties speak for themselves.' ),
		array( 'Fintra Banking App', 'development', 'Client C', 'A performant progressive web app rebuilt from the ground up for speed and accessibility.' ),
		array( 'Verde Coffee Roasters', 'branding', 'Client D', 'Packaging and e-commerce design for an independent coffee roastery expanding online.' ),
		array( 'Lumen Fitness Studio', 'marketing', 'Client E', 'A full-funnel launch campaign that took a new studio from zero to fully booked in eight weeks.' ),
		array( 'Orbit SaaS Dashboard', 'development', 'Client F', 'A clean, data-dense dashboard interface designed for clarity at a glance.' ),
	);

	foreach ( $projects as $i => $project ) {
		list( $title, $cat_slug, $client, $desc ) = $project;

		if ( cxc_get_post_by_title( $title, 'cxc_portfolio' ) ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'cxc_portfolio',
				'post_title'   => $title,
				'post_content' => $desc . "\n\n" . __( 'Add more detail about the brief, the process and the results here.', 'chrisxcreative' ),
				'post_excerpt' => $desc,
				'post_status'  => 'publish',
				'menu_order'   => $i,
			)
		);

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, '_cxc_client', $client );
			update_post_meta( $post_id, '_cxc_project_date', gmdate( 'F Y' ) );
			update_post_meta( $post_id, '_cxc_featured', $i < 4 ? '1' : '0' );
			if ( ! empty( $term_ids[ $cat_slug ] ) ) {
				wp_set_object_terms( $post_id, (int) $term_ids[ $cat_slug ], 'cxc_portfolio_category' );
			}
		}
	}
}

/**
 * Create sample testimonials.
 */
function cxc_demo_create_testimonials() {
	$testimonials = array(
		array( 'Sarah Jenkins', 'Founder, Aurora Skincare', 'ChrisXCreative completely transformed how our brand shows up online. The whole process was smooth, fast and genuinely enjoyable.', 5 ),
		array( 'Marcus Reid', 'CEO, Northbank Real Estate', 'From the first call it was clear they understood exactly what we needed. Our enquiries have more than doubled since launch.', 5 ),
		array( 'Priya Anand', 'Head of Marketing, Fintra', 'Professional, responsive and genuinely talented. The new site loads instantly and looks stunning on every device.', 5 ),
		array( 'Tom Whitfield', 'Owner, Verde Coffee Roasters', 'Best investment we have made in the business. The team really took the time to understand our brand.', 5 ),
		array( 'Elena Duarte', 'Studio Director, Lumen Fitness', 'The results speak for themselves — fully booked classes within two months of launch.', 4 ),
		array( 'James Okafor', 'CTO, Orbit', 'A rare mix of design sensibility and technical rigour. Highly recommended for any serious project.', 5 ),
	);

	foreach ( $testimonials as $i => $testimonial ) {
		list( $name, $role, $quote, $rating ) = $testimonial;

		if ( cxc_get_post_by_title( $name, 'cxc_testimonial' ) ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'cxc_testimonial',
				'post_title'   => $name,
				'post_content' => $quote,
				'post_status'  => 'publish',
				'menu_order'   => $i,
			)
		);

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, '_cxc_author_name', $name );
			update_post_meta( $post_id, '_cxc_author_role', $role );
			update_post_meta( $post_id, '_cxc_rating', $rating );
			update_post_meta( $post_id, '_cxc_featured', $i < 6 ? '1' : '0' );
		}
	}
}

/**
 * Create sample team members.
 */
function cxc_demo_create_team() {
	$team = array(
		array( 'Chris Edwards', 'Founder & Creative Director' ),
		array( 'Amelia Foster', 'Lead Designer' ),
		array( 'Daniel Osei', 'Senior Developer' ),
		array( 'Grace Liu', 'Project Manager' ),
	);

	foreach ( $team as $i => $member ) {
		list( $name, $role ) = $member;

		if ( cxc_get_post_by_title( $name, 'cxc_team' ) ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'cxc_team',
				'post_title'   => $name,
				'post_content' => sprintf(
					/* translators: 1: person's first name, 2: their role */
					__( '%1$s leads as our %2$s, bringing years of experience helping brands grow online.', 'chrisxcreative' ),
					explode( ' ', $name )[0],
					$role
				),
				'post_status'  => 'publish',
				'menu_order'   => $i,
			)
		);

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, '_cxc_role', $role );
		}
	}
}

/**
 * Create sample blog posts.
 */
function cxc_demo_create_posts() {
	$posts = array(
		array( 'Five Web Design Trends to Watch This Year', 'From bold typography to subtle motion, here is what is shaping the best websites right now and how to use these trends without dating your site.' ),
		array( 'How to Brief a Web Design Agency (The Right Way)', 'A great brief is the difference between a smooth project and a frustrating one. Here is exactly what to include before your next kickoff call.' ),
		array( 'Why Website Speed Still Wins Customers', 'Every extra second of load time costs you visitors and revenue. Here is how we keep every ChrisXCreative build fast by default.' ),
	);

	foreach ( $posts as $post_data ) {
		list( $title, $content ) = $post_data;

		if ( cxc_get_post_by_title( $title, 'post' ) ) {
			continue;
		}

		wp_insert_post(
			array(
				'post_type'    => 'post',
				'post_title'   => $title,
				'post_content' => '<!-- wp:paragraph --><p>' . $content . '</p><!-- /wp:paragraph -->',
				'post_status'  => 'publish',
			)
		);
	}
}

/**
 * Create demo pages (About, Contact) and assign navigation menus.
 */
function cxc_demo_create_pages_and_menus() {
	// Front page: intentionally left blank so front-page.php renders the
	// built-in marketing homepage (hero, services, portfolio, testimonials…).
	$home_id = cxc_demo_get_or_create_page( __( 'Home', 'chrisxcreative' ), '' );
	$blog_id = cxc_demo_get_or_create_page( __( 'Blog', 'chrisxcreative' ), '' );

	$about_content  = '<!-- wp:paragraph --><p>' . __( 'We are a small, senior team who care deeply about the details. ChrisXCreative was founded to help ambitious businesses look and perform their best online — without the agency overhead.', 'chrisxcreative' ) . '</p><!-- /wp:paragraph -->';
	$about_content .= cxc_pattern_stats();
	$about_id = cxc_demo_get_or_create_page( __( 'About Us', 'chrisxcreative' ), $about_content );

	$contact_id = cxc_demo_get_or_create_page( __( 'Contact', 'chrisxcreative' ), '', 'page-templates/template-contact.php' );

	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}
	if ( $blog_id ) {
		update_option( 'page_for_posts', $blog_id );
	}

	cxc_demo_create_menu(
		__( 'Primary Menu', 'chrisxcreative' ),
		'primary',
		array(
			array( 'title' => __( 'Home', 'chrisxcreative' ), 'url' => home_url( '/' ) ),
			array( 'title' => __( 'About', 'chrisxcreative' ), 'url' => $about_id ? get_permalink( $about_id ) : home_url( '/' ) ),
			array( 'title' => __( 'Services', 'chrisxcreative' ), 'url' => get_post_type_archive_link( 'cxc_service' ) ),
			array( 'title' => __( 'Portfolio', 'chrisxcreative' ), 'url' => get_post_type_archive_link( 'cxc_portfolio' ) ),
			array( 'title' => __( 'Blog', 'chrisxcreative' ), 'url' => $blog_id ? get_permalink( $blog_id ) : home_url( '/' ) ),
			array( 'title' => __( 'Contact', 'chrisxcreative' ), 'url' => $contact_id ? get_permalink( $contact_id ) : home_url( '/' ) ),
		)
	);

	cxc_demo_create_menu(
		__( 'Footer Menu', 'chrisxcreative' ),
		'footer',
		array(
			array( 'title' => __( 'About', 'chrisxcreative' ), 'url' => $about_id ? get_permalink( $about_id ) : home_url( '/' ) ),
			array( 'title' => __( 'Portfolio', 'chrisxcreative' ), 'url' => get_post_type_archive_link( 'cxc_portfolio' ) ),
			array( 'title' => __( 'Contact', 'chrisxcreative' ), 'url' => $contact_id ? get_permalink( $contact_id ) : home_url( '/' ) ),
		)
	);
}

/**
 * Get an existing page by title or create it.
 *
 * @param string $title    Page title.
 * @param string $content  Page content.
 * @param string $template Optional page template file.
 * @return int Page ID.
 */
function cxc_demo_get_or_create_page( $title, $content = '', $template = '' ) {
	$existing = cxc_get_post_by_title( $title, 'page' );
	if ( $existing ) {
		return $existing->ID;
	}

	$page_id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_title'   => $title,
			'post_content' => $content,
			'post_status'  => 'publish',
		)
	);

	if ( $page_id && ! is_wp_error( $page_id ) && $template ) {
		update_post_meta( $page_id, '_wp_page_template', $template );
	}

	return is_wp_error( $page_id ) ? 0 : $page_id;
}

/**
 * Create a nav menu (if it doesn't already exist) and assign it to a location.
 *
 * @param string $name     Menu name.
 * @param string $location Theme menu location slug.
 * @param array  $items    Array of ['title' => ..., 'url' => ...].
 */
function cxc_demo_create_menu( $name, $location, $items ) {
	$menu = wp_get_nav_menu_object( $name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $name );
	} else {
		$menu_id = $menu->term_id;
	}

	if ( is_wp_error( $menu_id ) ) {
		return;
	}

	$existing_items = wp_get_nav_menu_items( $menu_id );
	if ( empty( $existing_items ) ) {
		foreach ( $items as $item ) {
			if ( empty( $item['url'] ) ) {
				continue;
			}
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'     => $item['title'],
					'menu-item-url'       => $item['url'],
					'menu-item-status'    => 'publish',
				)
			);
		}
	}

	$locations                = get_theme_mod( 'nav_menu_locations', array() );
	$locations[ $location ]   = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}
