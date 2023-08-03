<?php 

/**
 * @file
 * Contains Drupal\menu_module\Form\MenuModuleForm.  
 */
namespace Drupal\menu_module\Form;

use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  

/**
 * Defines a form to configure module settings.
 */
class MenuModuleForm extends ConfigFormBase {   

  /**
   * {@inheritDoc}
   */
  public function getFormId() {
    return 'menu_module_admin_settings';
  }

  /**
   * {@inheritDoc}
   */
  public function getEditableConfigNames() {
    return [
      'menu_module.admin_settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('menu_module.admin_settings');
    $form['amount'] = [
      '#type' => 'number',
      '#title' => $this->t('Enter amount:'),
      '#default_value' => $config->get('amount'),
      '#required' => TRUE,
    ];
    
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('menu_module.admin_settings');
    $config->delete();
    $config->set('amount', $form_state->getValue('amount'));

    $config->save();
  }
}  
