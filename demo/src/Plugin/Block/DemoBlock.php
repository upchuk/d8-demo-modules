<?php

namespace Drupal\demo\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'Demo' block.
 *
 * @Block(
 *   id = "demo_block",
 *   admin_label = @Translation("Demo block"),
 * )
 */

class DemoBlock extends BlockBase {
  
  /**
   * {@inheritdoc}
   */
  public function build() {
    
    $config = $this->getConfiguration();

    $name = $this->t('to no one');
    if (isset($config['demo_block_settings']) && !empty($config['demo_block_settings'])) {
      $name = $config['demo_block_settings'];
    }
    
    return array(
      '#markup' => $this->t('Hello @name!', array('@name' => $name)),
    );  
  }
  
  /**
   * {@inheritdoc}
   */
  public function blockAccess(AccountInterface $account, $return_as_object = FALSE) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }
  
  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    
    $form = parent::blockForm($form, $form_state);
    
    $config = $this->getConfiguration();

    $form['demo_block_settings'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Who'),
      '#description' => $this->t('Who do you want to say hello to?'),
      '#default_value' => isset($config['demo_block_settings']) ? $config['demo_block_settings'] : '',
    );
    
    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('demo_block_settings', $form_state->getValue('demo_block_settings'));
  } 
  
}
