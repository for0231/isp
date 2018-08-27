<?php

namespace Drupal\user_console_plus\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'UserConsoleAdvertisingBlock' block.
 *
 * @Block(
 *  id = "user_console_advertising_block",
 *  admin_label = @Translation("User console advertising block"),
 * )
 */
class UserConsoleAdvertisingBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['user_console_advertising_block']['#markup'] = 'Implement UserConsoleAdvertisingBlock.';

    return $build;
  }

}
