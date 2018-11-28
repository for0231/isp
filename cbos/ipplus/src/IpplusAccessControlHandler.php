<?php

namespace Drupal\ipplus;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the IP+ entity.
 *
 * @see \Drupal\ipplus\Entity\Ipplus.
 */
class IpplusAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\ipplus\Entity\IpplusInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished ip plus');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published ip plus');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit ip plus');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete ip plus');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add ip plus');
  }

}
