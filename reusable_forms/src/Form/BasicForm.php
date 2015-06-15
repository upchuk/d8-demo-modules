<?php

/**
 * @file
 * Contains \Drupal\reusable_forms\Form\BasicForm.
 */

namespace Drupal\reusable_forms\Form;

use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the BasicForm class.
 */
class BasicForm extends ReusableFormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'basic_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Handle form submission.
  }
}
