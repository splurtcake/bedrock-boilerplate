<?php
/**
  # Resource Queuer
  List of resources
  - by order of inclusion/dependancy
  - index is handle
  - pass a string(defaults all other values)
  - or an array:
    - [0]: relative url
    - [1]: include resource in footer [js=true, css=false]
    - [2]: resource version [wordpress version]
**/

add_action('wp_enqueue_scripts', 'theme_enqueue_header');
add_action('wp_footer', 'theme_enqueue_footer');
add_action('admin_enqueue_scripts', 'theme_enqueue_admin');
add_action('wp_print_styles', 'theme_deregister_styles', 100);
add_action('wp_print_scripts', 'theme_deregister_scripts', 100);

add_filter('clean_url', 'resource_add_attributes', 10, 2);

function theme_head($prepend_uri=false) {
  global $theme_resources;
  resource_process($theme_resources, $prepend_uri);

  foreach($theme_resources as $resource) {
    if($resource[1]) continue;
    theme_print_resource($resource[0], $resource[4], $resource[3]);
  }
}

function theme_footer($prepend_uri=false) {
  global $theme_resources;

  // include js helpers
  theme_javascript_helpers();

  $process_all = false;
  foreach($theme_resources as $resource) {
    if( !isset($resource['processed']) ) {
      $process_all = true;
      resource_process($theme_resources, $prepend_uri);
    }
    if(!$process_all && !$resource[1]) continue;
    theme_print_resource($resource[0], $resource[4], $resource[3]);
  }
}

function theme_print_resource($src, $type, $attr='') {
  echo PHP_EOL;
  echo $type == 'js' ? '<script src="'.$src.'" $attr></script>' : '<link rel="stylesheet" href="'.$src.'" $attr>';
}

function theme_deregister_styles() {
  global $theme_resources_exclude;

  foreach($theme_resources_exclude['styles'] as $handle) {
    if(!isset($theme_resources[$handle])) wp_deregister_style($handle);
  }
}

function theme_deregister_scripts() {
  global $theme_resources_exclude;

  foreach($theme_resources_exclude['scripts'] as $handle) {
    if(!isset($theme_resources[$handle])) wp_deregister_script($handle);
  }
}

function theme_enqueue_admin() {
  global $theme_resources_admin;

  // process and enqueue admin resources
  resource_enqueue($theme_resources_admin, true);
}

function theme_enqueue_header() {
  global $theme_resources, $theme_resources_footer, $theme_resources_template;

  $theme_resources_footer = array();

  $template = get_current_template();
  if(array_key_exists($template, $theme_resources_template)){
    $theme_resources = array_merge($theme_resources, $theme_resources_template[$template]);
  }


  resource_process($theme_resources);

  // iterate through the theme resources
  foreach($theme_resources as $handle => $resource) {
    // if css and footer move into footer list
    if($resource[4]==='css' && $resource[1]){
      $theme_resources_footer[$handle] = $resource;
      unset($theme_resources[$handle]);
    }
  }

  resource_enqueue($theme_resources);
}

function theme_enqueue_footer() {
  global $theme_resources_footer;
  resource_enqueue($theme_resources_footer);
}

function resource_process(&$resources, $prepend_uri=true) {
  // iterate through the resources
  foreach($resources as $handle => &$resource) {

    // change resource to array
    if(!is_array($resource)) $resource = array($resource);

    // complete relative urls, ignore external 
    $prepend_uri = isset($resource[4]) ? $resource[4] : $prepend_uri;
    if($prepend_uri && strpos($resource[0], '//')===false) $resource[0] = THEME_URI . $resource[0];

    // get the version
    $resource[2] = isset($resource[2]) ? $resource[2] : 0;

    // get the extension
    $resource[4] = pathinfo($resource[0], PATHINFO_EXTENSION);

    // if not defined enqueue css in header and js in footer
    $resource[1] = isset($resource[1]) ? $resource[1] : $resource[4]==='js';

    // set processed
    $resource['processed'] = true;
  }
}

function resource_enqueue($resources, $process=false) {
    
  if(!$resources) return;

  if($process) resource_process($resources);
  
  $dependancies = array();

  foreach($resources as $handle => $resource) {
    if($resource[4]==='css') {
      // if css register and enqueue
      wp_register_style($handle, $resource[0], array(), $resource[2]);
      wp_enqueue_style($handle);

    } else {
      // deregister script if present
      wp_deregister_script($handle);

      // if script enqueue then add self to dependancies
      wp_enqueue_script($handle, $resource[0], $dependancies, $resource[2], $resource[1]);
      $dependancies[] = $handle;
    }
  }
}

function resource_add_attributes($clean, $original){
  if(strpos($original, '---a---')===false) return $clean;
  return preg_replace("/(.+)---a---(.+)---a---(.+)?/", "$1$3' $2", $original);
}

include theme_settings('resources');