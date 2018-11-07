<?php
/**
  # Media Helpers
  Image sizes ... optimised for 6x4 landscape/portrait
  - bounds: NxN
  - max width: Nx(N)
  - max height: (N)xN
**/

add_theme_support('post-thumbnails');

/* Media-specific filters  */
add_filter('intermediate_image_sizes_advanced', 'theme_media_sizes');

// retrieve a specific image size
function get_theme_image($image, $size, $default='') {
  return $image ? (isset($image['sizes'][$size]) ? $image['sizes'][$size] : $default) : $default;
}

function theme_image($image, $size, $default='') {
  echo get_theme_image($image, $size, $default);
}

function theme_add_image_size($slug, $width, $height=0, $crop=false) {
  global $theme_media_sizes;
  if (!@$theme_media_sizes) $theme_media_sizes = [];

  $theme_media_sizes[] = $slug_array = is_array($slug) ? $slug : [$slug => ucwords(str_replace('-', ' ', $slug)) ];
  add_image_size(array_keys($slug_array)[0], $width, $height ?: $width, $crop);
}

/* Amend 'add media' sizes */
function theme_media_sizes($sizes) {
  // extra sizes
  $extras = array();
  return array_merge($extras, $sizes);
}

include theme_settings('media');