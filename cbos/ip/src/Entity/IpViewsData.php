<?php

namespace Drupal\ip\Entity;

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

    $data['ip_field_data']['bulk_form'] = [
      'title' => $this->t('Operations bulk form'),
      'help' => $this->t('Add a form element that lets you run operations on multiple items.'),
      'field' => [
        'id' => 'bulk_form',
      ],
    ];
    
    return $data;
  }

}
