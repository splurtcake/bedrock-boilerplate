<?php
/**
  # Custom Post-Type Function
  - Takes an array of strings (uses default settings), or `{identifier} => array({options})`

  More: http://codex.wordpress.org/Function_Reference/register_post_type
**/

add_action('init', 'theme_create_custom_post_types');

function theme_create_custom_post_types () {
  global $theme_custom_post_types, $theme_custom_post_columns, $wp_post_types;

  add_post_type_support('page', 'excerpt');

  foreach($theme_custom_post_types as $key => $post_type) {
    $plural = is_string($post_type) ? $post_type : ucwords($post_type['name']);
    $singular = $post_type['singular_name'];
    $key = is_string($key) || is_array($post_type) ? $key : preg_replace("/\W+/", "", $plural);

    $defaults = array(
      'labels' => array(
        'name' => __($plural),
        'singular_name' => __($singular),
        'add_new' => __("New {$singular}"),
        'add_new_item' => __("Add New {$singular}"),
        'edit_item' => __("Edit {$singular}"),
        'new_item' => __($singular),
        'view_item' => __("View {$singular}"),
        'search_items' => __("Search {$plural}s"),
        'not_found' => __("No {$plural}s Found"),
        'not_found_in_trash' => 'No {$plural}s found in Trash'
      ),
      'public' => true,
      'supports' => array(
        'excerpt'
      ),
    );

    $options = is_array($post_type) ? array_merge($defaults, $post_type) : $defaults;

    register_post_type(strtolower($key), $options);
  }
}
include theme_settings('post-types');
