<?php

namespace Drupal\smart\Utility;

use Drupal\Core\Cache\Cache;
use Drupal\Core\KeyValueStore\MemoryStorage;
use Drupal\smart\Smart;

/**
 * Theme Storage.
 *
 * A hybrid storage solution that utilizes the cache system for complex and
 * expensive operations performed by a [base] theme.
 *
 * Instead of using multiple cache identifiers, which increases the number of
 * database calls, this storage only executes a single cache call and stores
 * individual entries in memory as an associative array.
 *
 * It also tracks when the data has been modified so it can be saved back to
 * cache before the system fully shuts down.
 *
 * This storage object can be used in `foreach` loops.
 *
 * @ingroup utility
 *
 * @see \Drupal\smart\Utility\StorageItem
 */
class Storage extends MemoryStorage implements \Iterator {
  
  /**
   * The bin (table) data should be stored in (not prefixed with "cache_").
   *
   * @var string
   */
  protected $bin;
  
  /**
   * Flag determining whether or not the cache should be saved to the database.
   *
   * @var bool
   */
  protected $changed;
  
  /**
   * The cache identifier.
   *
   * @var string
   */
  protected $cid;
  
  /**
   * Indicates when the cache should expire.
   *
   * @var string
   */
  protected $expire;
  
  /**
   * Flag determining whether or not object has been initialized yet.
   *
   * @var bool
   */
  protected $initialized = FALSE;
  
  /**
   * Tags to associate with the cached data so it can be properly invalidated.
   *
   * @var string
   */
  protected $tags;
  
  /**
   * {@inheritdoc}
   */
  public function __construct($cid, $bin = 'default', $expire = Cache::PERMANENT, $tags = [Smart::CACHE_TAG]) {
    $this->cid = "theme_registry:storage:$cid";
    $this->bin = $bin;
    $this->changed = FALSE;
    $this->expire = $expire;
    $this->tags = $tags;
    
    // Register the cache object to save, if it's needed, on shutdown.
    drupal_register_shutdown_function([$this, 'save']);
    
    // Retrieve the cached data.
    $data = ($cached = \Drupal::cache($bin)->get($this->cid)) && !empty($cached->data) ? $cached->data : [];
    
    // Set the data.
    $this->setMultiple($data);
    
    // Cache has been initialized.
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