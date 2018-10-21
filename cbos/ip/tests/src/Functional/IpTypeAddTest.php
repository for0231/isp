<?php

namespace Drupal\Tests\isp_ip\Functional;

use Drupal\Core\Url;

/**
 * Simple test for ip_type add.
 *
 * @group isp_ip
 */
class IpTypeAddTest extends IpTestBase {

  public static $modules = ['block'];

  public function testAddForm() {
    $this->drupalPlaceBlock('local_actions_block');

    $user = $this->drupalCreateUser([
      'administer ip',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.ip_type.collection'));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists(t('Add Ip type'));

    $this->clickLink(t('Add Ip type'));
    $assert_session->statusCodeEquals(200);

    $edit = [
      'id' => strtolower($this->randomMachineName()),
      'label' => $this->randomMachineName(),
    ];

    $this->drupalPostForm(NULL, $edit, t('Save'));
    $assert_session->statusCodeEquals(200);

    $assert_session->responseContains(t('Created the %label Ip type.', [
      '%label' => $edit['label'],
    ]));
  }

}