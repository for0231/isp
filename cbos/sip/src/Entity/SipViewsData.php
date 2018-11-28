<?php

namespace Drupal\sip\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Sip entities.
 */
class SipViewsData extends EntityViewsData {

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
