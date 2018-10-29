<?php

namespace Drupal\isp_server;

use Drupal\commerce_order\Entity\OrderItemInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

class ServerManager implements ServerManagerInterface {

  /** @var \Drupal\Core\Entity\EntityTypeManagerInterface */
  protected $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function updateServerState(OrderItemInterface $order_item) {
    $original_order = $order_item->original;
    // Update Server for order item.
    if ($order_item->server->target_id != $original_order->servers->target_id) {
      // Transform old server.
      if ($original_order->servers->target_id) {
//        $admin_ip = $original_order->get('admin_ip')->entity;
//        $state_item = $admin_ip->get('state')->first();
//        $transition = $admin_ip->getState()->getTransitions();
//        $state_item->applyTransition($transition['rollback']);
//        $original_order->get('admin_ip')->entity->save();
      }
      // Transform new server.
    }
  }

}