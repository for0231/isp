<?php

namespace Drupal\isp_ip\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Inet IP.
 */
class InetViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    $data['isp_inet_field_data']['state']['filter'] = [
      'id' => 'state_machine_state',
    ];
    return $data;
  }

}
