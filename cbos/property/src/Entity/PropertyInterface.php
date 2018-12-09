<?php

namespace Drupal\property\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Property.
 *
 * @ingroup property
 */
interface PropertyInterface extends ContentEntityInterface, EntityChangedInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Property name.
   *
   * @return string
   *   Name of the Property.
   */
  public function getName();

  /**
   * Sets the Property name.
   *
   * @param string $name
   *   The Property name.
   *
   * @return \Drupal\property\Entity\PropertyInterface
   *   The called Property entity.
   */
  public function setName($name);

  /**
   * Gets the Property creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Property.
   */
  public function getCreatedTime();

  /**
   * Sets the Property creation timestamp.
   *
   * @param int $timestamp
   *   The Property creation timestamp.
   *
   * @return \Drupal\property\Entity\PropertyInterface
   *   The called Property entity.
   */
  public function setCreatedTime($timestamp);

}
