<?php
  $rows = get_field('flexible_content');

  if ($rows) {
    foreach ($rows as $row) {
      $component = str_replace('_', '-', $row['acf_fc_layout']);
      theme_component($component);
    }
  }
?>