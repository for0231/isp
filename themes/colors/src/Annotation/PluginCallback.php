<?php

namespace Drupal\colors\Annotation;

use Drupal\colors\Colors;
use Drupal\Component\Annotation\AnnotationInterface;
use Drupal\Component\Annotation\PluginID;

/**
 * Defines a Plugin annotation object that just contains an ID.
 *
 * @Annotation
 *
 * @ingroup utility
 */
class PluginCallback extends PluginID {
  
  /**
   * The pluginn ID.
   *
   * When an annotation is given no key, 'value' is assumed by Doctrine.
   * @var string
   */
  public $value;
  
  /**
   * Flag that determines how to add the plugin to a callback array.
   *
   * @var \Drupal\colors\Annotation\ColorsConstant
   *
   * Must be one of the following constants.
   *  - CALLBACK_APPEND
   *  - CALLBACK_PREPEND
   *  - CALLBACK_REPLACE_APPEND
   *  - CALLBACK_REPLACE_PREPEND
   */
  public $action = Colors::CALLBACK_APPEND;
  
  /**
   * A callback to replace.
   * @var string
   */
  public $replace = FALSE;
  
  public function get() {
    $definition = parent::get();
    $parent_properties = array_keys($definition);
    $parent_properties[] = 'value';
    
    $reflection = new \ReflectionClass($this);
    foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
      $name = $property->getName();
      if (in_array($name, $parent_properties)) {
        continue;
      }
      $value = $property->getValue($this);
      if ($value instanceof AnnotationInterface) {
        $value = $value->get();
      }
      $definition[$name] = $value;
    }
    
    return $definition;
  }
  
}
