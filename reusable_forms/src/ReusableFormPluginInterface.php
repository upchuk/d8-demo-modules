<?php
/**
 * @file
 * Contains \Drupal\reusable_forms\ReusableFormPluginInterface
 */

namespace Drupal\reusable_forms;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for reusable form plugins.
 */
interface ReusableFormPluginInterface extends PluginInspectionInterface, ContainerFactoryPluginInterface {

  /**
   * Return the name of the reusable form plugin.
   *
   * @return string
   */
  public function getName();

  /**
   * Builds the associated form.
   *
   * @param $entity \Drupal\Core\Entity\EntityInterface.
   *   The entity this plugin is associated with.
   *
   * @return array().
   *   Render array of form that implements \Drupal\reusable_forms\Form\ReusableFormInterface
   */
  public function buildForm($entity);
}