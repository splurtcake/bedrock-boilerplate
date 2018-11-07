<?php
/**
  Custom Taxonomies
**/

add_action('init', 'theme_taxonomies_include');

function theme_taxonomies_include() {
  global $theme_taxonomies;

  $labels = [
    'all_items',
    'edit_item',
    'view_item',
    'update_item',
    'add_new_item',
    'new_item_name',
    'parent_item',
    'parent_item_colon' => 'Parent item:',
    'search_items',
    'popular_items',
    'separate_items_with_commas',
    'add_or_remove_items',
    'choose_from_most_used' => 'Choose from the most used items',
    'not_found' => 'No items found.'
  ];

  foreach ($theme_taxonomies as $key => $taxonomy) {

    $type = preg_replace('/\W+/', '', $key);
    $post_type = is_string($taxonomy) ? $taxonomy : $taxonomy['post_type'];
    $args = is_array($taxonomy) ? $taxonomy : array(
      'label' => __( $key ),
      'rewrite' => array( 'slug' => strtolower($type) ),
      'capabilities' => array(
        'edit_terms' => 'activate_plugins'
      )
    );

    $args['labels'] = @$args['labels'] ?: [];

    $items = $args['label'];
    $item = @$args['labels']['singular_name'] ?: substr($items, 0, -1);

    foreach ($labels as $label => $label_text) {
      if( isset( $args['labels'][$label] )) continue;

      $use_text = is_numeric( $label );
      if( $use_text ) $label = $label_text;
      $label_text = str_replace('item', $item, str_replace('items', $items, $label_text) );
      if( $use_text ) $label_text = ucwords( str_replace('_', ' ', $label_text) );

    }

    register_taxonomy($type, $post_type, $args);
  }
}

include theme_settings('taxonomies');