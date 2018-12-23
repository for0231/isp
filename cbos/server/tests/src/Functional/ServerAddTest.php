<?php

namespace Drupal\Tests\server\Functional;

use Drupal\Core\Url;

/**
 * Simple test for server add.
 *
 * @group server
 */
class ServerAddTest extends ServerTestBase {
  
  /**
   * Tests add form.
   */
  public function testAddForm() {
    $user = $this->drupalCreateUser([
      'views server',
      'add server',
    ]);
    $this->drupalLogin($user);
    
    $assert_session = $this->assertSession();
    
    $this->drupalGet(Url::fromRoute('entity.server.collection'));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists(t('Add'));
    
    $this->clickLink(t('Add'));
    $assert_session->statusCodeEquals(200);
    
    $this->clickLink(t('Default'));
    $assert_session->statusCodeEquals(200);
    
    $edit = [
      'name[0][value]' => $this->randomMachineName(),
    ];
    $this->drupalPostForm(NULL, $edit, t('Save'));
    $assert_session->statusCodeEquals(200);
    $assert_session->responseContains(t('Created the %label Server.', [
      '%label' => $edit['name[0][value]'],
    ]));
  }
}
