<?php

namespace Drupal\Tests\isp_server\Functional;

use Drupal\Core\Url;

/**
 * Simple test for alert list.
 *
 * @group isp_server
 */
class ServerListTest extends ServerTestBase {

  public function testList() {
    $server = $this->createServer();

    $user = $this->drupalCreateUser([
      'view published server',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.isp_server.collection'));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists($server->label());
  }
}