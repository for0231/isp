<?php

namespace Drupal\smart\Utility;

use Drupal\Core\KeyValueStore\MemoryStorage;

/**
 * Theme Storage Item.
 *
 * This is essentially the same object as Storage. The only exception is
 * delegating any data changes to the primary Storage object this
 * StorageItem object lives in.
 *
 * This storage object can be used in `foreach` loops.
 *
 * @ingroup utility
 *
 * @see \Drupal\smart\Utility\Storage
 */
class StorageItem extends MemoryStorage implements \Iterator {
  
  /**
   * Flag determining whether or not object has been initialized yet.
   *
   * @var bool
   */
  protected $initialized = FALSE;
  
  /**
   * The \Drupal\smart\Storage instance this item belongs to.
   *
   * @var \Drupal\smart\Utility\Storage
   */
  protected $storage;
  
  /**
   * {@inheritdoc}
   */
  public function __construct($data, Storage $storage) {
    $this->storage = $storage;
    $this->setMultiple($data);
    $this->initialized = TRUE;
  }
  
  /**
   * {@inheritdoc}
   */
  public function current() {
    return current($this->data);
  }
  
  /**
   * {@inheritdoc}
   */
  public function next() {
    return next($this->data);
  }
  
  /**
   * {@inheritdoc}
   */
  public function key() {
    return key($this->data);
  }
  
  /**
   * {@inheritdoc}
   */
  public function valid() {
    return key($this->data) !== NULL;
  }
  
  /**
   * {@inheritdoc}
   */
  public function rewind() {
    return reset($this->data);
  }
}