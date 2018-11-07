<?php
/**
  ACF settings
**/

// Theme Settings page
acf_add_options_page(array(
  'page_title' => 'Theme Settings',
  'menu_title' => 'Theme Settings',
  'menu_slug' => 'theme-settings',
  'capability' => 'edit_posts',
  'icon_url' => 'dashicons-megaphone',
  'redirect' => false
));