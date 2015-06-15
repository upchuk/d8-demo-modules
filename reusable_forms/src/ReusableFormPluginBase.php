<?php

/**
 * @file
 * Contains Drupal\reusable_forms\ReusableFormPluginBase.
 */

namespace Drupal\reusable_forms;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Form\FormBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the ReusableFormPluginBase abstract class.
 */
abstract class ReusableFormPluginBase extends PluginBase implements ReusableFormPluginInterface {

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilder.
   */
  protected $formBuilder;

  /**
   * Constructs a ReusableFormPluginBase object.
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Form\FormBuilder $form_builder
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, FormBuilder $form_builder) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->formBuilder = $form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('form_builder')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->pluginDefinition['name'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm($entity) {
    return $this->formBuilder->getForm($this->pluginDefinition['form'], $entity);
  }
}