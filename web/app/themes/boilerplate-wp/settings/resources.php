<?php
/**
  # Resources to be queued
  List of resources
  - by order of inclusion/dependancy
  - index is handle
  - pass a string (defaults all other values)
  - or an array:
    - [0]: relative url
    - [1]: include resource in footer [js=true, css=false]
    - [2]: resource version [wordpress version]
    - [3]: any extra attributes to be added to the script tag
**/

/* resources to include in front-end */
$theme_resources = array(
  'theme' => THEME_URI . 'public/css/styles.css',
  'script' => THEME_URI . 'public/js/bundle.min.js',
);


/* resources to include in admin */
$theme_resources_admin = array(
  // 'admin-style' => 'css/admin/admin.css',
  // 'admin-script' => 'js/admin/admin.min.js',
);

/* resources to include on a per-template basis */
$theme_resources_template = array(
  // '{page-url}' => array(
  //  'tweenmax' => 'vendor/greensock/tweenmax-1.9.8.min.js',
  // )
);

/* resources to exclude globally (by handle) */
$theme_resources_exclude = array(
  'styles' => array(
    // eg. 'jquery-ui-theme'
  ),
  'scripts' => array()
);
