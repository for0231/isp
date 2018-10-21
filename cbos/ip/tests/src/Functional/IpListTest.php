<?php

namespace Drupal\Tests\isp_ip\Functional;

use Drupal\Core\Url;

/**
 * Simple test for alert list.
 *
 * @group isp_ip
 */
class IpListTest extends IpTestBase {

  public function testList() {
    $ip = $this->createIp();

    $user = $this->drupalCreateUser([
      'view published ip',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.isp_ip.collection'));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists($ip->label());
  }
}