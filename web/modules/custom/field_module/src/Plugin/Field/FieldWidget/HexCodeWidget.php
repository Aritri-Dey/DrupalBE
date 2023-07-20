<?php

/**
 * @file
 * Contains \Drupal\field_module\Plugin\Field\FieldWidget\RgbItemWidget.
 */
namespace Drupal\field_module\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field_module\Plugin\Field\FieldWidget\WidgetPermission;

/**
 * Plugin implementation of the 'field_module_hexcode_widget' widget.
 *
 * @FieldWidget(
 *   id = "field_module_hexcode_widget",
 *   label = @Translation("Hexcode Widget"),
 *   field_types = {
 *     "field_module_rgb"
 *   }
 * )
 */
class HexCodeWidget extends WidgetPermission { 

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
  
    $roles = $this->userRole->getRole();
    // Field is only shown to user with adminitrator role.
    if (in_array('administrator', $roles)) {
      $element['value'] = [
        '#title' => $this->t('Enter proper hex code starting with #'),
        '#type' => 'textfield',
        '#maxlength' => 7,
        '#element_validate' => [
          [$this, 'validateHexCode'],
        ],
      ];
    }

    return $element;
  }

  /**
   * Validates the hex code.
   */
  public function validateHexCode($element, FormStateInterface $form_state) {
    $value = $element['#value'];

    if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $value)) {
      $form_state->setError($element, $this->t('The hex code value must be a valid 6-digit hex code starting with #.'));
    }
  }
  
}
