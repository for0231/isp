<?php

namespace Drupal\import;

use Drupal\migrate\MigrateMessage;
use Drupal\migrate\MigrateMessageInterface;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate_tools\MigrateBatchExecutable as MigrateBatchExecutableBase;

/**
 * Provide configuration support for migrate_tools
 */
class MigrateBatchExecutable extends MigrateBatchExecutableBase {

  protected $configuration;

  /**
   * {@inheritdoc}
   */
  public function __construct(MigrationInterface $migration, MigrateMessageInterface $message, array $options) {
    parent::__construct($migration, $message, $options);

    if (isset($options['configuration'])) {
      $this->configuration = $options['configuration'];
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function batchProcessImport($migration_id, array $options, array &$context) {
    if (empty($context['sandbox'])) {
      $context['finished'] = 0;
      $context['sandbox'] = [];
      $context['sandbox']['total'] = 0;
      $context['sandbox']['counter'] = 0;
      $context['sandbox']['batch_limit'] = 0;
      $context['sandbox']['operation'] = MigrateBatchExecutable::BATCH_IMPORT;
    }

    // Prepare the migration executable.
    $message = new MigrateMessage();
    $configuration = [];
    if (isset($options['configuration'])) {
      $configuration = $options['configuration'];
    }
    /** @var \Drupal\migrate\Plugin\MigrationInterface $migration */
    $migration = \Drupal::getContainer()->get('plugin.manager.migration')->createInstance($migration_id, $configuration);
    $executable = new MigrateBatchExecutable($migration, $message, $options);

    if (empty($context['sandbox']['total'])) {
      $context['sandbox']['total'] = $executable->getSource()->count();
      $context['sandbox']['batch_limit'] = $executable->calculateBatchLimit($context);
      $context['results'][$migration->id()] = [
        '@numitems' => 0,
        '@created' => 0,
        '@updated' => 0,
        '@failures' => 0,
        '@ignored' => 0,
        '@name' => $migration->id(),
      ];
    }

    // Every iteration, we reset out batch counter.
    $context['sandbox']['batch_counter'] = 0;

    // Make sure we know our batch context.
    $executable->setBatchContext($context);

    // Do the import.
    $result = $executable->import();

    // Store the result; will need to combine the results of all our iterations.
    $context['results'][$migration->id()] = [
      '@numitems' => $context['results'][$migration->id()]['@numitems'] + $executable->getProcessedCount(),
      '@created' => $context['results'][$migration->id()]['@created'] + $executable->getCreatedCount(),
      '@updated' => $context['results'][$migration->id()]['@updated'] + $executable->getUpdatedCount(),
      '@failures' => $context['results'][$migration->id()]['@failures'] + $executable->getFailedCount(),
      '@ignored' => $context['results'][$migration->id()]['@ignored'] + $executable->getIgnoredCount(),
      '@name' => $migration->id(),
    ];

    // Do some housekeeping.
    if (
      $result != MigrationInterface::RESULT_INCOMPLETE
    ) {
      $context['finished'] = 1;
    }
    else {
      $context['sandbox']['counter'] = $context['results'][$migration->id()]['@numitems'];
      if ($context['sandbox']['counter'] <= $context['sandbox']['total']) {
        $context['finished'] = ((float) $context['sandbox']['counter'] / (float) $context['sandbox']['total']);
        $context['message'] = t('Importing %migration (@percent%).', [
          '%migration' => $migration->label(),
          '@percent' => (int) ($context['finished'] * 100),
        ]);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function batchImport() {
    // Create the batch operations for each migration that needs to be executed.
    // This includes the migration for this executable, but also the dependent
    // migrations.
    $operations = $this->batchOperations([$this->migration], 'import', [
      'limit' => $this->itemLimit,
      'update' => $this->updateExistingRows,
      'force' => $this->checkDependencies,
      'configuration' => $this->configuration,
    ]);

    if (count($operations) > 0) {
      $batch = [
        'operations' => $operations,
        'title' => t('Migrating %migrate', ['%migrate' => $this->migration->label()]),
        'init_message' => t('Start migrating %migrate', ['%migrate' => $this->migration->label()]),
        'progress_message' => t('Migrating %migrate', ['%migrate' => $this->migration->label()]),
        'error_message' => t('An error occurred while migrating %migrate.', ['%migrate' => $this->migration->label()]),
        'finished' => '\Drupal\migrate_tools\MigrateBatchExecutable::batchFinishedImport',
      ];

      batch_set($batch);
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function batchOperations(array $migrations, $operation, array $options = []) {
    $operations = [];
    foreach ($migrations as $id => $migration) {

      if (!empty($options['update'])) {
        $migration->getIdMap()->prepareUpdate();
      }

      if (!empty($options['force'])) {
        $migration->set('requirements', []);
      }
      else {
        $dependencies = $migration->getMigrationDependencies();
        if (!empty($dependencies['required'])) {
          $required_migrations = $this->migrationPluginManager->createInstances($dependencies['required']);
          // For dependent migrations will need to be migrate all items.
          $dependent_options = $options;
          $dependent_options['limit'] = 0;
          $operations += $this->batchOperations($required_migrations, $operation, [
            'limit' => 0,
            'update' => $options['update'],
            'force' => $options['force'],
          ]);
        }
      }

      $operations[] = [
        '\Drupal\import\MigrateBatchExecutable::batchProcessImport',
        [$migration->id(), $options],
      ];
    }

    return $operations;
  }

}
