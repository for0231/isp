<?php

namespace Drupal\Tests\eabax_core\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Simple test for role menu pages.
 *
 * @group eabax_core
 */
class RoleMenuPagesTest extends BrowserTestBase {

  use MenuPagesTestTrait;

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
    $this->user = $this->drupalCreateUser();
    $this->user->addRole('implementor');
    $this->drupalLogin($this->user);
  }

  /**
   * Tests that the home page loads with a 200 response.
   */
  public function testImplementorMenu() {
    $this->viewAllPagesOfMenu('role-menu-implementor');
  }

  public function testUserProfile() {
    $assert_session = $this->assertSession();
    $assert_session->statusCodeEquals(200);
  }

}
