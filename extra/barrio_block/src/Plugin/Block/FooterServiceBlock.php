<?php

namespace Drupal\barrio_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'FooterServiceBlock' block.
 *
 * @Block(
 *  id = "footer_service_block",
 *  admin_label = @Translation("Footer service block"),
 * )
 */
class FooterServiceBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['footer_service_block']['#markup'] = 'Implement FooterServiceBlock.';

    return $build;
  }

}
