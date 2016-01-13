<?php

/**
 * @file
 * Contains \Drupal\demo\Plugin\migrate\source\Genres
 */

namespace Drupal\demo\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for the genres.
 *
 * @MigrateSource(
 *   id = "genres"
 * )
 */
class Genres extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('movies_genres', 'g')
      ->fields('g', ['id', 'movie_id', 'name']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('Genre ID'),
      'movie_id' => $this->t('Movie ID'),
      'name' => $this->t('Genre name'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'id' => [
        'type' => 'integer',
        'alias' => 'g',
      ],
    ];
  }
}
