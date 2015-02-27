<?php

/**
 * @file
 * Contains Drupal\demo\DemoService.
 */

namespace Drupal\demo;

class DemoService {
  
  protected $demo_value;
  
  public function __construct() {
    $this->demo_value = 'Upchuk';
  }
  
  public function getDemoValue() {
    return $this->demo_value;
  }
  
}
