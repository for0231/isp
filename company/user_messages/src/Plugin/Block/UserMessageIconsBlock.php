<?php

namespace Drupal\user_messages\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'UserMessageIconsBlock' block.
 *
 * @Block(
 *  id = "user_message_icons_block",
 *  admin_label = @Translation("User message icons block"),
 * )
 */
class UserMessageIconsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['user_message_icons_block']['#markup'] = 'Implement UserMessageIconsBlock.';

    return $build;
  }

}
