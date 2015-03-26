<?php

namespace Drupal\demo\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests the Drupal 8 demo module functionality
 *
 * @group demo
 */
class DemoTest extends WebTestBase {

  /**
   * Modules to install.
   *
   * @var array
   */
  public static $modules = array('demo', 'node', 'block');

  /**
   * A simple user with 'access content' permission
   */
  private $user;

  /**
   * Perform any initial set up tasks that run before every test method
   */
  public function setUp() {
    parent::setUp();
    $this->user = $this->drupalCreateUser(array('access content'));
  }

  /**
   * Tests that the 'demo/' path returns the right content
   */
  public function testCustomPageExists() {
    // Login
    $this->drupalLogin($this->user);
    // Test the page is found
    $this->drupalGet('demo');
    $this->assertResponse(200);
    // Test the page shows a message comprised of info taken from the service.
    $demo_service = \Drupal::service('demo.demo_service');
    $this->assertText(sprintf('Hello %s!', $demo_service->getDemoValue()), 'Correct message is shown.');
  }

  /**
   * Tests the custom form
   */
  public function testCustomFormWorks() {
    // Login
    $this->drupalLogin($this->user);
    // Test the form page shows.
    $this->drupalGet('demo/form');
    $this->assertResponse(200);

    // Test the email form element exists and the default value is expected
    $config = $this->config('demo.settings');
    $this->assertFieldByName('email', $config->get('demo.email_address'), 'The field was found with the correct value.');
    // Test the form submission works with a correct email
    $this->drupalPostForm(NULL, array(
      'email' => 'test@email.com'
    ), t('Save configuration'));
    $this->assertText('The configuration options have been saved.', 'The form was saved correctly.');

    // Test the newly saved email is the default one in the form.
    $this->drupalGet('demo/form');
    $this->assertResponse(200);
    $this->assertFieldByName('email', 'test@email.com', 'The field was found with the correct value.');

    // Test the form doesn't get submitted with an incorrect email address.
    $this->drupalPostForm('demo/form', array(
      'email' => 'test@email.be'
    ), t('Save configuration'));
    $this->assertText('This is not a .com email address.', 'The form validation correctly failed.');

    // Test that the form is not showing the previously failed submitted email.
    $this->drupalGet('demo/form');
    $this->assertResponse(200);
    $this->assertNoFieldByName('email', 'test@email.be', 'The field was found with the correct value.');
  }

  /**
   * Tests the functionality of the Demo block
   */
  public function testDemoBlock() {
    $user = $this->drupalCreateUser(array('access content', 'administer blocks'));
    $this->drupalLogin($user);

    // Create a new instance of the demo_block.
    $block = array();
    $block['id'] = 'demo_block';
    $block['settings[label]'] = $this->randomMachineName(8);
    $block['theme'] = $this->config('system.theme')->get('default');
    $block['region'] = 'header';
    $edit = array(
      'settings[label]' => $block['settings[label]'],
      'id' => $block['id'],
      'region' => $block['region']
    );
    $this->drupalPostForm('admin/structure/block/add/' . $block['id'] . '/' . $block['theme'], $edit, t('Save block'));
    $this->assertText(t('The block configuration has been saved.'), 'Demo block created.');

    // Check that the block shows up with the default text.
    $this->drupalGet('');
    $this->assertText('Hello to no one', 'Default text is printed by the block.');

    // Edit the block configuration
    $edit = array('settings[demo_block_settings]' => 'Test name');
    $this->drupalPostForm('admin/structure/block/manage/' . $block['id'], $edit, t('Save block'));
    $this->assertText(t('The block configuration has been saved.'), 'Demo block saved.');

    // Check that the block shows up with the configured text.
    $this->drupalGet('');
    $this->assertText('Hello Test name!', 'Configured text is printed by the block.');
  }

}