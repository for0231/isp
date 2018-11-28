<?php

namespace Drupal\sip\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Sip entities.
 *
 * @ingroup sip
 */
interface SipInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Sip name.
   *
   * @return string
   *   Name of the Sip.
   */
  public function getName();

  /**
   * Sets the Sip name.
   *
   * @param string $name
   *   The Sip name.
   *
   * @return \Drupal\sip\Entity\SipInterface
   *   The called Sip entity.
   */
  public function setName($name);

  /**
   * Gets the Sip creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Sip.
   */
  public function getCreatedTime();

  /**
   * Sets the Sip creation timestamp.
   *
   * @param int $timestamp
   *   The Sip creation timestamp.
   *
   * @return \Drupal\sip\Entity\SipInterface
   *   The called Sip entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Sip published status indicator.
   *
   * Unpublished Sip are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Sip is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Sip.
   *
   * @param bool $published
   *   TRUE to set this Sip to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\sip\Entity\SipInterface
   *   The called Sip entity.
   */
  public function setPublished($published);

}
