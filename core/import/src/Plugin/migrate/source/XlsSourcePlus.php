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

    $this->columns = $this->configuration['columns'];
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
      $header = str_replace('/', '_', $header);
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
    $this->columns = $columns;
  }

  /**
   * {@inheritdoc}
   */
  public function next() {
    $this->currentSourceIds = NULL;
    $this->currentRow = NULL;
    // In order to find the next row we want to process, we ask the source
    // plugin for the next possible row.
    while (!isset($this->currentRow) && $this->getIterator()->valid()) {
      /** @var \PHPExcel_Worksheet_RowIterator $iterator */
      $row_data = []; $iterator = $this->getIterator();
      /** @var \PHPExcel_Cell $cell */
      foreach ($iterator->current()->getCellIterator() as $cell) {
        if (isset($this->columns[$cell->getColumn()])) {
          $column = $this->columns[$cell->getColumn()];
          $value = $cell->getValue();
          $row_data[$column] = $value;
        }
        // Provide source by column name
        $row_data['_' . $cell->getColumn()] = $cell->getValue();
      }
      $row_data = $row_data + $this->configuration;
      $row = new Row($row_data, $this->migration->getSourcePlugin()->getIds(), $this->migration->getDestinationIds());

      // Populate the source key for this row.
      $this->currentSourceIds = $row->getSourceIdValues();

      // Pick up the existing map row, if any, unless getNextRow() did it.
      if (!$this->mapRowAdded && ($id_map = $this->idMap->getRowBySource($this->currentSourceIds))) {
        $row->setIdMap($id_map);
      }

      // Clear any previous messages for this row before potentially adding
      // new ones.
      if (!empty($this->currentSourceIds)) {
        $this->idMap->delete($this->currentSourceIds, TRUE);
      }

      // Preparing the row gives source plugins the chance to skip.
      if ($this->prepareRow($row) === FALSE) {
        continue;
      }

      // Check whether the row needs processing.
      // 1. This row has not been imported yet.
      // 2. Explicitly set to update.
      // 3. The row is newer than the current highwater mark.
      // 4. If no such property exists then try by checking the hash of the row.
      if (!$row->getIdMap() || $row->needsUpdate() || $this->aboveHighwater($row) || $this->rowChanged($row)) {
        $this->currentRow = $row->freezeSource();
      }
      $iterator->next();
    }
  }

}
