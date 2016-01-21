<?php

/**
 * @file
 * Contains \Drupal\demo\Plugin\views\style\BootstrapTabs.
 */

namespace Drupal\demo\Plugin\views\style;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * A Views style that renders markup for Bootstrap tabs.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "bootstrap_tabs",
 *   title = @Translation("Bootstrap Tabs"),
 *   help = @Translation("Uses the Bootstrap Tabs component."),
 *   theme = "demo_bootstrap_tabs",
 *   display_types = {"normal"}
 * )
 */
class BootstrapTabs extends StylePluginBase {

  /**
   * Does this Style plugin allow Row plugins?
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  /**
   * Does the Style plugin support grouping of rows.
   *
   * @var bool
   */
  protected $usesGrouping = FALSE;

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['tab_nav_field'] = array('default' => '');
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    $options = $this->displayHandler->getFieldLabels(TRUE);
    $form['tab_nav_field'] = array(
      '#title' => $this->t('The tab navigation field'),
      '#description' => $this->t('Select the field that will be used as the tab navigation. The rest of the fields will show up in the tab content.'),
      '#type' => 'select',
      '#default_value' => $this->options['tab_nav_field'],
      '#options' => $options,
    );
  }
}
