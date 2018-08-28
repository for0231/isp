<?php

namespace Drupal\user_console_plus\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'UserConsoleIntegerBlock' block.
 *
 * @Block(
 *  id = "user_console_integer_block",
 *  admin_label = @Translation("User console integer block"),
 * )
 */
class UserConsoleIntegerBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['user_console_integer_block']['#markup'] = 'Implement UserConsoleIntegerBlock.';

    return $build;
  }

}
