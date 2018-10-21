<?php

namespace Drupal\Tests\isp_ip\Functional;

use Drupal\Core\Url;

/**
 * Simple test for isp_ip_type list.
 *
 * @group isp_ip
 */
class IpTypeListTest extends IpTestBase {

  public function testList() {
    $isp_ip_type = $this->createIpType();

    $user = $this->drupalCreateUser([
      'administer isp ip',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.isp_ip_type.collection'));
    $assert_session->statusCodeEquals(200);
    $assert_session->responseContains($isp_ip_type->label());
  }

}
