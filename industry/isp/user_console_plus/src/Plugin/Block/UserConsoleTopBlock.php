<?php

namespace Drupal\user_console\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'UserConsoleTopBlock' block.
 *
 * @Block(
 *  id = "user_console_top_block",
 *  admin_label = @Translation("User console top block"),
 * )
 */
class UserConsoleTopBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['user_console_top_block']['#markup'] = 'Implement UserConsoleTopBlock.';

    return $build;
  }

}
