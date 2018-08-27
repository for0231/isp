<?php

namespace Drupal\user_resource_plus\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'UserResourceConsoleBlock' block.
 *
 * @Block(
 *  id = "user_resource_console_block",
 *  admin_label = @Translation("User resource console block"),
 * )
 */
class UserResourceConsoleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['user_resource_console_block']['#markup'] = 'Implement UserResourceConsoleBlock.';

    return $build;
  }

}
