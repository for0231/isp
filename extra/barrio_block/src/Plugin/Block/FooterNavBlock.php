<?php

namespace Drupal\barrio_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'FooterNavBlock' block.
 *
 * @Block(
 *  id = "footer_nav_block",
 *  admin_label = @Translation("Footer nav block"),
 * )
 */
class FooterNavBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['footer_nav_block']['#markup'] = 'Implement FooterNavBlock.';

    return $build;
  }

}
