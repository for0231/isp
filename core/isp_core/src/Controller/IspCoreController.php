<?php

namespace Drupal\isp_core\Controller;


use Drupal\Core\Controller\ControllerBase;

class IspCoreController extends ControllerBase {


  /**
   * @param $menu_id
   *
   * @return mixed
   */
  public function menuBlockPage($menu_id) {
    return \Drupal::service('isp_core.manager')->getMenuBlockContents($menu_id);
  }


}