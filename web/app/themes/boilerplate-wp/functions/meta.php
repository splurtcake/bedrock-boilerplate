<?php
/**
  Meta Data Helpers 
**/

// retrieve meta data for the current (or specified) post ID
function get_meta($type, $id=0) {
  global $post;

  if(!is_object($post) && !$id) return;

  $meta = get_post_meta($id ?: $post->ID, $type, true);

  return stripslashes($meta) ?: '';
}

// retrieve meta data specified in the All-in-One SEO Pack
function get_seo_meta($type) {
  return get_meta('_aioseop_' . $type);
}

// echo seo meta data
function seo_meta($type) {
  echo get_seo_meta($type);
}