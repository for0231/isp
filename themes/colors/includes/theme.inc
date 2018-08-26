<?php

/**
 * @file
 * Custom theme hooks.
 */

function colors_theme($existing, $type, $theme, $path) {
  return [
    'color_user_login_form' => [
      'render element' => 'form',
      // TODO move template to user directory.
    ],
    'color_user_register_form' => [
      'render element' => 'form',
      // TODO move template to user directory.
    ],
  ];
}
