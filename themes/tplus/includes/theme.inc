<?php

/**
 * @file
 * Custom theme hooks.
 */

function tplus_theme($existing, $type, $theme, $path) {
  return [
    'tplus_user_login_form' => [
      'render element' => 'form',
      // TODO move template to user directory.
    ],
    'tplus_user_register_form' => [
      'render element' => 'form',
      // TODO move template to user directory.
    ],
  ];
}
