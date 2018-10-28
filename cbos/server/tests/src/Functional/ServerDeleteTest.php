<?php

namespace Drupal\Tests\isp_server\Functional;

use Drupal\Core\Url;

/**
 * Simple test for alert list.
 *
 * @group isp_server
 */
class ServerDeleteTest extends ServerTestBase {

  /**
   * Test server delete.
   */
  public function testDelete() {
    $server = $this->createServer();

    $user = $this->drupalCreateUser([
      'delete server',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.isp_server.edit_form', [
      'isp_server' => $server->id(),
    ]));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists(t('Delete'));

    $this->clickLink(t('Delete'));
    $assert_session->statusCodeEquals(200);

    $this->drupalPostForm(NULL, [], t('Delete'));
    $assert_session->responseContains(t('The @entity-type %label has been deleted.', [
      '@entity-type' => t('server'),
      '%label' => $server->label(),
    ]));
  }

}