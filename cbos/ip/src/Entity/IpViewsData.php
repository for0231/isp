<?php

namespace Drupal\isp_ip\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for IP.
 */
class IpViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}