<?php

namespace Drupal\Tests\server\Functional;

use Drupal\Core\Url;
use Drupal\Tests\BrowserTestBase;

class ServerTestBase extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['server'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
  }

}
