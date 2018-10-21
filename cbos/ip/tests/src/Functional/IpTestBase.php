<?php

namespace Drupal\Tests\isp_ip\Functional;

use Drupal\isp_ip\Entity\Ip;
use Drupal\isp_ip\Entity\IpType;
use Drupal\Tests\BrowserTestBase;

/**
 * Simple test to ensure that main page loads with module enabled.
 *
 * @group isp_ip
 */
class IpTestBase extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['isp_ip'];

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
   * @return \Drupal\Core\Entity\EntityInterface|IpType
   */
  protected function createIpType(array $settings = []) {
    $settings += [
      'id' => strtolower($this->randomMachineName()),
      'label' => $this->randomMachineName(),
    ];

    $ip_type = IpType::create($settings);
    $ip_type->save();

    return $ip_type;
  }

  /**
   * @param array $settings
   * @return \Drupal\Core\Entity\EntityInterface|Ip
   */
  protected function createIp(array $settings = []) {
    $settings += [
      'name' => $this->randomString(),
      'type' => $this->ipType->id(),
    ];

    $ip = Ip::create($settings);
    $ip->save();

    return $ip;
  }
}
