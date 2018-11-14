<?php

namespace Drupal\message_plus\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'MessageIconBlock' block.
 *
 * @Block(
 *  id = "message_icon_block",
 *  admin_label = @Translation("Message icon block"),
 * )
 */
class MessageIconBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['message_icon_block']['#markup'] = 'Implement MessageIconBlock.';

    return $build;
  }

}
