<?php

namespace Drupal\user_console_plus\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'UserConsoleRecommendBlock' block.
 *
 * @Block(
 *  id = "user_console_recommend_block",
 *  admin_label = @Translation("User console recommend block"),
 * )
 */
class UserConsoleRecommendBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['user_console_recommend_block']['#markup'] = 'Implement UserConsoleRecommendBlock.';

    return $build;
  }

}
