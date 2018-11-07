<?php
/**
  Custom Theme Menus
**/

add_action('init', 'register_theme_menus');

// register menu positions for the theme
function register_theme_menus() {
  global $theme_menu_types;
  register_nav_menus($theme_menu_types);
}

function theme_menu($location, $custom_class = "", $use_walker = false) {
  $args = array(
    'theme_location' => $location,
    'container' => '',
    'items_wrap' => '<ul class="'. $custom_class .'">%3$s</ul>'
  );

  // add custom walker to menu 
  if ($use_walker) {
    $args['walker'] = new Custom_Nav_Walker;
  }

  // print menu with no container or ul ids
  wp_nav_menu($args); 
}

function theme_menu_id($id) {
    
  if(!has_nav_menu($id)) return;
  
  $menus = get_registered_nav_menus();
  $location = $menus[$id];

  theme_menu($location);
}

function get_theme_menu_title($location) {

  // if menu doesn't exist
  if(!has_nav_menu($location)) return;

  // retrieve all menus
  $menus = get_nav_menu_locations();

  // retrieve the desired menu
  $menu = wp_get_nav_menu_object($menus[$location]);

  // return the name
  return $menu->name;
}

function theme_menu_title($location) {
  echo get_theme_menu_title($location);
}

class Custom_Nav_Walker extends Walker_Nav_Menu {
  private $currentItem;

  // store the current item
  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    $this->currentItem = $item;
    // parent::start_el($output,$item,$depth,$args,$id);
    $output .= '<li class="c-main-menu__item"><a class="c-main-menu__link" href="'.esc_attr($item->url).'">'.esc_attr($item->title).'<span data-text="'.$item->title.'"></span></a>';
  }
}

include theme_settings('menus');