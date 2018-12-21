<?php

namespace Drupal\ip\Plugin\WorkflowType;

use Drupal\workflows\Plugin\WorkflowTypeBase;

/**
 * Attaches workflows to content entity types and their bundles.
 *
 * @WorkflowType(
 *   id = "ip_state",
 *   label = @Translation("IP State"),
 *   required_states = {
 *     "draft",
 *     "published",
 *     "saled",
 *     "disabled",
 *     "wrong",
 *   },
 * )
 */
class IPState extends WorkflowTypeBase implements IpStateInterface {
  
  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'states' => [
        'draft' => [
          'label' => 'Draft',
          'published' => FALSE,
          'default_revision' => FALSE,
          'weight' => 0,
        ],
        'published' => [
          'label' => 'Published',
          'published' => TRUE,
          'default_revision' => TRUE,
          'weight' => 1,
        ],
        'saled' => [
          'label' => 'Saled',
          'published' => TRUE,
          'default_revision' => TRUE,
          'weight' => 1,
        ],
        'disabled' => [
          'label' => 'Disabled',
          'published' => TRUE,
          'default_revision' => TRUE,
          'weight' => 1,
        ],
        'wrong' => [
          'label' => 'Wrong',
          'published' => TRUE,
          'default_revision' => TRUE,
          'weight' => 1,
        ],
      ],
      'transitions' => [
        'create_new_draft' => [
          'label' => 'Create New Draft',
          'to' => 'draft',
          'weight' => 0,
          'from' => [
            'draft',
            'published',
          ],
        ],
        'publish' => [
          'label' => 'Publish',
          'to' => 'published',
          'weight' => 1,
          'from' => [
            'draft',
            'published',
          ],
        ],
        'sale_to_customer' => [
          'label' => 'Sale To',
          'to' => 'saled',
          'weight' => 2,
          'from' => [
            'published',
          ],
        ],
        'stop_to_saled' => [
          'label' => 'Disable',
          'to' => 'disabled',
          'weight' => 2,
          'from' => [
            'saled',
          ],
        ],
        'to_wrong' => [
          'label' => 'Wrong',
          'to' => 'wrong',
          'weight' => 2,
          'from' => [
            'saled',
          ],
        ],
        'to_draft' => [
          'label' => 'Refix',
          'to' => 'published',
          'weight' => 2,
          'from' => [
            'wrong',
            'disabled',
          ],
        ],
      ],
    ];
  }
}
