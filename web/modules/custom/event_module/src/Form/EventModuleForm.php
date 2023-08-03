<?php 

/**
 * @file
 * Contains Drupal\event_module\Form\EventModuleForm.  
 */
namespace Drupal\event_module\Form;

use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;
use Drupal\event_module\Event\NodeMessageEvent;  

/**
 * Defines a form to configure module settings.
 */
class EventModuleForm extends ConfigFormBase {   

  /**
   * {@inheritDoc}
   */
  public function getFormId() {
    return 'event_module_admin_settings';
  }

  /**
   * {@inheritDoc}
   */
  public function getEditableConfigNames() {
    return [
      'event_module.admin_settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('event_module.admin_settings');
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
    $config = $this->config('event_module.admin_settings');
    $config->delete();
    $config->set('amount', $form_state->getValue('amount'));
    $config->save();

    $dispatcher = \Drupal::service('event_dispatcher');
    $event_new = new NodeMessageEvent($form_state->getValue('amount'));

    $dispatcher->dispatch($event_new, NodeMessageEvent::EVENT_NAME);
  }
  
}  
