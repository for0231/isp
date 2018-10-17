<?php

namespace Drupal\isp_ip;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Inet IP entity.
 *
 * @see \Drupal\isp_ip\Entity\Inet.
 */
class InetAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\isp_ip\Entity\InetInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished inet ip entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published inet ip entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit inet ip entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete inet ip entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add inet ip entities');
  }

}
