<?php 

/**
 * @file
 * Contains Drupal\form_module\Form\CustomMultistepForm.  
 */
namespace Drupal\form_module\Form;

use Drupal\Core\Form\FormBase;  
use Drupal\Core\Form\FormStateInterface; 

/**
 * Defines a multi-step form.
 */
class CustomMultistepForm extends FormBase { 

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_multistep_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // If current_page is set to 2, secondForm() method is called.
    if ($form_state->has('current_page') && $form_state->get('current_page') == 2) {
      return $this->secondForm($form, $form_state);
    }
    // If current_page is set to 3, thirdForm() method is called.
    if ($form_state->has('current_page') && $form_state->get('current_page') == 3) {
      return $this->thirdForm($form, $form_state);
    }

    $form_state->set('current_page', 1);

    $form['firstname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name:'),
      '#default_value' => $form_state->getValue('fname'),
      '#required' => TRUE,
    ];

    $form['firstnext'] = [
      '#type' => 'submit',
      '#value' => $this->t('Next'),
      '#submit' => ['::firstNext'],
    ];
    return $form;
  }

  /**
   * Function to set current_page to 2, rebuild the form and send the form to 
   * page 2.
   */
  public function firstNext(array &$form, FormStateInterface $form_state) {
    $form_state->set('current_page', 2);
    $form_state->set('data', [
      'fname' => $form_state->getValue('firstname'),
    ]);
    $form_state->setRebuild(TRUE);
  }

  /**
   * Function to display the second page of the form which displays the lastname 
   * field to user.
   */
  public function secondForm(array &$form, FormStateInterface $form_state) {
    $form['lastname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last Name:'),
      '#default_value' => $form_state->getValue('lname'),
      '#required' => TRUE,
    ];

    $form['secondback'] = [
      '#type' => 'submit',
      '#value' => $this->t('Back'),
      '#submit' => ['::secondBack'],
    ];

    $form['secondnext'] = [
      '#type' => 'submit',
      '#value' => $this->t('Next'),
      '#submit' => ['::secondNext'],
    ];

    return $form;
  }
  
  /**
   * Function to set current_page to 1, rebuild the form and send the form to 
   * page 1.
   */
  public function secondBack(array &$form, FormStateInterface $form_state) {
    $form_state->setValues($form_state->get('data'));
    $form_state->set('current_page', 1);
    $form_state->setRebuild(TRUE);
  }

  /**
   * Function to set current_page to 3, rebuild the form and send the form to 
   * page 3.
   */
  public function secondNext(array &$form, FormStateInterface $form_state) {
    $values = $form_state->get('data');
    $form_state->set('current_page', 3);
    $form_state->set('data', [
      'fname' => $values['fname'],
      'lname' => $form_state->getValue('lastname'),
    ]);
    $form_state->setRebuild(TRUE);
  }

  /**
   * Function to display the third page of the form which displays the email 
   * field to user.
   */
  public function thirdForm(array &$form, FormStateInterface $form_state) {
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email ID:'),
      '#required' => TRUE,
    ];

    $form['thirdback'] = [
      '#type' => 'submit',
      '#value' => $this->t('Back'),
      '#submit' => ['::thirdBack'],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * Function to set current_page to 2, rebuild the form and send the form to 
   * page 2.
   */
  public function thirdBack(array &$form, FormStateInterface $form_state) {
    $form_state->setValues($form_state->get('data'));
    $form_state->set('current_page', 2);
    $form_state->setRebuild(TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    $values = $form_state->get('data');
    $firstname = $values['fname'];
    $lastname = $values['lname'];
    $this->messenger()->addMessage($this->t('Form submitted succefully. Name: @first @last . Email: @email', [
      '@first' => $firstname,
      '@last' => $lastname,
      '@email' => $email,
    ]));
  }
}
