<?php

/**
 * @file
 * Contains \Drupal\field_module\Plugin\Field\FieldWidget\RgbWidget.
 */
namespace Drupal\field_module\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field_module\Plugin\Field\FieldWidget\WidgetPermission;

/**
 * Plugin implementation of the 'field_module_rgb_widget' widget.
 *
 * @FieldWidget(
 *   id = "field_module_rgb_widget",
 *   label = @Translation("R,G,B Codes Widget"),
 *   field_types = {
 *     "field_module_rgb"
 *   }
 * )
 */
class RgbWidget extends WidgetPermission { 

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
   
    $roles = $this->userRole->getRole();
    // Field is only shown to user with adminitrator role.
    if (in_array('administrator', $roles)) {
      $element['r_value'] = [
        '#title' => $this->t('R:'),
        '#type' => 'textfield',
        '#maxlength' => 4,
        '#element_validate' => [
          [$this, 'validateRGB'],
        ],
      ];
  
      $element['g_value'] = [
        '#title' => $this->t('G:'),
        '#type' => 'textfield',
        '#maxlength' => 4,
        '#element_validate' => [
          [$this, 'validateRGB'],
        ],
      ];
  
      $element['b_value'] = [
        '#title' => $this->t('B:'),
        '#type' => 'textfield',
        '#maxlength' => 4,
        '#element_validate' => [
          [$this, 'validateRGB'],
        ],
      ];
    }
    return $element;
  }

  /**
   * Validates the hex code.
   */
  public function validateRGB($element, FormStateInterface $form_state) {
    $value = $element['#value'];

    if (!preg_match('/^\d{1,3}$/', $value)) {
      $form_state->setError($element, $this->t('The hex code value must be a valid 3-digit code.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    // Concatenate the values of the three field widgets.
    $element['value'] = sprintf("#%02x%02x%02x", $values[0]['r_value'], $values[0]['g_value'], $values[0]['b_value']);
    return $element;
  }

}
