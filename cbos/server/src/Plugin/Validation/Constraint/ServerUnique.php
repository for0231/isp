<?php

namespace Drupal\isp_server\Plugin\Validation\Constraint;

use Drupal\Core\Validation\Plugin\Validation\Constraint\UniqueFieldConstraint;

/**
 *
 * @Constraint(
 *   id = "ServerUnique",
 *   label = @Translation("Server unique", context = "Validation")
 * )
 */
class ServerUnique extends UniqueFieldConstraint {
  public $message = 'The server %value is already taken.';
}