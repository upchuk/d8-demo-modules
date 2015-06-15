<?php
/**
 * @file
 * Contains \Drupal\reusable_forms\ReusableFormsManager.
 */

namespace Drupal\reusable_forms;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Defines the ReusableForm plugin manager.
 */
class ReusableFormsManager extends DefaultPluginManager {

  /**
   * Constructs an ReusableFormsManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations,
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/ReusableForm', $namespaces, $module_handler, 'Drupal\reusable_forms\ReusableFormPluginInterface', 'Drupal\reusable_forms\Annotation\ReusableForm');
    $this->alterInfo('reusable_forms_info');
    $this->setCacheBackend($cache_backend, 'reusable_forms');
  }
}