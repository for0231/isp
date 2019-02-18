<?php
/**
 * @file
 * Theme and preprocess functions for menu.
 */

/**
 * Implements hook_preprocess_menu_local_task().
 */
function tark_preprocess_menu_local_task(array &$variables) {
  $variables['attributes']['class'] = ['nav-item'];
  $url = $variables['element']['#link']['url'];
  $url->setOption('attributes', ['class'=> ['nav-link']]);
  if ($variables['is_active'])  {
    $url->setOption('attributes', ['class' => ['active', 'nav-link', 'show']]);
  }
}

function tark_preprocess_menu__role_menu(array &$variables) {
  $icons = [
    'eabax_core.implementor.data_modeling' => 'fa-lg',
    'eabax_core.implementor.implementation' => 'fa-lg',
    'eabax_core.implementor.tools' => 'fa-lg',
    'eabax_core.system_administrator.system_administration' => 'fa-lg',
  ];
  _eabax_core_set_menu_items_icon($variables['items'], $icons);
}