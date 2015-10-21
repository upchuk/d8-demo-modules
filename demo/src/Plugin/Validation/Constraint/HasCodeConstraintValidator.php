<?php

/**
 * @file
 * Contains \Drupal\demo\Plugin\Validation\Constraint\HasCodeConstraintValidator.
 */

namespace Drupal\demo\Plugin\Validation\Constraint;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

/**
 * Validates the HasCodeConstraint.
 */
class HasCodeConstraintValidator extends ConstraintValidator {

  /**
   * Validator 2.5 and upwards compatible execution context.
   *
   * @var \Symfony\Component\Validator\Context\ExecutionContextInterface
   */
  protected $context;

  /**
   * {@inheritdoc}
   */
  public function validate($data, Constraint $constraint) {
    if (!$constraint instanceof HasCodeConstraint) {
      throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\HasCodeConstraint');
    }

    // Node entity
    if ($data instanceof NodeInterface) {
      $this->validateNodeEntity($data, $constraint);
      return;
    }

    // FieldItemList
    if ($data instanceof FieldItemListInterface) {
      foreach ($data as $key => $item) {
        $violation = $this->validateString($item->value, $constraint);
        if ($violation instanceof ConstraintViolationBuilderInterface) {
          $violation->atPath('title')->addViolation();
        }
      }
      return;
    }

    // Primitive data
    if (is_string($data)) {
      $violation = $this->validateString($data, $constraint);
      if ($violation instanceof ConstraintViolationBuilderInterface) {
        $violation->addViolation();
        return;
      }
    }
  }

  /**
   * Handles validation of the title field of the Node entity.
   *
   * @param NodeInterface $node
   * @param HasCodeConstraint $constraint
   */
  protected function validateNodeEntity($node, $constraint) {
    foreach ($node->title as $item) {
      $violation = $this->validateString($item->value, $constraint);
      if ($violation instanceof ConstraintViolationBuilderInterface) {
        $violation->atPath('title')
          ->addViolation();
      }
    }
  }

  /**
   * Handles validation of a string
   *
   * @param $string
   * @param $constraint
   *
   * @return \Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface
   */
  protected function validateString($string, $constraint) {
    if (strpos($string, $constraint->code) === FALSE) {
      return $this->context->buildViolation($constraint->messageNoCode, array('%string' => $string, '%code' => $constraint->code));
    }
  }

}
