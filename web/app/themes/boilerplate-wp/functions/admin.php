<?php
/**
  Admin functions
**/

add_action('admin_menu', 'theme_remove_admin_menu_links');
add_filter('post_thumbnail_html', 'theme_remove_image_size_attributes');
add_filter('image_send_to_editor', 'theme_remove_image_size_attributes');

function theme_remove_image_size_attributes($html) {
  return preg_replace('/(width|height)="\d*"/', '', $html);
}

function theme_remove_admin_menu_links() {
  global $theme_unwanted_admin_menu_items;

  foreach($theme_unwanted_admin_menu_items as $page) {
    remove_menu_page($page . '.php');
  }
}

include theme_settings('admin');