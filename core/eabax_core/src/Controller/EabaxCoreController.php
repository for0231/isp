<?php

namespace Drupal\eabax_core\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\migrate\MigrateExecutable;
use Drupal\migrate\MigrateMessage;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate_tools\MigrateBatchExecutable;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Returns responses for eabax core routes.
 */
class EabaxCoreController extends ControllerBase {

  /**
   * The menu link tree manager.
   *
   * @var \Drupal\Core\Menu\MenuLinkTreeInterface
   */
  protected $menuLinkTree;

  public function __construct(MenuLinkTreeInterface $menu_link_tree) {
    $this->menuLinkTree = $menu_link_tree;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('menu.link_tree')
    );
  }

  /**
   * @param $menu_id
   * @return mixed
   */
  public function menuBlockPage($menu_id) {
    return \Drupal::service('eabax_core.manager')->getMenuBlockContents($menu_id);
  }

  /**
   * @param $menu_id
   * @return mixed
   */
  public function implementationMenuBlockPage($menu_id) {
    $output = \Drupal::service('eabax_core.manager')->getMenuBlockContents($menu_id);
    $output['#theme'] = 'admin_block_content__implementation';
    return $output;
  }

}
