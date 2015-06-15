<?php

/**
 * @file
 * Contains \Drupal\reusable_forms\Annotation\ReusableForm.
 */

namespace Drupal\reusable_forms\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a reusable form plugin annotation object.
 *
 * @Annotation
 */
class ReusableForm extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The name of the form plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $name;

  /**
   * The form class associated with this plugin
   *
   * It must implement \Drupal\reusable_forms\Form\ReusableFormInterface.
   *
   * @var string
   */
  public $form;

}