<?php

namespace Drupal\Tests\isp_ip\Functional;

use Drupal\Core\Url;

/**
 * Simple test for alert list.
 *
 * @group isp_ip
 */
class IpAddTest extends IpTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['block'];

  /**
   * Tests add form.
   */
  public function testAddForm() {
    $this->drupalPlaceBlock('local_actions_block');

    $user = $this->drupalCreateUser([
      'add ip',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.isp_ip.collection'));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists(t('Add IP'));

    $this->clickLink(t('Add IP'));
    $assert_session->statusCodeEquals(200);

    $edit = [
      'name[0][value]' => $this->randomString(),
    ];
    $this->drupalPostForm(NULL, $edit, t('Save'));
    $assert_session->responseContains(t('Created the %label IP.', [
      '%label' => $edit['name[0][value]'],
    ]));
  }

}