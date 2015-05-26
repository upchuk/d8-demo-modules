<?php

namespace Drupal\dvdemo\Plugin\DisplayVariant;

use Drupal\Component\Utility\SafeMarkup;
use Drupal\Core\Display\VariantBase;

/**
 * Provides the second display variant for the VariedBlock.
 *
 * @PageDisplayVariant(
 *   id = "varied_block_two",
 *   admin_label = @Translation("Varied Block Two")
 * )
 */
class VariedBlockVariantTwo extends VariantBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $markup = SafeMarkup::checkPlain($config['text2']) . '<br/>' . SafeMarkup::checkPlain($config['text1']);
    return [
      '#type' => 'markup',
      '#markup' => $markup,
    ];
  }
}