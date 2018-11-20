<?php

namespace Drupal\import\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\import\MigrateBatchExecutable;
use Drupal\migrate\MigrateMessage;
use Drupal\migrate\Plugin\MigrationInterface;
use PHPExcel_Exception;

class ImportFormSelectSheet extends ImportFormBase {

  /**
   * @var \Drupal\migrate\Plugin\MigrationInterface
   */
  protected $migration;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'import_form_select_sheet';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $migration_id = NULL) {
    $this->migration_id = $migration_id;

    $session = \Drupal::request()->getSession();
    $this->options = $session->get('import_entity.import_form.options');

    $xls = \PHPExcel_IOFactory::load(drupal_realpath($this->options['configuration']['source']['path']));
    $sheets = $xls->getAllSheets();
    $options = ['- Select -'];
    foreach ($sheets as $sheet) {
      $title = $sheet->getTitle();
      $options[$title] = $title;
    }
    $form['sheet'] = [
      '#title' => $this->t('Sheet'),
      '#type' => 'select',
      '#options' => $options,
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::sheetSwitch',
        'wrapper' => 'sources-wrapper',
      ],
    ];

    /** @var \Drupal\migrate\Plugin\MigrationInterface $migration */
    $this->migration = $this->migrationPluginManager->createInstance($this->migration_id, $this->options['configuration']);

    $header_row = $this->migration->getSourceConfiguration()['header_row'];
    if (!$header_row) {
      $header_row = 1;
    }
    $form['header_row'] = [
      '#title' => $this->t('Header row'),
      '#type' => 'number',
      '#min' => 1,
      '#max' => 10,
      '#default_value' => $header_row,
      '#ajax' => [
        'callback' => '::sheetSwitch',
        'wrapper' => 'sources-wrapper',
      ],
    ];

    $default_sheet = $this->migration->getSourceConfiguration()['sheet_name'];
    if (!empty($default_sheet)) {
      $form['sheet']['#default_value'] = $default_sheet;
    }

    $form['sources'] = [
      '#title' => $this->t('Sources'),
      '#type' => 'table',
      '#header' => [$this->t('Source'), $this->t('Column')],
      '#prefix' => '<div id="sources-wrapper">',
      '#suffix' => '</div>',
    ];

    $columns = $this->getColumns();
    foreach ($columns as $key => $value) {
      $form['sources'][$key]['source'] = [
        '#markup' => $key,
      ];

      $form['sources'][$key]['column'] = [
        '#type' => 'select',
        '#required' => TRUE,
        '#default_value' => $value,
      ];
    }

    // Provides valid options
    if ($sheet_name = $form_state->getValue('sheet')) {
      $default_sheet = $sheet_name;
    }
    if ($default_sheet) {
      if ($new_header_row = $form_state->getValue('header_row')) {
        $header_row = $new_header_row;
      }

      $xls = \PHPExcel_IOFactory::load(drupal_realpath($this->options['configuration']['source']['path']));
      $options = $this->getExcelColumns($xls, $default_sheet, $header_row);

      foreach ($columns as $key => $value) {
        $form['sources'][$key]['column']['#options'] = $options;
        if (isset($options[$value])) {
          $form['sources'][$key]['column']['#default_value'] = $value;
        }
      }
    }

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => t('Import'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  public function sheetSwitch($form, FormStateInterface $form_state) {
    if ($sheet_name = $form_state->getValue('sheet')) {
      $header_row = $form_state->getValue('header_row');

      $columns = $this->getColumns();

      $xls = \PHPExcel_IOFactory::load(drupal_realpath($this->options['configuration']['source']['path']));
      $options = $this->getExcelColumns($xls, $sheet_name, $header_row);

      foreach ($columns as $key => $value) {
        if (isset($options[$value])) {
          $form['sources'][$key]['column']['#value'] = $value;
        }
      }
    }

    return $form['sources'];
  }

  /**
   * Get columns form migration configuration
   */
  protected function getColumns() {
    $columns = [];

    foreach ($this->migration->getSourceConfiguration()['columns'] as $values) {
      $columns = $values + $columns;
    }

    return array_flip($columns);
  }

  protected function getExcelColumns(\PHPExcel $xls, $sheet_name, $header_row) {
    try {
      $xls->setActiveSheetIndexByName($sheet_name);
    }
    catch (\PHPExcel_Exception $e) {
      return [];
    }

    $columns = [];

    $iterator = $xls->getActiveSheet()->getRowIterator($header_row, $header_row);
    foreach ($iterator->current()->getCellIterator() as $cell) {
      $column = rtrim($cell->getValue());
      if (isset($column)) {
        $key = str_replace('/', '_', $column);
        $columns[$key] = $column;
      }
    }

    return $columns;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $configuration = $this->options['configuration'] + $this->migration->getPluginDefinition();

    $configuration['source']['sheet_name'] = $form_state->getValue('sheet');
    $sources = array_map(function ($item) {
      return $item['column'];
    }, $form_state->getValue('sources'));

    $columns = [];
    $i = 0;
    foreach ($sources as $key => $value) {
      $columns[$i] = [$value => $key];
      $i++;
    }
    $configuration['source']['columns'] = $columns;

    $this->options['configuration'] = $configuration;
    $this->migration->setStatus(MigrationInterface::STATUS_IDLE);
    $migrateMessage = new MigrateMessage();
    $executable = new MigrateBatchExecutable($this->migration, $migrateMessage, $this->options);
    $executable->batchImport();
  }

  public function getMigration() {
    return $this->migration;
  }

}
