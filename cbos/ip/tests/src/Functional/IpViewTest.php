<?php

namespace Drupal\Tests\isp_ip\Functional;

use Drupal\Core\Url;

/**
 * Simple test for list.
 *
 * @group isp_ip
 */
class IpViewTest extends IpTestBase {

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

    $isp_ip = $this->createIp();

    $user = $this->drupalCreateUser(['view isp_ips']);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.isp_ip.canonical', [
      'isp_ip' => $isp_ip->id(),
    ]));
    $assert_session->statusCodeEquals(200);
    $assert_session->responseContains($isp_ip->label());
  }

}
