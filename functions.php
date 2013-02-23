<?php

/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );

load_child_theme_textdomain('wpacc-genesis', get_stylesheet_directory() . '/languages' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'Accessible Child Theme' );
define( 'CHILD_THEME_URL', 'http://www.wp-accessible.org/' );

/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'add_viewport_meta_tag' );
function add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/** Remove some Genesis widgets to be replaced by widgets in this theme */
add_action( 'widgets_init', 'remove_genesis_widgets', 20 );
function remove_genesis_widgets() {
    unregister_widget( 'Genesis_Latest_Tweets_Widget' );
}

/** Include library to add custom widgets */
require_once( get_stylesheet_directory()  . '/lib/init.php' );

/** Add support for custom header */
add_theme_support( 'genesis-custom-header', array( 'width' => 960, 'height' => 100 ) );

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

/** Change DOCTYPE to HTML5*/
remove_action( 'genesis_doctype', 'genesis_do_doctype' );
add_action( 'genesis_doctype', 'wpacc_do_doctype_html5' );
function wpacc_do_doctype_html5() {
?>
<!DOCTYPE html>
<html dir="<?php bloginfo('text_direction'); ?>" lang="<?php bloginfo('language'); ?>">                      
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<?php
}

/** Add a banner role to the header */
remove_action( 'genesis_header', 'genesis_header_markup_open', 5);
add_action( 'genesis_header', 'wpacc_header_markup_open', 5 );

function wpacc_header_markup_open() {

	echo '<div id="header" role="banner">';
	genesis_structural_wrap( 'header' );

}

/** Add skiplinks for screen readers */
function wpacc_skip_links() {
	
	// add link to primary navigation?
	$nav = false;
	if ( genesis_get_option( 'nav' ) == '1' ) {
		$nav = true;
	}
	
	// Add links to sidebars?
	$site_layout = genesis_site_layout();
	$sidebar = false;
	$sidebar_alt = false;
	
	// 
	if ( $site_layout == 'sidebar-sidebar-content' || $site_layout == 'content-sidebar-sidebar' || $site_layout == 'sidebar-content-sidebar')  {
		$sidebar = true;
		$sidebar_alt = true;
	}
	
	if ( $site_layout == 'sidebar-content' || $site_layout == 'content-sidebar' )  {
		$sidebar = true;
	}
	 // add link to footer?
	$footer = false;
	if ( current_theme_supports( 'genesis-footer-widgets' ) == '1' ) {
		$footer = true;
	}
	
	
	// write HTML
	?>
    <!-- skiplinks -->
    <br class="skip-link" />
    <?php
    if ($nav) 			echo '<a href="#nav" class="skip-link">'. __( 'Jump to main navigation', 'wpacc-genesis' ) .'</a><br class="skip-link" />' . "\n";
    echo '<a href="#content" class="skip-link">'. __( 'Jump to content', 'wpacc-genesis' ) .'</a><br class="skip-link" /> ' . "\n";
	if ($sidebar) 		echo '<a href="#sidebar" class="skip-link">'. __( 'Jump to primary sidebar', 'wpacc-genesis' ) .'</a><br class="skip-link" />' . "\n";
	if ($sidebar_alt) 	echo '<a href="#sidebar-alt" class="skip-link">'. __( 'Jump to secondary sidebar', 'wpacc-genesis' ) .'</a><br class="skip-link" />' . "\n";
	if ($footer)	 	echo '<a href="#footer-widgets" class="skip-link">'. __( 'Jump to footer', 'wpacc-genesis' ) .'</a><br class="skip-link" />' . "\n";

}
add_action ( 'genesis_header', 'wpacc_skip_links'); 

/** modify display of the title in the header if title is text only */
remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
add_action( 'genesis_site_title', 'wpacc_seo_site_title' );
function wpacc_seo_site_title() {

	/** Set what goes inside the wrapping tags */
	
	if (is_home() || is_front_page() ) {
		$inside = sprintf( '%s', get_bloginfo( 'name' ) );
	} else {
		$inside = sprintf( '<a href="%s">%s</a>', trailingslashit( home_url() ), get_bloginfo( 'name' ) );
	}

	/** Determine which wrapping tags to use */
	$wrap = 'p';

	/** Build the Title */
	$title = sprintf( '<%s id="title">%s</%s>', $wrap, $inside, $wrap );

	/** Echo (filtered) */
	echo apply_filters( 'genesis_seo_title', $title, $inside, $wrap );

}

/** modify display of the description in the header if title is text only */
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
add_action( 'genesis_site_description', 'wpacc_seo_site_description' );
function wpacc_seo_site_description() {

	/** Set what goes inside the wrapping tags */
	$inside = esc_html( get_bloginfo( 'description' ) );

	/** Determine which wrapping tags to use */
	$wrap =  'p';

	/* Build the description */
	$description = $inside ? sprintf( '<%s id="description">%s</%s>', $wrap, $inside, $wrap ) : '';

	/** Echo (filtered) */
	echo apply_filters( 'genesis_seo_description', $description, $inside, $wrap );

}

/** Add an H2 heading to the primary navigation */
function wpacc_add_header_to_primary_nav($nav_output) {
	echo '<h2 class="hidden">'. __( 'Main navigation', 'wpacc-genesis' ) .'</h2>';
    return $nav_output;
}
add_filter( 'genesis_do_nav', 'wpacc_add_header_to_primary_nav', 10, 1 );

/** Add a navigation role to all menus */
function wpacc_add_nav_role ($nav_output) {
	$nav_output = str_replace ('<div id="nav"', '<div id="nav" role="navigation"', $nav_output);
	return $nav_output;
}

add_filter( 'genesis_do_nav', 'wpacc_add_nav_role');

/** add an H1 on archive, search and category pages */
add_action ('genesis_before_loop', 'wpacc_add_h1');
function wpacc_add_h1() {
	global $posts, $wp_query;
	if ( is_category() ) {
		echo '<h1 class="entry-title">' . single_cat_title( '', false ) . "</h1>\n";	
	} elseif ( is_archive() )  {
		echo '<h1 class="entry-title">' . post_type_archive_title('',false) . "</h1>\n";	
	} elseif ( is_search() )  {
		echo '<h1 class="entry-title">'. __( 'Search results for', 'wpacc-genesis' ) . ': ' . get_search_query() . "</h1>\n";
	}
}

/*
Description: Removes all title tags from images and links in posts.
Based on code from Ivan Glauser, http://www.glauserconsulting.com */

add_filter( 'the_content', 'wpacc_remove_title_attr', 1000 );
add_filter( 'image_send_to_editor', 'wpacc_remove_title_attr', 1000 );
add_filter( 'post_thumbnail_html', 'wpacc_remove_title_attr', 1000 );
add_filter( 'wp_get_attachment_image', 'wpacc_remove_title_attr', 1000 );
add_filter( 'genesis_get_image', 'wpacc_remove_title_attr', 1000 );
add_filter( 'genesis_footer_output', 'wpacc_remove_title_attr', 1000 );

function wpacc_remove_title_attr($text) {
    
    // Get all title="..." tags from the html.
    $result = array();
    preg_match_all('|title="[^"]*"|U', $text, $result);
    
    // Replace all occurances with an empty string.
    foreach($result[0] as $title_attr)
    {
        $text = str_replace($title_attr, '', $text);
    }
    
    return $text;
}

/** Sidebar filter, H4 in Widgets and sidebars modified to a H2
code by Kees Monshouwer www.monshouwer.eu 
Wcag 2.0 on this: http://www.w3.org/TR/WCAG20-TECHS/H42.html Example 2: Headings in a 3-column layout*/
function wpacc_register_sidebar_defaults( $args ) {

    $args['before_title'] = '<h2 class="widgettitle">';
    $args['after_title'] = "</h2>\n";

    return $args;
}
add_filter( 'genesis_register_sidebar_defaults', 'wpacc_register_sidebar_defaults' );

//Unregister Sidebar
unregister_sidebar('sidebar');

//Reregister Sidebar
genesis_register_sidebar(
    array(
        'id'          => 'sidebar',
        'name'        => 'Primary sidebar',
        'description' => __( 'This is the primary sidebar if you are using a two or three column site layout option.', 'genesis' ),
    )
);

//Unregister Sidebar Alt
unregister_sidebar('sidebar-alt');

//Reregister Sidebar Alt
genesis_register_sidebar(
    array(
        'id'          => 'sidebar-alt',
        'name'        => 'Secondary sidebar',
        'description' => __( 'This is the secondary sidebar if you are using a three column site layout option.', 'genesis' ),
    )
);

// and get plugin simple sidebars to act the same
function wpacc_ss_register_sidebars() {

	$_sidebars = stripslashes_deep( get_option( SS_SETTINGS_FIELD ) );

	/** If no sidebars have been created, do nothing */
	if ( ! $_sidebars )
		return;

	/** Cycle through created sidebars, register them as widget areas */
	foreach ( (array) $_sidebars as $id => $info ) {

		register_sidebar( array(
			'name' => esc_html( $info['name'] ),
			'id' => $id,
			'description' => esc_html( $info['description'] ),
			'editable' => 1,

			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'after_widget'  => "</div></div>\n",
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => "</h2>\n"
		) );

	}

}

remove_action( 'widgets_init', 'ss_register_sidebars', 16 );
add_action( 'widgets_init', 'wpacc_ss_register_sidebars' );

/** Read More changed adding the title to the link */
add_filter( 'excerpt_more', 'wpacc_read_more_link' );
add_filter( 'get_the_content_more_link', 'wpacc_read_more_link' );
add_filter( 'the_content_more_link', 'wpacc_read_more_link' );
function wpacc_read_more_link() {
	$link = '... <br><a class="more-link" href="' .get_permalink() . '" rel="nofollow">'. __( 'Read more about: ', 'wpacc-genesis' ) .' '. get_the_title() . '</a>';
	return $link;
}

/** Remove rel attribute from the category list to pass HTML5 validation
http://josephleedy.me/blog/make-wordpress-category-list-valid-by-removing-rel-attribute/
 */
add_filter('wp_list_categories', 'wpacc_remove_category_list_rel');
add_filter('the_category', 'wpacc_remove_category_list_rel');
function wpacc_remove_category_list_rel($output) {
  $output = str_replace(' rel="category tag"', '', $output);
  return $output;
}

/**
* Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
*/
add_action( 'wp_enqueue_scripts', 'wpacc_add_my_stylesheet' );


/**
* Enqueue style file for printing
*/
function wpacc_add_my_stylesheet() {
	// Respects SSL, Style.css is relative to the current file
	wp_register_style( 'wpacc-print-style', get_stylesheet_directory_uri() . '/style-print.css', array(), '1.0', 'print' );
	wp_enqueue_style( 'wpacc-style' );
}


