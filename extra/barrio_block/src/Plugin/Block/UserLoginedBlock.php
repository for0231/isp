<?php

namespace Drupal\barrio_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'UserLoginedBlock' block.
 *
 * @Block(
 *  id = "user_logined_block",
 *  admin_label = @Translation("User logined block"),
 * )
 */
class UserLoginedBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['user_login_block']['#markup'] = 'UserLoginBlock.';

    return $build;
  }

}
