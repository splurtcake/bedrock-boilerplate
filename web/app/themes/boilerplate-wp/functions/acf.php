<?php
/**
  ACF functions
**/

if( !class_exists('acf') ) return;

// get machine key for ACF field
function theme_acf_field_key ($name, $id=NULL) {
  $acf_object = get_field_object($name, $id);
  return $acf_object ? $acf_object['key'] : NULL;
}

include theme_settings('acf');