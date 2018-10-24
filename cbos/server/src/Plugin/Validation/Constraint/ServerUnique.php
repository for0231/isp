<?php

namespace Drupal\isp_server\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 *
 * @Constraint(
 *   id = "ServerUnique",
 *   label = @Translation("Server unique", context = "Validation")
 * )
 */
class ServerUnique extends Constraint implements ConstraintValidatorInterface {
  /** @var \Symfony\Component\Validator\Context\ExecutionContextInterface $context */
  protected $context;

  public $message = 'The server %value is already taken.';

  public function validate($items, Constraint $constraint) {
    if (!$items->first()) {
      return;
    }
    $options = [];
    foreach ($items->referencedEntities() as $item) {
      $options[$item->id()] = $item->label();
    }
    if ($items->count() != count($options)) {
      $this->context->addViolation('The server someone is already taken.');
    }
  }

  public function validatedBy() {
    return get_class($this);
  }

  /**
   * Initializes the constraint validator.
   *
   * @param ExecutionContextInterface $context The current validation context
   */
  public function initialize(ExecutionContextInterface $context) {
    $this->context = $context;
  }
}