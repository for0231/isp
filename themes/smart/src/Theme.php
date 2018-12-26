<?php

namespace Drupal\smart;

use Drupal\Core\Extension\Extension;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\smart\Utility\Storage;
use Drupal\smart\Utility\StorageItem;

/**
 * Defines a theme object.
 *
 * @ingroup utility
 */
class Theme {
  
  /**
   * Ignores the following directories during file scans of a theme.
   *
   * @see \Drupal\smart\Theme::IGNORE_ASSETS
   * - IGNORE_CORE
   * - IGNORE_DOCS
   * - IGNORE_DEV
   */
  const IGNORE_DEFAULT = -1;
  
  /**
   * Ignores the directories "assets", "css", "images" and "js".
   */
  const IGNORE_ASSETS = 0x1;
  
  /**
   * Ignores the directories "config", "lib" and "src".
   */
  const IGNORE_CORE = 0x2;
  
  /**
   * Ignores the directories "docs" and "documentation".
   */
  const IGNORE_DOCS = 0x4;
  
  /**
   * Ignores "bower_components", "grunt", "nnode_modules" and "starterkits".
   */
  const IGNORE_DEV = 0x8;
  
  /**
   * Ignores the directories "templates" and "theme".
   */
  const IGNORE_TEMPLATES = 0x16;
  
  /**
   * Flag indicating if the theme is Smart based.
   *
   * @var bool
   */
  protected $smart;
  
  /**
   * Flag indicating if the theme is in "development" mode.
   *
   * @var bool
   *
   * This property can only be set via `settings.local.php`:
   *
   * @code
   * $settings['theme.dev'] = TRUE;
   * @endcode
   */
  protected $dev;
  
  /**
   * The current theme info.
   *
   * @var array
   */
  protected $info;
  
  /**
   * A URL for where a livereload instance is listening, if set.
   *
   * @var string
   *
   * This property can only be set via `settings.local.php`;
   *
   * @code
   * // Enable default value: //127.0.0.1:35729/livereload.js.
   * $settings['theme.livereload'] = TRUE;
   *
   * // Or, set just the port number: //127.0.0.1:12345/livereload.js.
   * $settings['theme.livereload'] = 12345;
   *
   * // Or, Set an explicit URL.
   * $settings['theme.livereload'] = '//127.0.0.1:35729/livereload.js';
   * @endcode
   */
  protected $livereload;
  
  /**
   * The theme machine name.
   *
   * @var string
   */
  protected $name;
  
  /**
   * The current theme Extension object.
   *
   * @var \Drupal\Core\Extension\Extension
   */
  protected $theme;
  
  /**
   * An array of installed themes.
   *
   * @var array
   */
  protected $themes;
  
  /**
   * Theme handler object.
   *
   * @var \Drupal\Core\Extension\ThemeHandlerInterface
   */
  protected $themeHandler;
  
  /**
   * TODO
   * @var \Drupal\smart\Plugin\UpdateManager
   */
  protected $updateManager;
  
  
  /**
   * Theme constructor.
   *
   * @param \Drupal\Core\Extension\Extension $theme
   *   A theme \Drupal\Core\Extension\Extension object.
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler
   *   The theme handler object.
   */
  public function __construct(Extension $theme, ThemeHandlerInterface $theme_handler) {
//    // Determine if "development mode" is set.
//    $this->dev = !!Settings::get('theme.dev');
//
//    // Determine the URL for livereload, if set.
//    $this->livereload = '';
//    if ($livereload = Settings::get('theme.livereload')) {
//      // If TRUE, then set the port to the default used by grunt-contrib-watch.
//      if ($livereload === TRUE) {
//        $livereload = '//127.0.0.1:35729/livereload.js';
//      }
//      // If an integer, assume it's a port.
//      elseif (is_int($livereload)) {
//        $livereload = "//127.0.0.1:$livereload/livereload.js";
//      }
//      // If it's scalar, attempt to parse the URL.
//      elseif (is_scalar($livereload)) {
//        try {
//          $livereload = Url::fromUri($livereload)->toString();
//        }
//        catch (\Exception $e) {
//          $livereload = '';
//        }
//      }
//
//      // Typecast livereload URL to a string.
//      $this->livereload = "$livereload" ?: '';
//    }
//
    $this->name = $theme->getName();
    $this->theme = $theme;
    $this->themeHandler = $theme_handler;
    $this->themes = $this->themeHandler->listInfo();
    $this->info = isset($this->themes[$this->name]->info) ? $this->themes[$this->name]->info : [];
    $this->smart= $this->subthemeOf('smart');
    
//    // Only install the theme if it's Bootstrap based and there are no schemas
//    // currently set.
//    if ($this->isBootstrap() && !$this->getSetting('schemas')) {
//      try {
//        $this->install();
//      }
//      catch (\Exception $e) {
//        // Intentionally left blank.
//        // @see https://www.drupal.org/node/2697075
//      }
//    }
  }
  
  /**
   * Retrieves the full base/sub-theme ancestry of a theme.
   *
   * @param bool $reverse
   *   Whether or not to return the array of themes in reverse order, where the
   *   active theme is the first entry.
   *
   * @return \Drupal\smart\Theme[]
   *   An associative array of \Drupal\smart objects (theme), keyed
   *   by machine name.
   */
  public function getAncestry($reverse = FALSE) {
    $ancestry = $this->themeHandler->getBaseThemes($this->themes, $this->getName());
    foreach (array_keys($ancestry) as $name) {
      $ancestry[$name] = Smart::getTheme($name, $this->themeHandler);
    }
    $ancestry[$this->getName()] = $this;
    return $reverse ? array_reverse($ancestry) : $ancestry;
  }
  
  /**
   * Determines whether or not a theme is a sub-theme of another.
   *
   * @param string|\Drupal\smart\Theme $theme
   *   The name or theme Extension object to check.
   *
   * @return bool
   *   TRUE or FALSE
   */
  public function subthemeOf($theme) {
    return (string) $theme === $this->getName() || in_array($theme, array_keys(self::getAncestry()));
  }
  
  /**
   * Returns the machine name of the theme.
   *
   * @return string
   *   The machine name of the theme.
   */
  public function getName() {
    return $this->theme->getName();
  }
  
  /**
   * Retrieves a theme setting.
   *
   * @param string $name
   *   The name of the setting to be retrieved.
   * @param mixed $default
   *   A default value to provide if the setting is not found or if the plugin
   *   does not have a "defaultValue" annotation key/value pair. Typically,
   *   you will likely never need to use this unless in rare circumstances
   *   where the setting plugin exists but needs a default value not able to
   *   be set by conventional means (e.g. empty array).
   *
   * @return mixed
   *   The value of the requested setting, NULL if the setting does not exist
   *   and no $default value was provided.
   *
   * @see theme_get_setting()
   */
  public function getSetting($name, $default = NULL) {
    $value = $this->settings()->get($name);
    return !isset($value) ? $default : $value;
  }
  
  /**
   * Retrieves the theme settings instance.
   *
   * @return \Drupal\smart\ThemeSettings
   *   All settings.
   */
  public function settings() {
    static $themes = [];
    $name = $this->getName();
    if (!isset($themes[$name])) {
      $themes[$name] = new ThemeSettings($this);
    }
    return $themes[$name];
  }
  
  /**
   * Retrieves an individual item from a theme's cache in the database.
   *
   * @param string $name
   *   The name of the item to retrieve from the theme cache.
   * @param array $context
   *   Optional. An array of additional context to use for retrieving the
   *   cached storage.
   * @param mixed $default
   *   Optional. The default value to use if $name does not exist.
   *
   * @return mixed|\Drupal\smart\Utility\StorageItem
   *   The cached value for $name.
   */
  public function getCache($name, array $context = [], $default = []) {
    static $cache = [];
    
    // Prepend the theme name as the first context item, followed by cache name.
    array_unshift($context, $name);
    array_unshift($context, $this->getName());
    
    // Join context together with ":" and use it as the name.
    $name = implode(':', $context);
    
    if (!isset($cache[$name])) {
      $storage = self::getStorage();
      $value = $storage->get($name);
      if (!isset($value)) {
        $value = is_array($default) ? new StorageItem($default, $storage) : $default;
        $storage->set($name, $value);
      }
      $cache[$name] = $value;
    }
    
    return $cache[$name];
  }
  
  /**
   * Retrieves the theme's cache from the database.
   *
   * @return \Drupal\smart\Utility\Storage
   *   The cache object.
   */
  public function getStorage() {
    static $cache = [];
    $theme = $this->getName();
    if (!isset($cache[$theme])) {
      $cache[$theme] = new Storage($theme);
    }
    return $cache[$theme];
  }
  
  /**
   * Retrieves the theme's setting plugin instances.
   *
   * @return \Drupal\smart\Plugin\Setting\SettingInterface[]
   *   An associative array of setting objects, keyed by their name.
   *
   * @deprecated Will be removed in a future release. Use \Drupal\smart\Theme::getSettingPlugin instead.
   */
  public function getSettingPlugins() {
    // TODO
//    Smart::deprecated();
    return $this->getSettingPlugin();
  }
  
  /**
   * Retrieves a theme's setting plugin instance(s).
   *
   * @param string $name
   *   Optional. The name of a specific setting plugin instance to return.
   *
   * @return \Drupal\smart\Plugin\Setting\SettingInterface|\Drupal\smart\Plugin\Setting\SettingInterface[]|null
   *   If $name was provided, it will either return a specific setting plugin
   *   instance or NULL if not set. If $name was omitted it will return an array
   *   of setting plugin instances, keyed by their name.
   */
  public function getSettingPlugin($name = NULL) {
    $settings = [];
    
    // Only continue if the theme is Bootstrap based.
    if ($this->isSmart()) {
      // TODO
//      $setting_manager = new SettingManager($this);
//      foreach (array_keys($setting_manager->getDefinitions()) as $setting) {
//        $settings[$setting] = $setting_manager->createInstance($setting);
//      }
    }
    
    // Return a specific setting plugin.
    if (isset($name)) {
      return isset($settings[$name]) ? $settings[$name] : NULL;
    }
    
    // Return all setting plugins.
    return $settings;
  }
  
  /**
   * Indicates whether the theme is smart based.
   *
   * @return bool
   *   TRUE or FALSE
   */
  public function isSmart() {
    return $this->smart;
  }
  
  /**
   * Retrieves the theme info.
   *
   * @param string $property
   *   A specific property entry from the theme's info array to return.
   *
   * @return array
   *   The entire theme info or a specific item if $property was passed.
   */
  public function getInfo($property = NULL) {
    if (isset($property)) {
      return isset($this->info[$property]) ? $this->info[$property] : NULL;
    }
    return $this->info;
  }
}