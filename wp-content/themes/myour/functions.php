<?php
/**
 * myour functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package myour
 */

if ( ! function_exists( 'myour_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function myour_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on myour, use a find and replace
		 * to change 'myour' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'myour', get_template_directory() . '/languages' );

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
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'myour' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		// Image Sizes
		add_image_size( 'myour_140x140', 140, 140, true );
		add_image_size( 'myour_256x256', 256, 256, false );
		add_image_size( 'myour_680x680', 680, 680, true );
		add_image_size( 'myour_900xAuto', 900, 9999, false );
		add_image_size( 'myour_1170x658', 1170, 658, true );
		add_image_size( 'myour_1920xAuto', 1920, 9999, false );
	}
endif;
add_action( 'after_setup_theme', 'myour_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function myour_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'myour_content_width', 900 );
}
add_action( 'after_setup_theme', 'myour_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function myour_widgets_init() {
	register_sidebar( array(
		'name'		  => esc_html__( 'Sidebar', 'myour' ),
		'id'			=> 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'myour' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'myour_widgets_init' );

/**
 * Register Default Fonts
 */
function myour_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Lora, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$poppins = _x( 'on', 'Poppins: on or off', 'myour' );

	if ( 'off' !== $poppins ) {
		$font_families = array();

		$font_families[] = 'Poppins:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';
		$font_families[] = 'Mr Dafoe';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Enqueue scripts and styles.
 */
function myour_stylesheets() {
	// Web fonts 
	wp_enqueue_style( 'myour-fonts', myour_fonts_url(), array(), null );

	$headingsFont =  get_field( 'heading_font_family', 'options' );
	$paragraphsFont =  get_field( 'text_font_family', 'options' );
	
	// Custom fonts
	if ( $headingsFont ) {
		wp_enqueue_style( 'myour-heading-font', $headingsFont['url'] , array(), null );
	}
	if ( $paragraphsFont ) {
		wp_enqueue_style( 'myour-paragraph-font', $paragraphsFont['url'] , array(), null );
	}

	/*Styles*/
	wp_enqueue_style( 'myour-style', get_stylesheet_uri(), array( 'magnific-popup', 'animate', 'jarallax', 'owl-carousel', 'swiper', 'fontawesome' ) );
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css', '1.0' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/css/animate.css', '1.0' );
	wp_enqueue_style( 'jarallax', get_template_directory_uri() . '/assets/css/jarallax.css', '1.0' );
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css', '1.0' );
	wp_enqueue_style( 'swiper', get_template_directory_uri() . '/assets/css/swiper.css', '1.0' );
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/fonts/font-awesome/css/font-awesome.css', '1.0' );
}
add_action( 'wp_enqueue_scripts', 'myour_stylesheets' );

function myour_scripts() {
	/*Default Scripts*/	
	wp_enqueue_script( 'myour-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'myour-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	/*Theme Scripts*/
	wp_enqueue_script( 'velocity', get_template_directory_uri() . '/assets/js/velocity.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/assets/js/magnific-popup.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'typed', get_template_directory_uri() . '/assets/js/typed.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'jarallax', get_template_directory_uri() . '/assets/js/jarallax.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'jarallax-video', get_template_directory_uri() . '/assets/js/jarallax-video.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'jarallax-element', get_template_directory_uri() . '/assets/js/jarallax-element.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'imagesloaded' );
	wp_enqueue_script( 'isotope-pkgd', get_template_directory_uri() . '/assets/js/isotope.pkgd.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/assets/js/swiper.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'rrssb', get_template_directory_uri() . '/assets/js/rrssb.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'myour-common', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'myour_scripts' );

/**
 * TGM
 */
require get_template_directory() . '/inc/plugins/plugins.php';

/**
 * ACF Options
 */

function myour_acf_json_load_point( $paths ) {
	$paths = array( get_template_directory() . '/inc/acf-json' );
	if( is_child_theme() ) {
		$paths[] = get_stylesheet_directory() . '/inc/acf-json';
	}

	return $paths;
}

add_filter('acf/settings/load_json', 'myour_acf_json_load_point');

if ( function_exists( 'acf_add_options_page' ) ) {
	// Hide ACF field group menu item
	add_filter( 'acf/settings/show_admin', '__return_false' );
	
	// Add ACF Options Page
	acf_add_options_page( array( 
		'page_title' 	=> esc_html__( 'Theme Options', 'myour' ),
		'menu_title'	=> esc_html__( 'Theme Options', 'myour' ),
		'menu_slug' 	=> 'theme-options',
		'capability'	=> 'edit_theme_options',
	) );
}

function myour_acf_json_save_point( $path ) {
	// update path
	$path = get_stylesheet_directory() . '/inc/acf-json';
	
	// return
	return $path;   
}
add_filter( 'acf/settings/save_json', 'myour_acf_json_save_point' );

function myour_acf_fallback() {
	// ACF Plugin fallback
	if ( ! is_admin() && ! function_exists( 'get_field' ) ) {
		function get_field( $field = '', $id = false ) {
			return false;
		}
		function the_field( $field = '', $id = false ) {
			return false;
		}
		function have_rows( $field = '', $id = false ) {
			return false;
		}
		function has_sub_field( $field = '', $id = false ) {
			return false;
		}
		function get_sub_field( $field = '', $id = false ) {
			return false;
		}
		function the_sub_field( $field = '', $id = false ) {
			return false;
		}
	} 
}
add_action( 'init', 'myour_acf_fallback' );

/**
 * OCDI
 */
require get_template_directory() . '/inc/ocdi-setup.php';

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

/**
 * Include Skin Options
 */
require get_template_directory() . '/inc/skin-options.php';

/**
 * Include Ajax Portfolio Popup
 */
require get_template_directory() . '/inc/ajax-portfolio-popup.php';

/**
 * Get Archive Title
 */

function myour_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_post_type_archive( 'portfolio' ) ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( esc_html__( 'Tag: ', 'myour' ), false );
	} elseif ( is_author() ) {
		$title = esc_html__( 'Author: ', 'myour' ) . get_the_author();
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'myour_archive_title' );

/**
 * Excerpt
 */
function myour_custom_excerpt_length( $length ) {
	return 44;
}
add_filter( 'excerpt_length', 'myour_custom_excerpt_length' );

function myour_new_excerpt_more( $more ) {
	return '... <div><a href="' . esc_url( get_permalink() ) . '" class="btn"><span class="animated-button"><span>' . esc_html__( 'READ MORE', 'myour' ) . '</span></span></a></div>';
}
add_filter( 'excerpt_more', 'myour_new_excerpt_more' );

/**
 * Add class to sub-menu
 */
function myour_change_wp_nav_menu( $classes, $args, $depth ) {
	if ( $args->theme_location == 'primary' ) {
		$classes[] = 'dropdown-menu';
	}
	return $classes;
}
add_filter( 'nav_menu_submenu_css_class', 'myour_change_wp_nav_menu', 10, 3 );

/**
 * Top Menu Horizontal
 */
class myour_TopmenuHorizontal_Walker extends Walker_Nav_menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = '';
		if ( isset( $args->link_after ) ) {
			$args->link_after = '';
		}

		if ( is_array($item->classes) ) {
			if ( in_array('menu-item-has-children', $item->classes ) ) {
				array_push( $item->classes, 'dropdown' );
			}
		}

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = '';
		$class_names = join(' ', $classes);

	   	$class_names = ' class="'. esc_attr( $class_names ) . '"';
		$attributes = ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes_classes = '';

		if ( is_array($item->classes) ) {
			if ( in_array('menu-item-has-children', $item->classes ) ) {
				$attributes_classes .= ' dropdown-toggle';
				$args->link_after = ' <i class="icon icon-down-open"></i>';
			}
		}

		$attributes .= ' class="' . $attributes_classes . '"';

		if ( has_nav_menu( 'primary' ) ) {
			$output .= $indent . '<li id="menu-item-'. esc_attr( $item->ID ) . '"' . $class_names . '>';

			$attributes .= ! empty( $item->url ) ? ' href="' . esc_url( $item->url ) . '"' : '';

			$item_output = $args->before;
			$item_output .= '<a' . $attributes . '>';
			if ( $depth == 0 ){
				$item_output .= '<span class="animated-button"><span>';
			}
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
			$item_output .= $args->link_after;
			if ( $depth == 0 ){
				$item_output .= '</span></span>';
			}
			$item_output .= '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}

/**
 * Comments
 */
if ( ! function_exists( 'myour_comment' ) ) {
	function myour_comment( $comment, $args, $depth ) {
		?>
			<li <?php comment_class( 'post-comment' ); ?> id="li-comment-<?php comment_ID(); ?>" >
				<div id="comment-<?php comment_ID(); ?>" class="comment">
					<div class="comment-image image">
						<?php
							$avatar_size = 80;
							if ( '0' != $comment->comment_parent ){
								$avatar_size = 80;
							}
							echo get_avatar( $comment, $avatar_size );
						?>	
					</div>
					<div class="comment-desc desc">
						<div class="comment-name name">
							<?php comment_author_link(); ?>
						</div>
						<div class="comment-text">
							<div class="single-post-text">
								<?php comment_text(); ?>
							</div>
						</div>
						<div class="comment-info">
							<span class="comment-time"><?php comment_time(); ?></span>
							<span class="comment-date"><?php comment_date(); ?></span>
							<span class="comment-reply">
								<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>	
							</span>
						</div>
					</div>
				</div>
			
		<?php
	}
}