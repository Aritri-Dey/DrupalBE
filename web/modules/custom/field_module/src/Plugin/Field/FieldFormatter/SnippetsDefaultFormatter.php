<?php 

/**
 * @file
 * Contains \Drupal\field_module\Plugin\Field\FieldFormatter\SnippetsDefaultFormatter.
 */
namespace Drupal\field_module\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'snippets_default' formatter.
 *
 * @FieldFormatter(
 *   id = "snippets_default",
 *   label = @Translation("Snippets default"),
 *   field_types = {
 *     "snippets_code"
 *   }
 * )
 */
class SnippetsDefaultFormatter extends FormatterBase { 

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();
    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#type' => 'markup',
        '#markup' => '<p>' . $item->source_description . '<br>' . $item->source_code . '<br>' . $item->source_lang . '</p>',
      ];
    }
    return $elements;
  }

}
