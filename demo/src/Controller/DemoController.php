<?php

/**
 * @file
 * Contains \Drupal\demo\Controller\DemoController.
 */

namespace Drupal\demo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * DemoController.
 */
class DemoController extends ControllerBase {
  
  protected $demoService;
  
  /**
   * Class constructor.
   */
  public function __construct($demoService) {
    $this->demoService = $demoService;
  }
  
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('demo.demo_service')
    );
  }
  
  /**
   * Generates an example page.
   */
  public function demo() {
    return array(
      '#markup' => t('Hello @value!', array('@value' => $this->demoService->getDemoValue())),
    );
  }
}
