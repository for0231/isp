<?php

namespace Drupal\Tests\isp_server\Functional;

use Drupal\Core\Url;

/**
 * Simple test for isp_server_type list.
 *
 * @group isp_server
 */
class ServerTypeListTest extends ServerTestBase {

  public function testList() {
    $isp_server_type = $this->createServerType();

    $user = $this->drupalCreateUser([
      'administer isp server',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.isp_server_type.collection'));
    $assert_session->statusCodeEquals(200);
    $assert_session->responseContains($isp_server_type->label());
  }

}
