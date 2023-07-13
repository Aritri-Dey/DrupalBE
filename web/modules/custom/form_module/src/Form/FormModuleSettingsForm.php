<?php 

/**
 * @file
 * Contains Drupal\mymodule\Form\MyModuleSettingsForm.  
 */
namespace Drupal\form_module\Form;

use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  

/**
 * Defines a form to configure module settings.
 */
class FormModuleSettingsForm extends ConfigFormBase {   

  /**
   * {@inheritDoc}
   */
  public function getFormId() {
    return 'form_module_admin_settings';
  }

  /**
   * {@inheritDoc}
   */
  public function getEditableConfigNames() {
    return [
      'form_module.admin_settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('mymodule.admin_settings');
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name:'),
      '#default_value' => $config->get('name'),
      '#required' => TRUE,
    ];
    $form['phno'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone Number:'),
      '#default_value' => $config->get('phno'),
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email ID: '),
      '#default_value' => $config->get('email'),
      '#required' => TRUE,
    ];
    $form['gender'] = [
      '#type' => 'radios',
      '#title' => $this->t('Gender: '),
      '#options' => [
        'Male' => $this->t('Male'),
        'Female' => $this->t('Female'),
      ],
      '#default_value' => $config->get('gender'),
      '#required' => TRUE,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];
    return $form;
  }
 
  /**
   * Function to validate form inputs.
   *
   *   @param  array $form
   *     Array to store form elements.
   *   @param  object $form_state
   *     Object of FormStateInterface class.
   */
  public function validateForm(array &$form, FormStateInterface $form_state ) {
    $phno = $form_state->getValue('phno');
    $email = $form_state->getValue('email');
    $domain = substr(strrchr($email, '@'), 1);

    if (!preg_match('/^[789]\d{9}$/', $phno)) {
      $form_state->setErrorByName($phno, 'Please enter a valid 10 digit Indian phone number.');
    }
    if (!preg_match('/^(?!\.)[a-zA-Z0-9_\+\-\.]+@[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}$/', $email)) {
      $form_state->setErrorByName($email, 'Please enter a valid email id.');
    }
    if (!$this->isPublicDomain($domain)) {
      $form_state->setErrorByName($email, 'The domain of the email is not public.');
    }
  }
 
  /**
   * Function to check if a domain is public.
   *
   *   @param  string $domain
   *     Stores domain of the email to be checked.
   *   @return bool
   *     Returns TRUE if $domain is present in $public_domain array, else returns false.
   */
  public function isPublicDomain($domain) {
    $public_domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com'];
    if (in_array($domain, $public_domains)) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('mymodule.admin_settings');
    $config->delete();
    $config->set('name', $form_state->getValue('name'));
    $config->set('phno', $form_state->getValue('phno'));
    $config->set('email', $form_state->getValue('email'));
    $config->set('gender', $form_state->getValue('gender'));
    $config->save();
  }
}  
