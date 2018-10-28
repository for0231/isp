<?php

namespace Drupal\Tests\isp_server\Functional;

use Drupal\Core\Url;

/**
 * Simple test for isp_server_type delete.
 *
 * @group isp_server
 */
class ServerTypeDeleteTest extends ServerTestBase {

  /**
   * Tests isp_server_type delete.
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function testDelete() {
    // Prepare data
    $type_no_data = $this->createServerType();
    $type_has_data = $this->createServerType();
    $this->createServer([
      'type' => $type_has_data->id(),
    ]);

    $user = $this->drupalCreateUser([
      'administer isp_servers',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    // Tests delete type with no data
    $this->drupalGet(Url::fromRoute('entity.isp_server_type.edit_form', [
      'isp_server_type' => $type_no_data->id(),
    ]));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists(t('Delete'));

    $this->clickLink(t('Delete'));
    $assert_session->statusCodeEquals(200);

    $this->drupalPostForm(NULL, [], t('Delete'));
    $assert_session->responseContains(t('The @entity-type %label has been deleted.', [
      '@entity-type' => t('isp server type'),
      '%label' => $type_no_data->label(),
    ]));
    // Tests delete type with data
    $this->drupalGet(Url::fromRoute('entity.isp_server_type.delete_form', [
      'isp_server_type' => $type_has_data->id(),
    ]));
    $assert_session->responseContains(t('You can not remove %type until you have removed all of the %type %entity.', [
      '%type' => $type_has_data->label(),
      '%entity' => t('Server'),
    ]));
  }

}
