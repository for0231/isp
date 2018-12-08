<?php

namespace Drupal\import\Plugin\migrate\source;

use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate\Row;
use Drupal\migrate_source_xls\Plugin\migrate\source\XlsSource;

/**
 * @MigrateSource(
 *   id = "xls_plus"
 * )
 */
class XlsSourcePlus extends XlsSource {

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $migration);

    // ImportFormSelectSheet will make columns duplicate
    $columns = [];
    foreach ($this->configuration['columns'] as $column) {
      $columns = $columns + $column;
    }
    $columns = array_flip($columns);
    $sources = [];
    $i = 0;
    foreach ($columns as $key => $value) {
      $sources[$i] = [$value => $key];
      $i++;
    }
    $this->columns = $sources;
    // Invoke the private prepareColumns function again.
    $this->prepareColumns();
  }

  /**
   * Prepare columns.
   */
  private function prepareColumns() {
    $columns = [];
    $iterator = $this->file
      ->getActiveSheet()
      ->getRowIterator($this->configuration['header_row'], $this->configuration['header_row']);
    /** @var \PHPExcel_Cell $cell */
    foreach ($iterator->current()->getCellIterator() as $cell) {
      $header = rtrim($cell->getValue());
      if (!empty($header)) {
        foreach ($this->columns as $column) {
          if (!isset($column[$header])) {
            continue;
          }
          $columns[$cell->getColumn()] = $column[$header];
          break;
        }
      }
    }
    foreach ($this->columns as $column) {
      foreach ($column as $key => $value) {
        if (substr($key, 0, 1) == '_') {
          $columns[substr($key, 1)] = $value;
        }
      }
    }
    $this->columns = $columns;
  }

}
