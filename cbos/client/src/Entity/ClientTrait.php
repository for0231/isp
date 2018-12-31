<?php

namespace Drupal\client\Entity;

trait ClientTrait {
  /**
   * @return \Drupal\user\UserInterface
   */
  public function getClient() {
    return $this->get('client')->entity;
  }
  
  public function getClientId() {
    return $this->getClient() ? $this->getClient()->id() : NULL;
  }
}