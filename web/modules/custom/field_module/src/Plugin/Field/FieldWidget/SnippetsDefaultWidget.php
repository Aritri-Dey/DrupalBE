<?php

/**
 * @file
 * Contains \Drupal\field_module\Plugin\Field\FieldWidget\SnippetsDefaultWidget.
 */
namespace Drupal\field_module\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'snippets_default' widget.
 *
 * @FieldWidget(
 *   id = "snippets_default",
 *   label = @Translation("Snippets default"),
 *   field_types = {
 *     "snippets_code"
 *   }
 * )
 */
class SnippetsDefaultWidget extends WidgetBase { 

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['source_description'] = [
      '#title' => $this->t('Description (Snippet fieldtype)'),
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->source_description) ? $items[$delta]->source_description : NULL,
    ];
    $element['source_code'] = [
      '#title' => $this->t('Code (Snippet fieldtype)'),
      '#type' => 'textarea',
      '#default_value' => isset($items[$delta]->source_code) ? $items[$delta]->source_code : NULL,
    ];
    $element['source_lang'] = [
      '#title' => $this->t('Source language (Snippet fieldtype)'),
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->source_lang) ? $items[$delta]->source_lang : NULL,
    ];

    return $element;
  }

}
