<?php

namespace Drupal\Tests\isp_ip\Functional;

use Drupal\Core\Url;

/**
 * Simple test for server settings.
 *
 * @group server
*/
class ServerSettingsTest extends ServerTestBase {

  public function testServerSettings() {
    $user = $this->drupalCreateUser([
      'administer server',
    ]);

    $this->drupalLogin($user);

    $assert_session  = $this->assertSession();

    $this->drupalGet(Url::fromRoute('server.settings'));
    $assert_session->statusCodeEquals(200);
  }
}