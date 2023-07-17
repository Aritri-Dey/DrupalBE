<?php 

/**
 * @file
 * Contains Drupal\mymodule\Form\ConditionalFieldForm.  
 */
namespace Drupal\form_module\Form;

use Drupal\Core\Form\FormBase;  
use Drupal\Core\Form\FormStateInterface;  

class ConditionalFieldForm extends FormBase { 

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'conditional_field_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Create a list of radio boxes with colours.
    $form['color_select'] = [
      '#type' => 'radios',
      '#title' => $this->t('Pick a colour'),
      '#options' => [
        'blue' => $this->t('Blue'),
        'white' => $this->t('White'),
        'black' => $this->t('Black'),
        'other' => $this->t('Other'),
      ],
      '#attributes' => [
        // Adding static id to field.
        'id' => 'field_color_select',
      ],
    ];

    // Create a list of radio boxes that will only allow to select yes or no.
    $form['choice_select'] = [
      '#type' => 'radios',
      '#title' => $this->t('Do you want to select a custom color?'),
      '#options' => [
        'yes' => $this->t('Yes'),
        'no' => $this->t('No'),
      ],
      '#attributes' => [
        'id' => 'field_choice_select',
      ],
    ];

    // This textfield will be shown when the option 'Other' and 
    // 'Custom colour' is selected from the radios above.
    $form['custom_color'] = [
      '#type' => 'textfield',
      '#placeholder' => $this->t('Enter your favourite color'),
      '#attributes' => [
        'id' => 'field_custom_color',
      ],
      '#states' => [
        // Show this textfield if the radios 'other' and 'yes' are
       // selected in the fields above.
        'visible' => [
          ':input[id="field_color_select"]' => ['value' => 'other'],
          'and',
          ':input[id="field_choice_select"]' => ['value' => 'yes'],
        ]
      ]
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];
    return $form;

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(&$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
  }
}
