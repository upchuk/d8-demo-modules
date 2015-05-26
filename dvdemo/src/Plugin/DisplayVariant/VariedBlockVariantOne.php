<?php

namespace Drupal\dvdemo\Plugin\DisplayVariant;

use Drupal\Component\Utility\SafeMarkup;
use Drupal\Core\Display\VariantBase;

/**
 * Provides the first display variant for the VariedBlock.
 *
 * @PageDisplayVariant(
 *   id = "varied_block_one",
 *   admin_label = @Translation("Varied Block One")
 * )
 */
class VariedBlockVariantOne extends VariantBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $markup = SafeMarkup::checkPlain($config['text1']) . '<br/>' . SafeMarkup::checkPlain($config['text2']);
    return [
      '#type' => 'markup',
      '#markup' => $markup,
    ];
  }
}