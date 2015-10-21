<?php

/**
 * @file
 * Contains \Drupal\demo\Plugin\Validation\Constraint\HasCodeConstraint.
 */

namespace Drupal\demo\Plugin\Validation\Constraint;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\MissingOptionsException;


/**
 * Constraint for checking if a string contains a certain alphanumerical code.
 *
 * @Constraint(
 *   id = "HasCode",
 *   label = @Translation("Has code", context = "Validation"),
 *   type = { "string", "entity:node" }
 * )
 */
class HasCodeConstraint extends Constraint {

  /**
   * Message shown when the code is missing.
   *
   * @var string
   */
  public $messageNoCode = 'The string <em>%string</em> does not contain the necessary code: %code.';

  /**
   * The code this constraint is checking for.
   *
   * @var string
   */
  public $code;

  /**
   * Constructs a HasCodeConstraint instance.
   *
   * @param null $options
   */
  public function __construct($options = NULL) {
    if ($options !== NULL && is_string($options)) {
      parent::__construct(['code' => $options]);
    }

    if ($options !== NULL && is_array($options) && isset($options['code'])) {
      parent::__construct($options);
    }

    if ($this->code === NULL) {
      throw new MissingOptionsException('The code option is required', __CLASS__);
    }
  }
}
