<?php 

/**
 * @file
 * Contains \Drupal\field_module\Plugin\Field\FieldFormatter\RgbItemFormatter.
 */
namespace Drupal\field_module\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'field_module_rgb_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "field_module_rgb_formatter",
 *   label = @Translation("RGB Item Formatter"),
 *   field_types = {
 *     "field_module_rgb"
 *   }
 * )
 */
class RgbItemFormatter extends FormatterBase { 

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();
    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => 'field_module_custom_formatter',
        '#value' => $item->value,
      ];
    }
    return $elements;
  }

}
  