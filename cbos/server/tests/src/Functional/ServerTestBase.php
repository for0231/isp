<?php

namespace Drupal\Tests\isp_server\Functional;

use Drupal\isp_server\Entity\Server;
use Drupal\isp_server\Entity\ServerType;
use Drupal\Tests\BrowserTestBase;

/**
 * Simple test to ensure that main page loads with module enabled.
 *
 * @group isp_server
 */
class ServerTestBase extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['isp_server'];

  /**
   * A user with permission to administer site configuration.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $user;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
  }

  /**
   * @param array $settings
   * @return \Drupal\Core\Entity\EntityInterface|ServerType
   */
  protected function createServerType(array $settings = []) {
    $settings += [
      'id' => strtolower($this->randomMachineName()),
      'label' => $this->randomMachineName(),
    ];

    $server_type = ServerType::create($settings);
    $server_type->save();

    return $server_type;
  }

  /**
   * @param array $settings
   * @return \Drupal\Core\Entity\EntityInterface|Server
   */
  protected function createServer(array $settings = []) {
    $settings += [
      'name' => $this->randomString(),
      'type' => $this->serverType->id(),
    ];

    $server = Server::create($settings);
    $server->save();

    return $server;
  }
}
