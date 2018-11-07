<?php
/**
  Media Types
  ===
  Image sizes ... optimised for 6x4 landscape/portrait
    - bounds: NxN
    - max width: Nx(N)
    - max height: (N)xN
**/

theme_add_image_size('feature', 1600); // 1400x(?)
theme_add_image_size('large', 1200); // 1200x(?)
theme_add_image_size('medium', 960); // 960x(?)
theme_add_image_size('thumbnail', 480); // 480x(?)