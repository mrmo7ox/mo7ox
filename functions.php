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

// 1️⃣ Register Custom Post Types
function mo7ox_register_courses_post_type() {
    // Courses Post Type
    $labels_courses = array(
        'name'                  => _x('Courses', 'Post Type General Name', 'mo7ox'),
        'singular_name'         => _x('Course', 'Post Type Singular Name', 'mo7ox'),
        'menu_name'             => __('Courses', 'mo7ox'),
        'name_admin_bar'        => __('Course', 'mo7ox'),
        'add_new'               => __('Add New', 'mo7ox'),
        'add_new_item'          => __('Add New Course', 'mo7ox'),
        'new_item'              => __('New Course', 'mo7ox'),
        'edit_item'             => __('Edit Course', 'mo7ox'),
        'view_item'             => __('View Course', 'mo7ox'),
        'all_items'             => __('All Courses', 'mo7ox'),
        'search_items'          => __('Search Courses', 'mo7ox'),
        'not_found'             => __('No courses found', 'mo7ox'),
        'not_found_in_trash'    => __('No courses found in Trash', 'mo7ox'),
    );

    $args_courses = array(
        'label'                 => __('Courses', 'mo7ox'),
        'description'           => __('Custom post type for courses', 'mo7ox'),
        'labels'                => $labels_courses,
        'supports'              => array('title', 'thumbnail'),
        'public'                => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'hierarchical'          => false,
        'exclude_from_search'   => false,
        'capability_type'       => 'post',
    );

    register_post_type('courses', $args_courses);

    // Course Details Post Type
    $labels_details = array(
        'name'                  => _x('Course Details', 'Post Type General Name', 'mo7ox'),
        'singular_name'         => _x('Course Detail', 'Post Type Singular Name', 'mo7ox'),
        'menu_name'             => __('Course Details', 'mo7ox'),
        'name_admin_bar'        => __('Course Detail', 'mo7ox'),
        'add_new'               => __('Add New', 'mo7ox'),
        'add_new_item'          => __('Add New Course Detail', 'mo7ox'),
        'new_item'              => __('New Course Detail', 'mo7ox'),
        'edit_item'             => __('Edit Course Detail', 'mo7ox'),
        'view_item'             => __('View Course Detail', 'mo7ox'),
        'all_items'             => __('All Course Details', 'mo7ox'),
        'search_items'          => __('Search Course Details', 'mo7ox'),
        'not_found'             => __('No course details found', 'mo7ox'),
        'not_found_in_trash'    => __('No course details found in Trash', 'mo7ox'),
    );

    $args_details = array(
        'label'                 => __('Course Details', 'mo7ox'),
        'description'           => __('Custom post type for course details', 'mo7ox'),
        'labels'                => $labels_details,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'public'                => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'hierarchical'          => false,
        'exclude_from_search'   => false,
        'capability_type'       => 'post',
    );

    register_post_type('course_details', $args_details);
}
add_action('init', 'mo7ox_register_courses_post_type');

// ----------------------
// ADD COLOR FIELD TO COURSES
// ----------------------
function mo7ox_add_course_color_field() {
    add_meta_box(
        'mo7ox_course_color', 
        'Course Color', 
        'mo7ox_course_color_callback', 
        'courses', 
        'side', 
        'low'
    );
}
add_action('add_meta_boxes', 'mo7ox_add_course_color_field');

function mo7ox_course_color_callback($post) {
    $color = get_post_meta($post->ID, '_mo7ox_course_color', true);
    ?>
    <label for="mo7ox_course_color">Select Course Color:</label><br>
    <input type="color" id="mo7ox_course_color" name="mo7ox_course_color" value="<?php echo esc_attr($color); ?>">
    <?php
}

function mo7ox_save_course_color($post_id) {
    if (isset($_POST['mo7ox_course_color'])) {
        update_post_meta($post_id, '_mo7ox_course_color', sanitize_hex_color($_POST['mo7ox_course_color']));
    }
}
add_action('save_post', 'mo7ox_save_course_color');

// ----------------------
// ADD COURSE SELECTION FIELD TO COURSE DETAILS
// ----------------------
function mo7ox_add_course_selection_metabox() {
    add_meta_box(
        'mo7ox_course_selection',
        'Select Course',
        'mo7ox_course_selection_callback',
        'course_details',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'mo7ox_add_course_selection_metabox');

function mo7ox_course_selection_callback($post) {
    $selected_course = get_post_meta($post->ID, '_mo7ox_selected_course', true);
    $courses = get_posts(array('post_type' => 'courses', 'numberposts' => -1));

    echo '<label for="mo7ox_selected_course">Select Course:</label><br>';
    echo '<select id="mo7ox_selected_course" name="mo7ox_selected_course">';
    foreach ($courses as $course) {
        echo '<option value="' . $course->ID . '" ' . selected($selected_course, $course->ID, false) . '>' . esc_html($course->post_title) . '</option>';
    }
    echo '</select>';
}

function mo7ox_save_course_selection($post_id) {
    if (isset($_POST['mo7ox_selected_course'])) {
        update_post_meta($post_id, '_mo7ox_selected_course', sanitize_text_field($_POST['mo7ox_selected_course']));
    }
}
add_action('save_post', 'mo7ox_save_course_selection');

// ----------------------
// GET LAST 10 COURSES
// ----------------------
function mo7ox_get_last_10_courses() {
    $args = array(
        'post_type'      => 'courses',
        'posts_per_page' => 10,
        'orderby'        => 'date',
        'order'          => 'DESC'
    );
    return get_posts($args);
}

// ----------------------
// DISPLAY LAST 10 COURSES
// ----------------------
function mo7ox_display_last_10_courses() {
    $courses = mo7ox_get_last_10_courses();
    if ($courses) {
        echo '<ul>';
        foreach ($courses as $course) {
            echo '<li><a href="' . get_permalink($course->ID) . '">' . esc_html($course->post_title) . '</a></li>';
        }
        echo '</ul>';
    } else {
        echo 'No courses found.';
    }
}

// 2️⃣ Add Custom Meta Boxes for Course Details
function mo7ox_add_course_details_meta_boxes() {
    add_meta_box(
        'mo7ox_course_video_url',
        __('Course Video URL', 'mo7ox'),
        'mo7ox_course_video_url_callback',
        'course_details',
        'normal',
        'high'
    );

    add_meta_box(
        'mo7ox_course_description',
        __('Course Description', 'mo7ox'),
        'mo7ox_course_description_callback',
        'course_details',
        'normal',
        'high'
    );

    add_meta_box(
        'mo7ox_course_selector',
        __('Select Course', 'mo7ox'),
        'mo7ox_course_selector_callback',
        'course_details',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'mo7ox_add_course_details_meta_boxes');

// Callback for Video URL Meta Box
function mo7ox_course_video_url_callback($post) {
    $video_url = get_post_meta($post->ID, '_mo7ox_course_video_url', true);
    ?>
    <label for="mo7ox_video_url"><?php _e('Enter the video URL:', 'mo7ox'); ?></label>
    <input type="url" id="mo7ox_video_url" name="mo7ox_video_url" value="<?php echo esc_url($video_url); ?>" style="width: 100%;" />
    <?php
}

// Callback for Description Meta Box
function mo7ox_course_description_callback($post) {
    $description = get_post_meta($post->ID, '_mo7ox_course_description', true);
    ?>
    <label for="mo7ox_description"><?php _e('Enter the course description:', 'mo7ox'); ?></label>
    <textarea id="mo7ox_description" name="mo7ox_description" rows="5" style="width: 100%;"><?php echo esc_textarea($description); ?></textarea>
    <?php
}

// Callback for Course Selector Meta Box
function mo7ox_course_selector_callback($post) {
    $courses = get_posts(array('post_type' => 'courses', 'numberposts' => -1));
    $selected_course = get_post_meta($post->ID, '_mo7ox_selected_course', true);
    ?>
    <label for="mo7ox_selected_course"><?php _e('Select a Course:', 'mo7ox'); ?></label>
    <select id="mo7ox_selected_course" name="mo7ox_selected_course" style="width: 100%;">
        <option value=""><?php _e('Select a course', 'mo7ox'); ?></option>
        <?php foreach ($courses as $course) : ?>
            <option value="<?php echo esc_attr($course->ID); ?>" <?php selected($selected_course, $course->ID); ?>>
                <?php echo esc_html($course->post_title); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
}

// Save the Custom Fields for Course Details
function mo7ox_save_course_details_meta($post_id) {
    if (array_key_exists('mo7ox_video_url', $_POST)) {
        update_post_meta($post_id, '_mo7ox_course_video_url', esc_url($_POST['mo7ox_video_url']));
    }
    if (array_key_exists('mo7ox_description', $_POST)) {
        update_post_meta($post_id, '_mo7ox_course_description', sanitize_textarea_field($_POST['mo7ox_description']));
    }
    if (array_key_exists('mo7ox_selected_course', $_POST)) {
        update_post_meta($post_id, '_mo7ox_selected_course', sanitize_text_field($_POST['mo7ox_selected_course']));
    }
}
add_action('save_post', 'mo7ox_save_course_details_meta');

// 3️⃣ Display Courses with Featured Images and Titles
function mo7ox_display_courses() {
    $args_courses = array(
        'post_type' => 'courses',
        'posts_per_page' => -1,
    );
    $courses_query = new WP_Query($args_courses);

    if ($courses_query->have_posts()) :
        echo '<div class="courses-container">';
        while ($courses_query->have_posts()) : $courses_query->the_post();
            ?>
            <div class="course-item">
                <h2><?php the_title(); ?></h2>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="course-thumbnail"><?php the_post_thumbnail(); ?></div>
                <?php endif; ?>
            </div>
            <?php
        endwhile;
        echo '</div>';
        wp_reset_postdata();
    else :
        echo '<p>No courses found.</p>';
    endif;
}

// 4️⃣ Display Course Details
function mo7ox_display_course_details() {
    $args_details = array(
        'post_type' => 'course_details',
        'posts_per_page' => -1,
    );
    $details_query = new WP_Query($args_details);

    if ($details_query->have_posts()) :
        while ($details_query->have_posts()) : $details_query->the_post();
            $video_url = get_post_meta(get_the_ID(), '_mo7ox_course_video_url', true);
            $description = get_post_meta(get_the_ID(), '_mo7ox_course_description', true);
            $selected_course = get_post_meta(get_the_ID(), '_mo7ox_selected_course', true);
            ?>
            <div class="course-detail">
                <h3><?php the_title(); ?></h3>
                <p><?php echo esc_html($description); ?></p>
                <a href="<?php echo esc_url($video_url); ?>" target="_blank"><?php _e('Watch Video', 'mo7ox'); ?></a>
                <?php if ($selected_course) : ?>
                    <p><?php _e('Related Course:', 'mo7ox'); ?> <?php echo esc_html(get_the_title($selected_course)); ?></p>
                <?php endif; ?>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>No course details found.</p>';
    endif;
}

// making for tools too
function mo7ox_register_tools_post_type() {
    // Courses Post Type
    $labels_Tools = array(
        'name'                  => _x('Tools', 'Post Type General Name', 'mo7ox'),
        'singular_name'         => _x('Tool', 'Post Type Singular Name', 'mo7ox'),
        'menu_name'             => __('Tools', 'mo7ox'),
        'name_admin_bar'        => __('Tool', 'mo7ox'),
        'add_new'               => __('Add New', 'mo7ox'),
        'add_new_item'          => __('Add New Tool', 'mo7ox'),
        'new_item'              => __('New Tool', 'mo7ox'),
        'edit_item'             => __('Edit Tool', 'mo7ox'),
        'view_item'             => __('View Tool', 'mo7ox'),
        'all_items'             => __('All Tools', 'mo7ox'),
        'search_items'          => __('Search Tools', 'mo7ox'),
        'not_found'             => __('No Tools found', 'mo7ox'),
        'not_found_in_trash'    => __('No Tools found in Trash', 'mo7ox'),
    );

    $args_Tools = array(
        'label'                 => __('Tools', 'mo7ox'),
        'description'           => __('Custom post type for Tools', 'mo7ox'),
        'labels'                => $labels_Tools,
        'supports'              => array('title', 'thumbnail', 'editor'),
        'public'                => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'hierarchical'          => false,
        'exclude_from_search'   => false,
        'capability_type'       => 'post',
    );

    register_post_type('Tools', $args_Tools);

    

    register_post_type('Tool_details', $args_details);
}
add_action('init', 'mo7ox_register_Tools_post_type');












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

// Save the Custom Fields for Ctf Details
function mo7ox_save_Ctf_details_meta($post_id) {
    if (array_key_exists('mo7ox_selected_Ctf', $_POST)) {
        update_post_meta($post_id, '_mo7ox_selected_Ctf', sanitize_text_field($_POST['mo7ox_selected_Ctf']));
    }
}
add_action('save_post', 'mo7ox_save_Ctf_details_meta');
