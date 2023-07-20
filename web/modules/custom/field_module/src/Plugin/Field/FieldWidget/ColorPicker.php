<?php

/**
 * @file
 * Contains \Drupal\field_module\Plugin\Field\FieldWidget\ColorPicker.
 */
namespace Drupal\field_module\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field_module\Plugin\Field\FieldWidget\WidgetPermission;

/**
 * Plugin implementation of the 'field_module_colorpicker_widget' widget.
 *
 * @FieldWidget(
 *   id = "field_module_colorpicker_widget",
 *   label = @Translation("Color-picker"),
 *   field_types = {
 *     "field_module_rgb"
 *   }
 * )
 */
class ColorPicker extends WidgetPermission { 

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    
    $roles = $this->userRole->getRole();
    // Field is only shown to user with adminitrator role.
    if (in_array('administrator', $roles)) {
      $element['value'] = [
        '#title' => $this->t('Choose color'),
        '#type' => 'color',
      ];
    }
    return $element;
  }

}
