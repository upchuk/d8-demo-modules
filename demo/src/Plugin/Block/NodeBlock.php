<?php

namespace Drupal\demo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Entity\EntityViewBuilderInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'NodeBlock' block plugin.
 *
 * @Block(
 *   id = "node_block",
 *   admin_label = @Translation("Node block"),
 *   deriver = "Drupal\demo\Plugin\Derivative\NodeBlock"
 * )
 */

class NodeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var EntityViewBuilderInterface.
   */
  private $viewBuilder;

  /**
   * @var NodeInterface.
   */
  private $node;

  /**
   * Creates a NodeBlock instance.
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param EntityManagerInterface $entity_manager
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityManagerInterface $entity_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->viewBuilder = $entity_manager->getViewBuilder('node');
    $this->nodeStorage = $entity_manager->getStorage('node');
    $this->node = $entity_manager->getStorage('node')->load($this->getDerivativeId());
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity.manager')
    );
  }
  
  /**
   * {@inheritdoc}
   */
  public function build() {
    if (!$this->node instanceof NodeInterface) {
      return;
    }
    $build = $this->viewBuilder->view($this->node, 'full');
    return $build;
  }
  
  /**
   * {@inheritdoc}
   */
  public function blockAccess(AccountInterface $account, $return_as_object = FALSE) {
    return $this->node->access('view', NULL, TRUE);
  }
}
