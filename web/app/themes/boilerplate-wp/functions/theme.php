<?php
/**
  Theme specific functions
**/

// Actions
add_action('admin_bar_menu', 'theme_before_admin_bar_render'); 
add_action('admin_init', 'theme_add_editor_styles');


// Filters
add_filter('upload_mimes', 'theme_mime_types');
add_filter('nav_menu_css_class','theme_menu_item_classes', 1, 3);
add_filter('wpseo_metabox_prio', 'theme_yoast_to_bottom');
add_filter('tiny_mce_before_init', 'theme_mce_before_init_insert_formats');

/**
 * @function theme_yoast_to_bottom
 * Sets the Yoast SEO metabox position
 */
function theme_yoast_to_bottom() {
	return 'low';
}

/**
 * @function theme_mime_types
 * Add support for different mime types
 */
function theme_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}

/**
 * @function theme_before_admin_bar_render
 * Removes items from the admin bar
 */
function theme_before_admin_bar_render() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('customize');
}

/**
 * @function theme_menu_item_classes
 * Adds CSS classes to menu items
 */
function theme_menu_item_classes($classes, $item, $args) {

  if ($args->menu->slug == 'main-menu' && $item->menu_item_parent == "0") {
    $classes[] = 'c-main-menu__item';
  }

  return $classes;
}

/**
 * @function theme_add_editor_styles
 * Adds CSS styles to the WYSIWYG editor
 */
function theme_add_editor_styles() {
  add_editor_style('public/css/editor-styles.css');
}

/**
 * @function theme_acf_google_maps_api
 * Sets the Google Maps API key for ACF
 */
function theme_acf_google_maps_api() {
  return GOOGLE_API;
}
  
/**
 * @function theme_mce_before_init_insert_formats
 * Creates CSS classes for the WYSIWYG editor
 */
function theme_mce_before_init_insert_formats($init_array) {
  // $style_formats = array(  
  //   array(  
  //     'title' => 'Checklist',
  //     'selector' => 'ul',
  //     'classes' => 'checklist',
  //     'wrapper' => true,
  //   ),
  // );
  //
  // $init_array['style_formats'] = json_encode($style_formats);
  // return $init_array;  
}