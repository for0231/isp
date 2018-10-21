<?php

namespace Drupal\Tests\isp_ip\Functional;

use Drupal\Core\Url;

/**
 * Simple test for isp_ip_type delete.
 *
 * @group isp_ip
 */
class IpTypeDeleteTest extends IpTestBase {

  /**
   * Tests isp_ip_type delete.
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function testDelete() {
    // Prepare data
    $type_no_data = $this->createIpType();
    $type_has_data = $this->createIpType();
    $this->createIp([
      'type' => $type_has_data->id(),
    ]);

    $user = $this->drupalCreateUser([
      'administer isp_ips',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    // Tests delete type with no data
    $this->drupalGet(Url::fromRoute('entity.isp_ip_type.edit_form', [
      'isp_ip_type' => $type_no_data->id(),
    ]));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists(t('Delete'));

    $this->clickLink(t('Delete'));
    $assert_session->statusCodeEquals(200);

    $this->drupalPostForm(NULL, [], t('Delete'));
    $assert_session->responseContains(t('The @entity-type %label has been deleted.', [
      '@entity-type' => t('isp ip type'),
      '%label' => $type_no_data->label(),
    ]));
    // Tests delete type with data
    $this->drupalGet(Url::fromRoute('entity.isp_ip_type.delete_form', [
      'isp_ip_type' => $type_has_data->id(),
    ]));
    $assert_session->responseContains(t('You can not remove %type until you have removed all of the %type %entity.', [
      '%type' => $type_has_data->label(),
      '%entity' => t('Ip'),
    ]));
  }

}
