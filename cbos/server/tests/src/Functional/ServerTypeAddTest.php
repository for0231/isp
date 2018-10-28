<?php

namespace Drupal\Tests\isp_server\Functional;

use Drupal\Core\Url;

/**
 * Simple test for server_type add.
 *
 * @group isp_server
 */
class ServerTypeAddTest extends ServerTestBase {

  public static $modules = ['block'];

  public function testAddForm() {
    $this->drupalPlaceBlock('local_actions_block');

    $user = $this->drupalCreateUser([
      'administer server',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.server_type.collection'));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists(t('Add Server type'));

    $this->clickLink(t('Add Server type'));
    $assert_session->statusCodeEquals(200);

    $edit = [
      'id' => strtolower($this->randomMachineName()),
      'label' => $this->randomMachineName(),
    ];

    $this->drupalPostForm(NULL, $edit, t('Save'));
    $assert_session->statusCodeEquals(200);

    $assert_session->responseContains(t('Created the %label Server type.', [
      '%label' => $edit['label'],
    ]));
  }

}