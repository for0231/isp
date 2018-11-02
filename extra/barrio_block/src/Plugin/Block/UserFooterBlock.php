<?php

namespace Drupal\barrio_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'UserFooterBlock' block.
 *
 * @Block(
 *  id = "user_footer_block",
 *  admin_label = @Translation("User footer block"),
 * )
 */
class UserFooterBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    // User page footer.
    $build['user_footer_block']['#markup'] = 'UserFooterBlock.';

    return $build;
  }

}
