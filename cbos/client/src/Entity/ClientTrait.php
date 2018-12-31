<?php

namespace Drupal\client\Entity;

use Drupal\user\UserInterface;

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
  
  /**
   * {@inheritdoc}
   */
  public function setClient(UserInterface $user) {
    $this->set('client', $user->id());
    
    return $this;
  }
  
  /**
   * {@inheritdoc}
   */
  public function setClientId($uid) {
    $this->set('client', $uid);
    
    return $this;
  }
}