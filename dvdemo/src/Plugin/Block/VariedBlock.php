<?php

namespace Drupal\dvdemo\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Display\VariantManager;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Varied' block.
 *
 * @Block(
 *   id = "varied_block",
 *   admin_label = @Translation("Varied block"),
 * )
 */

class VariedBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The variant manager.
   *
   * @var \Drupal\Core\Display\VariantManager
   */
  protected $variantManager;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, VariantManager $variant_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->variantManager = $variant_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('plugin.manager.display_variant')
    );
  }
  
  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $display_variant_id = isset($config['variant']) ? $config['variant'] : $this->availableVariants()[0];
    $displayVariant = $this->variantManager->createInstance($display_variant_id);
    $displayVariant->setConfiguration($config);
    return $displayVariant->build();

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
  public function blockForm($form, FormStateInterface $form_state, $display_variant_id = NULL) {
    
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();


    $form['text1'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Text 1'),
      '#description' => $this->t('A text field'),
      '#default_value' => isset($config['text1']) ? $config['text1'] : '',
    ];

    $form['text2'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Text 2'),
      '#description' => $this->t('A text field'),
      '#default_value' => isset($config['text2']) ? $config['text2'] : '',
    ];

    $displayVariants = $this->variantManager->getDefinitions();
    $displayVariants = array_filter($displayVariants, function($variant) {
      return in_array($variant['id'], $this->availableVariants());
    });
    $variantOptions = [];
    foreach ($displayVariants as $variant) {
      $variantOptions[$variant['id']] = $variant['admin_label'];
    }

    $form['variant'] = [
      '#type' => 'select',
      '#title' => $this->t('Display variant'),
      '#options' => $variantOptions,
      '#default_value' => isset($config['variant']) ? $config['variant'] : $this->availableVariants()[0],
    ];

    
    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('text1', $form_state->getValue('text1'));
    $this->setConfigurationValue('text2', $form_state->getValue('text2'));
    $this->setConfigurationValue('variant', $form_state->getValue('variant'));
  }

  /**
   * Returns the available display variant ids for this block plugin.
   * @return array
   */
  protected function availableVariants() {
    return ['varied_block_one', 'varied_block_two'];
  }

}
