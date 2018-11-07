<?php
/**
  General Helper Functions
**/

define('THEME', get_stylesheet_directory() . '/');
define('THEME_URI', get_stylesheet_directory_uri() . '/');
define('PLUGINS_URI', plugins_url() . '/');
define('SITE_URI', get_option('siteurl'));
define('PAGE_URI', SITE_URI . $_SERVER['REQUEST_URI']);
define('SITE_TITLE', get_bloginfo('name'));
define('NONCE_STRING', get_option('siteurl'));
define('GOOGLE_API', 'AIzaSyBOt5qLOtJ7ZlIK9HDU1yFhUSjL6VdTAsI');

// actions
add_action('admin_footer', 'theme_javascript_helpers');
add_action('wp_footer', 'theme_javascript_helpers');

// Remove actions
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

function theme_uri() {
  echo THEME_URI;
}

function site_uri() {
  echo SITE_URI;
}

function page_uri() {
  echo PAGE_URI;
}

function plugins_uri() {
  echo PLUGINS_URI;
}

function site_title() {
  echo SITE_TITLE;
}

function current_template() {
  echo get_current_template();
}

function theme_join_clean($array, $glue='') {
  if(!$array) return '';
  $unique = array_unique($array);
  $clean = array_filter($unique);
  $string = join($glue, $clean);

  return $string;
}

function get_current_template() {
  return defined('CURRENT_TEMPLATE') ? CURRENT_TEMPLATE : '';
}

// include components from the components folder
function theme_component($slug, $partial_vars=[], $dir='components/') {
  echo get_theme_template($slug, $partial_vars, $dir);
}

// include components from the components folder
function get_theme_component($slug, $partial_vars=[], $dir='components/') {
  return get_theme_template($slug, $partial_vars, $dir);
}

// echo template output
function theme_template($slug, $template_vars=[], $dir='') {
  echo get_theme_template($slug, $template_vars, $dir);
}

// generate and return template output
function get_theme_template($slug, $template_vars=[], $dir='', $return_buffer=true) {

  // is $dir doesn't contain root path make relative to theme
  if(!strpos($dir, ABSPATH)) $dir = THEME . $dir;

  // render template to output buffer
  if($return_buffer) ob_start();
  global $post;
  extract($GLOBALS, EXTR_SKIP);
  extract($template_vars, EXTR_OVERWRITE);
  include $dir . theme_get_php_file($slug);
  if($return_buffer) $output = ob_get_contents();
  if($return_buffer) ob_end_clean();

  // return output if buffered
  if($return_buffer) return $output;
}

// return settings files
function theme_settings($slug, $dir='settings/') {
  return THEME . $dir . theme_get_php_file($slug);
}

// add .php to slug
function theme_get_php_file($slug) {
  return str_replace('.php', '', $slug) . '.php';
}

function get_theme_pages($id) {
  return get_pages(array(
    'sort_column' => 'menu_order',
    'child_of' => $id,
    'parent' => $id
 ));
}

function theme_sanitize($input) {
  // remove non-word characters
  $input = preg_replace('/[^a-zA-Z0-9\s]+/', '', $input);
  // remove spaces
  return preg_replace('/\s+/', '-', $input);
}

function theme_javascript_helpers() {
  global $theme_vars;

  $theme_vars = $theme_vars ?: 0;

  $meta_vars = [
    'uri' => SITE_URI,
  ];

  $api_vars = [
    'analytics' => get_field('google_analytics_tracking_id', 'options')
  ];
  
  $wp_vars = [
    'nonce' => wp_create_nonce(NONCE_STRING),
  ];

  ?>
    <script>
      window.site = {
        meta: <?php echo json_encode($meta_vars); ?>,
        api: <?php echo json_encode($api_vars); ?>,
        wp: <?php echo json_encode($wp_vars); ?>,
        theme: <?php echo json_encode($theme_vars); ?> || {}
      };
    </script>
<?php
}

function theme_dump() {
  echo('<pre>');
  foreach(func_get_args() as $arg) var_dump($arg);
  echo('</pre>');
}

// remove any hardcoded urls
function theme_content_strip_urls ($content) {
  $url = get_bloginfo('url');
  $content = str_replace('src=\"' . $url, "src=\"", $content);
  $content = str_replace('href=\"' . $url, "href=\"", $content);

  return $content;
}

include theme_settings('general');
