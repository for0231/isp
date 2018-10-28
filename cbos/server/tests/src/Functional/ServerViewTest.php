<?php

namespace Drupal\Tests\isp_server\Functional;

use Drupal\Core\Url;

/**
 * Simple test for list.
 *
 * @group isp_server
 */
class ServerViewTest extends ServerTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['block'];

  /**
   * Tests canonical page.
   */
  public function testCanonical() {
    $this->drupalPlaceBlock('page_title_block');

    $isp_server = $this->createServer();

    $user = $this->drupalCreateUser(['view isp_servers']);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.isp_server.canonical', [
      'isp_server' => $isp_server->id(),
    ]));
    $assert_session->statusCodeEquals(200);
    $assert_session->responseContains($isp_server->label());
  }

}
