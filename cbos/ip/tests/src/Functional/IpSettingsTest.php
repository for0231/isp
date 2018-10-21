<?php

namespace Drupal\Tests\isp_ip\Functional;

use Drupal\Core\Url;

/**
 * Simple test for ip settings.
 *
 * @group ip
*/
class IpSettingsTest extends IpTestBase {

  public function testIpSettings() {
    $user = $this->drupalCreateUser([
      'administer ip',
    ]);

    $this->drupalLogin($user);

    $assert_session  = $this->assertSession();

    $this->drupalGet(Url::fromRoute('ip.settings'));
    $assert_session->statusCodeEquals(200);
  }
}