<?php

namespace Drupal\isp_server;

use Drupal\commerce_order\Entity\OrderItemInterface;

interface ServerManagerInterface {

  /**
   * @param OrderItemInterface $order_item
   * @return mixed
   */
  public function updateServerState(OrderItemInterface $order_item);

}