<?php

namespace Drupal\demo\Plugin\DsField;

use Drupal\Component\Utility\Html;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\ds\Plugin\DsField\DsFieldBase;
use Drupal\taxonomy\Entity\Term;
use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Plugin that renders the terms inside a chosen taxonomy vocabulary.
 *
 * @DsField(
 *   id = "vocabulary_terms",
 *   title = @Translation("Vocabulary Terms"),
 *   entity_type = "node",
 *   provider = "demo",
 *   ui_limit = {"article|*"}
 * )
 */
class VocabularyTerms extends DsFieldBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    if (!isset($config['vocabulary']) || !$config['vocabulary']) {
      return;
    }

    $query = \Drupal::entityQuery('taxonomy_term')
      ->condition('vid', $config['vocabulary']);

    $tids = $query->execute();
    if (!$tids) {
      return;
    }

    $terms = Term::loadMultiple($tids);
    if (!$terms) {
      return;
    }

    return array(
      '#theme' => 'item_list',
      '#items' => $this->buildTermList($terms),
    );
  }

  /**
   * Builds a term list to be used with #theme => 'item_list
   *
   * @param array $terms
   * @return array
   */
  private function buildTermList(array $terms) {
    $config = $this->getConfiguration();
    $formatter = isset($config['field']['formatter']) && $config['field']['formatter'] ? $config['field']['formatter'] : 'unlinked';
    $items = array();
    foreach ($terms as $term) {
      $items[] = $this->buildTermListItem($term, $formatter);
    }

    return $items;
  }

  /**
   * Builds an individual term item for the term item list depending on the formatter.
   *
   * @param \Drupal\taxonomy\Entity\Term $term
   * @return string
   */
  private function buildTermListItem(Term $term, $formatter) {
    if ($formatter === 'linked') {
      $link_url = Url::fromRoute('entity.taxonomy_term.canonical', array('taxonomy_term' => $term->id()));
      return \Drupal::l($term->label(), $link_url);
    }

    return HTML::escape($term->label());
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    $names = taxonomy_vocabulary_get_names();
    $vocabularies = Vocabulary::loadMultiple($names); // Should use dependency injection rather.
    $options = array();
    foreach ($vocabularies as $vocabulary) {
      $options[$vocabulary->id()] = $vocabulary->label();
    }
    $settings['vocabulary'] = array(
      '#type' => 'select',
      '#title' => t('Vocabulary'),
      '#default_value' => $config['vocabulary'],
      '#options' => $options,
    );

    return $settings;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary($settings) {
    $config = $this->getConfiguration();
    $no_selection = array('No vocabulary selected.');

    if (isset($config['vocabulary']) && $config['vocabulary']) {
      $vocabulary = Vocabulary::load($config['vocabulary']);
      return $vocabulary ? array('Vocabulary: ' . $vocabulary->label()) : $no_selection;
    }

    return $no_selection;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {

    $configuration = array(
      'vocabulary' => 'tags',
    );

    return $configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function formatters() {
    return array('linked' => 'Linked', 'unlinked' => 'Unlinked');
  }

}
