<?php

namespace Drupal\isp_core\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraints\Ip;

/**
 * Count constraint.
 *
 * Overrides the symfony constraint to use the strict setting.
 *
 * @Constraint(
 *   id = "Ip",
 *   label = @Translation("Ip", context = "Validation")
 * )
 */
class IpConstraint extends Ip {

  public $strict = TRUE;

  /**
   * {@inheritdoc}
   */
  public function validatedBy() {
    return '\Symfony\Component\Validator\Constraints\IpValidator';
  }
}