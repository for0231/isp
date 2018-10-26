<?php

namespace Drupal\isp_server\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for servers.
 */
class ServerViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    $data['isp_server_field_data']['state']['filter'] = [
      'id' => 'state_machine_state',
    ];
    return $data;
  }

}
