<?php
/**
 * mo7ox functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mo7ox
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mo7ox_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on mo7ox, use a find and replace
		* to change 'mo7ox' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'mo7ox', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'mo7ox' ),
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

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'mo7ox_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'mo7ox_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mo7ox_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mo7ox_content_width', 640 );
}
add_action( 'after_setup_theme', 'mo7ox_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mo7ox_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'mo7ox' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'mo7ox' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'mo7ox_widgets_init' );

/**
 * Enqueue scripts and styles.
 */

function mo7ox_scripts() {
	wp_enqueue_style( 'mo7ox-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'mo7ox-main', get_template_directory_uri() . '/css/main.css' );
	wp_style_add_data( 'mo7ox-style', 'rtl', 'replace' );

	wp_enqueue_script( 'mo7ox-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'mo7ox-main', get_template_directory_uri() . '/js/main.js' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'mo7ox_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}




function mo7ox_add_social_menu() {
    add_menu_page(
        'Social Media Links', // Page title
        'Social Media', // Menu title
        'manage_options', // Capability
        'mo7ox-social-links', // Menu slug
        'mo7ox_social_page', // Function callback
        'dashicons-share', // Icon
        20 // Position
    );
}
add_action('admin_menu', 'mo7ox_add_social_menu');

function mo7ox_social_page() {
    ?>
    <div class="wrap">
        <h1>Social Media Links</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('mo7ox_social_group');
            do_settings_sections('mo7ox-social-links');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function mo7ox_register_social_settings() {
    register_setting('mo7ox_social_group', 'mo7ox_social_links');

    add_settings_section(
        'mo7ox_social_section',
        'Manage Social Media Links',
        null,
        'mo7ox-social-links'
    );

    add_settings_field(
        'mo7ox_social_links',
        'Social Media (JSON Format)',
        'mo7ox_social_field_callback',
        'mo7ox-social-links',
        'mo7ox_social_section'
    );
}
add_action('admin_init', 'mo7ox_register_social_settings');

function mo7ox_social_field_callback() {
    $socials = get_option('mo7ox_social_links', '[]');
    ?>
    <textarea name="mo7ox_social_links" rows="5" cols="50"><?php echo esc_textarea($socials); ?></textarea>
    <p>Enter social media links in JSON format:</p>
    <pre>
[
    {"url": "https://facebook.com", "icon": "fab fa-facebook", "color": "#1877f2"},
    {"url": "https://twitter.com", "icon": "fab fa-twitter", "color": "#1da1f2"}
]
    </pre>
    <?php
}

function mo7ox_display_social_links() {
    $socials_json = get_option('mo7ox_social_links', '[]');
    $socials = json_decode($socials_json, true);

    if (!empty($socials)) :
        echo '<div class="flex space-x-4">';
        foreach ($socials as $social) :
            $url = esc_url($social['url']);
            $icon = esc_attr($social['icon']);
            $color = esc_attr($social['color']);
            ?>
            <a href="<?php echo $url; ?>" target="_blank"
               class="hover:text-[<?php echo $color?>] text-white visited:text-white p-3text-white text-2xl"
               style="">
                <i class="<?php echo $icon; ?>"></i>
            </a>
        <?php endforeach;
        echo '</div>';
    endif;
}


// custom posts 


// Register Custom Post Types
function mo7ox_register_courses_post_types() {
    register_post_type('courses', array(
        'label'         => __('Courses', 'mo7ox'),
        'public'        => true,
        'menu_position' => 5,
        'has_archive'   => true,
        'rewrite'       => array('slug' => 'courses'),
        'supports'      => array('title', 'thumbnail'),
        'labels'        => array(
            'name'          => __('Courses', 'mo7ox'),
            'singular_name' => __('Course', 'mo7ox'),
        ),
    ));

    register_post_type('course_details', array(
        'label'         => __('Course Details', 'mo7ox'),
        'public'        => true,
        'menu_position' => 6,
        'supports'      => array('title', 'editor', 'thumbnail'),
        'labels'        => array(
            'name'          => __('Course Details', 'mo7ox'),
            'singular_name' => __('Course Detail', 'mo7ox'),
        ),
    ));
}
add_action('init', 'mo7ox_register_courses_post_types');

// Add Course Color Field
function mo7ox_course_color_metabox() {
    add_meta_box('mo7ox_course_color', 'Course Color', function($post) {
        $color = get_post_meta($post->ID, '_mo7ox_course_color', true);
        echo '<input type="color" name="mo7ox_course_color" value="' . esc_attr($color) . '">';
    }, 'courses', 'side');
}
add_action('add_meta_boxes', 'mo7ox_course_color_metabox');

function mo7ox_save_course_color($post_id) {
    if (isset($_POST['mo7ox_course_color'])) {
        update_post_meta($post_id, '_mo7ox_course_color', sanitize_hex_color($_POST['mo7ox_course_color']));
    }
}
add_action('save_post', 'mo7ox_save_course_color');


// Add Course Selection in Course Details
function mo7ox_course_selection_metabox() {
    add_meta_box('mo7ox_course_selection', 'Select Course', function($post) {
        $selected_course = get_post_meta($post->ID, '_mo7ox_selected_course', true);
        $courses = get_posts(array('post_type' => 'courses', 'numberposts' => -1));
        echo '<select name="mo7ox_selected_course">';
        echo '<option value="">Select a Course</option>';
        foreach ($courses as $course) {
            echo '<option value="' . $course->ID . '" ' . selected($selected_course, $course->ID, false) . '>' . esc_html($course->post_title) . '</option>';
        }
        echo '</select>';
    }, 'course_details', 'side');
}
add_action('add_meta_boxes', 'mo7ox_course_selection_metabox');

function mo7ox_save_course_selection($post_id) {
    if (isset($_POST['mo7ox_selected_course'])) {
        update_post_meta($post_id, '_mo7ox_selected_course', sanitize_text_field($_POST['mo7ox_selected_course']));
    }
}
add_action('save_post', 'mo7ox_save_course_selection');

function mo7ox_course_video_metabox() {
    add_meta_box('mo7ox_course_video', 'Course Video URL', function($post) {
        $video_url = get_post_meta($post->ID, '_mo7ox_course_video_url', true);
        echo '<input type="url" name="mo7ox_course_video_url" value="' . esc_url($video_url) . '" style="width: 100%;">';
    }, 'course_details', 'normal');
}
add_action('add_meta_boxes', 'mo7ox_course_video_metabox');

function mo7ox_save_course_video($post_id) {
    if (isset($_POST['mo7ox_course_video_url'])) {
        update_post_meta($post_id, '_mo7ox_course_video_url', esc_url($_POST['mo7ox_course_video_url']));
    }
}
add_action('save_post', 'mo7ox_save_course_video');


function mo7ox_get_course_details($course_id) {
    // Get the course details linked to the specific course
    $course_details = get_posts(array(
        'post_type' => 'course_details',
        'meta_query' => array(
            array(
                'key' => '_mo7ox_selected_course', // The meta key that links course_details to courses
                'value' => $course_id,
                'compare' => '='
            )
        ),
        'numberposts' => -1 // Get all related course details
    ));

    return $course_details; // Return the array of course details
}

// making for tools too
function mo7ox_register_tools_post_type() {
    $labels = array(
        'name'                  => __('Tools', 'mo7ox'),
        'singular_name'         => __('Tool', 'mo7ox'),
        'menu_name'             => __('Tools', 'mo7ox'),
        'name_admin_bar'        => __('Tool', 'mo7ox'),
        'add_new'               => __('Add New Tool', 'mo7ox'),
        'add_new_item'          => __('Add New Tool', 'mo7ox'),
        'new_item'              => __('New Tool', 'mo7ox'),
        'edit_item'             => __('Edit Tool', 'mo7ox'),
        'view_item'             => __('View Tool', 'mo7ox'),
        'all_items'             => __('All Tools', 'mo7ox'),
        'search_items'          => __('Search Tools', 'mo7ox'),
        'not_found'             => __('No Tools found', 'mo7ox'),
        'not_found_in_trash'    => __('No Tools found in Trash', 'mo7ox'),
    );

    $args = array(
        'label'                 => __('Tools', 'mo7ox'),
        'description'           => __('Custom post type for Tools', 'mo7ox'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true, // Enables the archive page
        'rewrite'               => array('slug' => 'tools'), // Sets the URL structure
        'hierarchical'          => false,
        'exclude_from_search'   => false,
        'capability_type'       => 'post',
    );

    register_post_type('tools', $args);
}
add_action('init', 'mo7ox_register_tools_post_type');







// ctfs Post Type

function mo7ox_register_Ctfs_post_type() {
    // Ctfs Post Type
    $labels_Ctfs = array(
        'name'                  => _x('Ctfs', 'Post Type General Name', 'mo7ox'),
        'singular_name'         => _x('Ctf', 'Post Type Singular Name', 'mo7ox'),
        'menu_name'             => __('Ctfs', 'mo7ox'),
        'name_admin_bar'        => __('Ctf', 'mo7ox'),
        'add_new'               => __('Add New', 'mo7ox'),
        'add_new_item'          => __('Add New Ctf', 'mo7ox'),
        'new_item'              => __('New Ctf', 'mo7ox'),
        'edit_item'             => __('Edit Ctf', 'mo7ox'),
        'view_item'             => __('View Ctf', 'mo7ox'),
        'all_items'             => __('All Ctfs', 'mo7ox'),
        'search_items'          => __('Search Ctfs', 'mo7ox'),
        'not_found'             => __('No Ctfs found', 'mo7ox'),
        'not_found_in_trash'    => __('No Ctfs found in Trash', 'mo7ox'),
    );

    $args_Ctfs = array(
        'label'                 => __('Ctfs', 'mo7ox'),
        'description'           => __('Custom post type for Ctfs', 'mo7ox'),
        'labels'                => $labels_Ctfs,
        'supports'              => array('title', 'thumbnail'),
        'public'                => true,
        'show_in_menu'          => true,
        'menu_position'         => 7,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'hierarchical'          => false,
        'exclude_from_search'   => false,
        'capability_type'       => 'post',
    );

    register_post_type('Ctfs', $args_Ctfs);

    // Ctf Details Post Type
    $labels_details = array(
        'name'                  => _x('Ctf Details', 'Post Type General Name', 'mo7ox'),
        'singular_name'         => _x('Ctf Detail', 'Post Type Singular Name', 'mo7ox'),
        'menu_name'             => __('Ctf Details', 'mo7ox'),
        'name_admin_bar'        => __('Ctf Detail', 'mo7ox'),
        'add_new'               => __('Add New', 'mo7ox'),
        'add_new_item'          => __('Add New Ctf Detail', 'mo7ox'),
        'new_item'              => __('New Ctf Detail', 'mo7ox'),
        'edit_item'             => __('Edit Ctf Detail', 'mo7ox'),
        'view_item'             => __('View Ctf Detail', 'mo7ox'),
        'all_items'             => __('All Ctf Details', 'mo7ox'),
        'search_items'          => __('Search Ctf Details', 'mo7ox'),
        'not_found'             => __('No Ctf details found', 'mo7ox'),
        'not_found_in_trash'    => __('No Ctf details found in Trash', 'mo7ox'),
    );

    $args_details = array(
        'label'                 => __('Ctf Details', 'mo7ox'),
        'description'           => __('Custom post type for Ctf details', 'mo7ox'),
        'labels'                => $labels_details,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'public'                => true,
        'show_in_menu'          => true,
        'menu_position'         => 8,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'hierarchical'          => false,
        'exclude_from_search'   => false,
        'capability_type'       => 'post',
    );

    register_post_type('Ctf_details', $args_details);
}
add_action('init', 'mo7ox_register_Ctfs_post_type');


// ----------------------
// ADD Ctf SELECTION FIELD TO Ctf DETAILS
// ----------------------
function mo7ox_add_Ctf_selection_metabox() {
    add_meta_box(
        'mo7ox_Ctf_selection',
        'Select Ctf',
        'mo7ox_Ctf_selection_callback',
        'Ctf_details',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'mo7ox_add_Ctf_selection_metabox');

function mo7ox_Ctf_selection_callback($post) {
    $selected_Ctf = get_post_meta($post->ID, '_mo7ox_selected_Ctf', true);
    $Ctfs = get_posts(array('post_type' => 'Ctfs', 'numberposts' => -1));

    echo '<label for="mo7ox_selected_Ctf">Select Ctf:</label><br>';
    echo '<select id="mo7ox_selected_Ctf" name="mo7ox_selected_Ctf">';
    foreach ($Ctfs as $Ctf) {
        echo '<option value="' . $Ctf->ID . '" ' . selected($selected_Ctf, $Ctf->ID, false) . '>' . esc_html($Ctf->post_title) . '</option>';
    }
    echo '</select>';
}

function mo7ox_save_Ctf_selection($post_id) {
    if (isset($_POST['mo7ox_selected_Ctf'])) {
        update_post_meta($post_id, '_mo7ox_selected_Ctf', sanitize_text_field($_POST['mo7ox_selected_Ctf']));
    }
}
add_action('save_post', 'mo7ox_save_Ctf_selection');



// 2️⃣ Add Custom Meta Boxes for Ctf Details
function mo7ox_add_Ctf_details_meta_boxes() {

    add_meta_box(
        'mo7ox_Ctf_selector',
        __('Select Ctf', 'mo7ox'),
        'mo7ox_Ctf_selector_callback',
        'Ctf_details',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'mo7ox_add_Ctf_details_meta_boxes');
// Callback for Ctf Selector Meta Box
function mo7ox_Ctf_selector_callback($post) {
    $Ctfs = get_posts(array('post_type' => 'Ctfs', 'numberposts' => -1));
    $selected_Ctf = get_post_meta($post->ID, '_mo7ox_selected_Ctf', true);
    ?>
    <label for="mo7ox_selected_Ctf"><?php _e('Select a Ctf:', 'mo7ox'); ?></label>
    <select id="mo7ox_selected_Ctf" name="mo7ox_selected_Ctf" style="width: 100%;">
        <option value=""><?php _e('Select a Ctf', 'mo7ox'); ?></option>
        <?php foreach ($Ctfs as $Ctf) : ?>
            <option value="<?php echo esc_attr($Ctf->ID); ?>" <?php selected($selected_Ctf, $Ctf->ID); ?>>
                <?php echo esc_html($Ctf->post_title); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
}

function mo7ox_save_Ctf_details_meta($post_id) {
    if (array_key_exists('mo7ox_selected_Ctf', $_POST)) {
        update_post_meta($post_id, '_mo7ox_selected_Ctf', sanitize_text_field($_POST['mo7ox_selected_Ctf']));
    }
}
add_action('save_post', 'mo7ox_save_Ctf_details_meta');





function mo7ox_get_ctf_details($course_id) {
    $ctf_details = get_posts(array(
        'post_type' => 'ctf_details',
        'meta_query' => array(
            array(
                'key' => '_mo7ox_selected_ctf',
                'value' => $course_id,
                'compare' => '='
            )
        ),
        'numberposts' => -1
    ));

    return $ctf_details; 
}




function mo7ox_register_Bcamps_post_type() {
    // Bcamps Post Type
    $labels_Bcamps = array(
        'name'                  => _x('Bcamps', 'Post Type General Name', 'mo7ox'),
        'singular_name'         => _x('Bcamp', 'Post Type Singular Name', 'mo7ox'),
        'menu_name'             => __('Bcamps', 'mo7ox'),
        'name_admin_bar'        => __('Bcamp', 'mo7ox'),
        'add_new'               => __('Add New', 'mo7ox'),
        'add_new_item'          => __('Add New Bcamp', 'mo7ox'),
        'new_item'              => __('New Bcamp', 'mo7ox'),
        'edit_item'             => __('Edit Bcamp', 'mo7ox'),
        'view_item'             => __('View Bcamp', 'mo7ox'),
        'all_items'             => __('All Bcamps', 'mo7ox'),
        'search_items'          => __('Search Bcamps', 'mo7ox'),
        'not_found'             => __('No Bcamps found', 'mo7ox'),
        'not_found_in_trash'    => __('No Bcamps found in Trash', 'mo7ox'),
    );

    $args_Bcamps = array(
        'label'                 => __('Bcamps', 'mo7ox'),
        'description'           => __('Custom post type for Bcamps', 'mo7ox'),
        'labels'                => $labels_Bcamps,
        'supports'              => array('title', 'thumbnail', 'author' ),
        'public'                => true,
        'show_in_menu'          => true,
        'menu_position'         => 7,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'hierarchical'          => false,
        'exclude_from_search'   => false,
        'capability_type'       => 'post',
    );

    register_post_type('Bcamps', $args_Bcamps);

    // Bcamp Details Post Type
    $labels_details = array(
        'name'                  => _x('Bcamp Details', 'Post Type General Name', 'mo7ox'),
        'singular_name'         => _x('Bcamp Detail', 'Post Type Singular Name', 'mo7ox'),
        'menu_name'             => __('Bcamp Details', 'mo7ox'),
        'name_admin_bar'        => __('Bcamp Detail', 'mo7ox'),
        'add_new'               => __('Add New', 'mo7ox'),
        'add_new_item'          => __('Add New Bcamp Detail', 'mo7ox'),
        'new_item'              => __('New Bcamp Detail', 'mo7ox'),
        'edit_item'             => __('Edit Bcamp Detail', 'mo7ox'),
        'view_item'             => __('View Bcamp Detail', 'mo7ox'),
        'all_items'             => __('All Bcamp Details', 'mo7ox'),
        'search_items'          => __('Search Bcamp Details', 'mo7ox'),
        'not_found'             => __('No Bcamp details found', 'mo7ox'),
        'not_found_in_trash'    => __('No Bcamp details found in Trash', 'mo7ox'),
    );

    $args_details = array(
        'label'                 => __('Bcamp Details', 'mo7ox'),
        'description'           => __('Custom post type for Bcamp details', 'mo7ox'),
        'labels'                => $labels_details,
        'supports'              => array('title', 'editor', 'thumbnail', 'author' ),
        'public'                => true,
        'show_in_menu'          => true,
        'menu_position'         => 8,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'hierarchical'          => false,
        'exclude_from_search'   => false,
        'capability_type'       => 'post',

    );

    register_post_type('Bcamp_details', $args_details);
}
add_action('init', 'mo7ox_register_Bcamps_post_type');


// ----------------------
// ADD Bcamp SELECTION FIELD TO Bcamp DETAILS
// ----------------------
function mo7ox_add_Bcamp_selection_metabox() {
    add_meta_box(
        'mo7ox_Bcamp_selection',
        'Select Bcamp',
        'mo7ox_Bcamp_selection_callback',
        'Bcamp_details',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'mo7ox_add_Bcamp_selection_metabox');

function mo7ox_Bcamp_selection_callback($post) {
    $selected_Bcamp = get_post_meta($post->ID, '_mo7ox_selected_Bcamp', true);
    $Bcamps = get_posts(array('post_type' => 'Bcamps', 'numberposts' => -1));

    echo '<label for="mo7ox_selected_Bcamp">Select Bcamp:</label><br>';
    echo '<select id="mo7ox_selected_Bcamp" name="mo7ox_selected_Bcamp">';
    foreach ($Bcamps as $Bcamp) {
        echo '<option value="' . $Bcamp->ID . '" ' . selected($selected_Bcamp, $Bcamp->ID, false) . '>' . esc_html($Bcamp->post_title) . '</option>';
    }
    echo '</select>';
}

function mo7ox_save_Bcamp_selection($post_id) {
    if (isset($_POST['mo7ox_selected_Bcamp'])) {
        update_post_meta($post_id, '_mo7ox_selected_Bcamp', sanitize_text_field($_POST['mo7ox_selected_Bcamp']));
    }
}
add_action('save_post', 'mo7ox_save_Bcamp_selection');



// 2️⃣ Add Custom Meta Boxes for Bcamp Details
function mo7ox_add_Bcamp_details_meta_boxes() {

    add_meta_box(
        'mo7ox_Bcamp_selector',
        __('Select Bcamp', 'mo7ox'),
        'mo7ox_Bcamp_selector_callback',
        'Bcamp_details',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'mo7ox_add_Bcamp_details_meta_boxes');
// Callback for Bcamp Selector Meta Box
function mo7ox_Bcamp_selector_callback($post) {
    $Bcamps = get_posts(array('post_type' => 'Bcamps', 'numberposts' => -1));
    $selected_Bcamp = get_post_meta($post->ID, '_mo7ox_selected_Bcamp', true);
    ?>
    <label for="mo7ox_selected_Bcamp"><?php _e('Select a Bcamp:', 'mo7ox'); ?></label>
    <select id="mo7ox_selected_Bcamp" name="mo7ox_selected_Bcamp" style="width: 100%;">
        <option value=""><?php _e('Select a Bcamp', 'mo7ox'); ?></option>
        <?php foreach ($Bcamps as $Bcamp) : ?>
            <option value="<?php echo esc_attr($Bcamp->ID); ?>" <?php selected($selected_Bcamp, $Bcamp->ID); ?>>
                <?php echo esc_html($Bcamp->post_title); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
}

function mo7ox_save_Bcamp_details_meta($post_id) {
    if (array_key_exists('mo7ox_selected_Bcamp', $_POST)) {
        update_post_meta($post_id, '_mo7ox_selected_Bcamp', sanitize_text_field($_POST['mo7ox_selected_Bcamp']));
    }
}
add_action('save_post', 'mo7ox_save_Bcamp_details_meta');





function mo7ox_get_bcamps_details($course_id) {
    $bcamp_details = get_posts(array(
        'post_type' => 'bcamp_details',
        'meta_query' => array(
            array(
                'key' => '_mo7ox_selected_bcamp',
                'value' => $course_id,
                'compare' => '='
            )
        ),
        'numberposts' => -1
    ));

    return $bcamp_details; 
}




