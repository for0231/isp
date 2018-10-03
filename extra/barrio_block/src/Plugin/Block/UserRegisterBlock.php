<?php

namespace Drupal\barrio_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a 'UserRegisterBlock' block.
 *
 * @Block(
 *  id = "user_register_block",
 *  admin_label = @Translation("User register block"),
 * )
 */
class UserRegisterBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    return $build;
  }

}
