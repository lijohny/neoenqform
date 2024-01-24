<?php
/**
 * neoEnqForm functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package neoEnqForm
 */

if ( ! defined( 'NEOENQFORM_VERSION' ) ) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define( 'NEOENQFORM_VERSION', '0.1.0' );
}

if ( ! defined( 'NEOENQFORM_TYPOGRAPHY_CLASSES' ) ) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `neoenqform_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they’re removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define(
		'NEOENQFORM_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

if ( ! function_exists( 'neoenqform_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function neoenqform_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on neoEnqForm, use a find and replace
		 * to change 'neoenqform' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'neoenqform', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'neoenqform' ),
				'menu-2' => __( 'Footer Menu', 'neoenqform' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );
		add_editor_style( 'style-editor-extra.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Remove support for block templates.
		remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'neoenqform_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function neoenqform_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'neoenqform' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'neoenqform' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'neoenqform_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
// function enqueue_jquery() {
//     wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.4.min.js', array(), '3.6.4', true);
// }

// add_action('wp_enqueue_scripts', 'enqueue_jquery');


function neoenqform_scripts() {
	wp_enqueue_style( 'neoenqform-style', get_stylesheet_uri(), array(), NEOENQFORM_VERSION );
	wp_enqueue_script( 'neoenqform-script', get_template_directory_uri() . '/js/script.min.js', array(), NEOENQFORM_VERSION, true );
	wp_enqueue_script( 'neoenqformValidation-script', get_template_directory_uri() . '/js/form.js', array(), NEOENQFORM_VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'neoenqform_scripts' );



/**
 * Enqueue the block editor script.
 */
function neoenqform_enqueue_block_editor_script() {
	wp_enqueue_script(
		'neoenqform-editor',
		get_template_directory_uri() . '/js/block-editor.min.js',
		array(
			'wp-blocks',
			'wp-edit-post',
		),
		NEOENQFORM_VERSION,
		true
	);

}
add_action( 'enqueue_block_editor_assets', 'neoenqform_enqueue_block_editor_script' );

/**
 * Enqueue the script necessary to support Tailwind Typography in the block
 * editor, using an inline script to create a JavaScript array containing the
 * Tailwind Typography classes from NEOENQFORM_TYPOGRAPHY_CLASSES.
 */
function neoenqform_enqueue_typography_script() {
	if ( is_admin() ) {
		wp_enqueue_script(
			'neoenqform-typography',
			get_template_directory_uri() . '/js/tailwind-typography-classes.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			NEOENQFORM_VERSION,
			true
		);
		wp_add_inline_script( 'neoenqform-typography', "tailwindTypographyClasses = '" . esc_attr( NEOENQFORM_TYPOGRAPHY_CLASSES ) . "'.split(' ');", 'before' );
	}
}
add_action( 'enqueue_block_assets', 'neoenqform_enqueue_typography_script' );



/* 
assesment code's start
*/

function ajax_form_scripts(){
	$email_sending = array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'security' => wp_create_nonce('form_submit'),
	);

	wp_localize_script('neoenqformValidation-script', 'emailSending_ajax', $email_sending);
}
add_action('wp_enqueue_scripts', 'ajax_form_scripts');




add_action('wp_ajax_neo_send_email', 'neo_send_email');
add_action('wp_ajax_nopriv_neo_send_email', 'neo_send_email'); 

function neo_send_email() {
	parse_str(file_get_contents('php://input'),$data);
	$name = $data['form_data']['name'];
	$email = $data['form_data']['email'];
	$phone = $data['form_data']['phone'];
	$message = $data['form_data']['message'];
	if (!is_email($email)) {
			$response = array(
					'status' => 'error',
					'message' => 'Invalid email address',
			);
	} else {
			$to = 'lijo@neoito.com';
			$subject = 'New Form Submission';
			$email_body = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";
			$headers = 'From: ' . $email;
			$sent = wp_mail($to, $subject, $email_body, $headers);
			if ($sent) {
					$response = array(
							'status' => 'success',
							'message' => 'Email sent successfully',
					);
			} else {
					$response = array(
							'status' => 'error',
							'message' => "Email was not sent an error occured",
					);
					neo_save_form_entries();
			}
	}
	header('Content-Type: application/json');
	echo json_encode($response);
	wp_die();
}

function neo_save_form_entries() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        parse_str(file_get_contents('php://input'), $data);
        $name = $data['form_data']['name'];
        $email = $data['form_data']['email'];
        $phone = $data['form_data']['phone'];
        $message = $data['form_data']['message'];

        $content_body = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";

        $post_data = array(
            'post_title'   => $name,
            'post_content' => $content_body,
            'post_type'    => 'neo_enquiries',
            'post_status'  => 'publish',
        );

        $post_id = wp_insert_post($post_data);
    }
}

add_action('template_redirect', 'neo_handle_form_submission');

function neo_handle_form_submission() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['neo_contact_form_nonce'])) {
        if (wp_verify_nonce($_POST['neo_contact_form_nonce'], 'neo_contact_form')) {
            neo_send_email();
            neo_save_form_entries();
        }
    }
}


include("shortcode.php");

function neo_register_enquiries_post_type() {
    $labels = array(
        'name'                  => 'Neo Enquiries',
        'singular_name'         => 'Neo Enquiry',
        'menu_name'             => 'Neo Enquiries',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Neo Enquiry',
        'edit_item'             => 'Edit Neo Enquiry',
        'new_item'              => 'New Neo Enquiry',
        'view_item'             => 'View Neo Enquiry',
        'search_items'          => 'Search Neo Enquiries',
        'not_found'             => 'No Neo Enquiries found',
        'not_found_in_trash'    => 'No Neo Enquiries found in Trash',
        'parent_item_colon'     => 'Parent Neo Enquiry:',
        'all_items'             => 'All Neo Enquiries',
        'archives'              => 'Neo Enquiry Archives',
        'insert_into_item'      => 'Insert into Neo Enquiry',
        'uploaded_to_this_item' => 'Uploaded to this Neo Enquiry',
        'featured_image'        => 'Featured Image',
        'set_featured_image'    => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image'    => 'Use as featured image',
        'filter_items_list'     => 'Filter Neo Enquiries list',
        'items_list_navigation' => 'Neo Enquiries list navigation',
        'items_list'            => 'Neo Enquiries list',
        'item_published'        => 'Neo Enquiry published',
        'item_published_privately' => 'Neo Enquiry published privately',
        'item_reverted_to_draft' => 'Neo Enquiry reverted to draft',
        'item_scheduled'        => 'Neo Enquiry scheduled',
        'item_updated'          => 'Neo Enquiry updated',
    );
    $args = array(
			'label'                 => 'Neo Enquiries',
			'description'           => 'Form enquiries',
			'labels'                => $labels,
			'public'                => false, 
			'publicly_queryable'    => false, 
			'show_ui'               => true,
			'show_in_menu'          => true,
			'query_var'             => true,
			'rewrite'               => array('slug' => 'neo-enquiries'),
			'capability_type'       => 'post',
			'has_archive'           => false, 
			'hierarchical'          => false,
			'menu_position'         => null,
			'supports'              => array('title', 'editor'),
    );

    register_post_type('neo_enquiries', $args);
}
add_action('init', 'neo_register_enquiries_post_type');

/* 
assesment code's end
*/

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function neoenqform_tinymce_add_class( $settings ) {
	$settings['body_class'] = NEOENQFORM_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'neoenqform_tinymce_add_class' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

// add_action('wp_enqueue_scripts', 'neoito_scripts');




// include("formvalidation.php")
?>
