<?php 

/**
 * @file
 * Contains Drupal\db_tax_term\Form\DBTaxForm.  
 */
namespace Drupal\db_tax_term\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormBase;  
use Drupal\Core\Form\FormStateInterface; 
use Drupal\Core\Url; 

/**
 * Defines a form to configure module settings.
 */
class DBTaxForm extends FormBase { 

    /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'db_tax_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['taxo_term'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter taxonomy term'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Check'),
      '#ajax' => [
        'callback' => '::checkSubmit',
        'event' => 'click',
      ],
      '#prefix' => '<div class="output"></div>',
    ];
    return $form;
  }

  /**
   * Fucntion to fetch taxonomy term details from database and show user based on
   * entered value.
   * 
   *  @param array $form
   *    Stores the form. 
   *  @param FormStateInterface $form_state
   *    Stores object of FormStateInterface.
   * 
   *  @return
   *    Returns ajax response.
   */
  public function checkSubmit(array &$form, FormStateInterface $form_state) {
    $ajax_res = new AjaxResponse();
    $taxonomy_term = $form_state->getValue('taxo_term');
    $database = \Drupal::database();
    // Fetching term name and term id from taxonomy_term_field_data table.
    $query = $database->select('taxonomy_term_field_data', 't');
    $query->fields('t', ['tid', 'name'])
          ->where(
            'binary t.name = :token',
            ['token' => $taxonomy_term]
            )
          ->join('taxonomy_term_data', 'x', 't.tid = x.tid');
    $query->fields('x', [' uuid'])
          ->join('taxonomy_index', 'i', 'x.tid = i.tid');
    $query->fields('i', [' nid']);
    $result = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
    foreach ($result as $record) {
      $nid[] = $record['nid'];
    }
    $name = $record['name'];
    $term_uuid = $record['uuid'];
    $term_id = $record['tid'];
    foreach($nid as $node) {
      $query = $database->select('node_field_data', 'nfd');
      $query->fields('nfd', ['title', 'nid'])
            ->condition('nfd.nid', $node, '=');
      $titles[] = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    // Storing the titles and url of the node in separate arrays.
    foreach ($titles as $title) {
      foreach($title as $get_title) {
        $node_title[] = $get_title['title'];
        $url = Url::fromRoute('entity.node.canonical', ['node' => $get_title['nid']]);
        $nodeUrl = $url->toString();
        $node_url[] = "moduletest.com" . $nodeUrl;
      }
    }

    $output[] = [
      '#markup' => '<div>' . $this->t('<strong>Term:</strong> @name <br> <strong>Term UUID:</strong> @uuid <br> <strong>Term ID:</strong> @id <br><strong>
         Nodes:</strong><br>@nid <br> <strong>Url of the nodes respectively: </strong><a>@url</a>', [
        '@uuid' => $term_uuid,
        '@id' => $term_id,
        '@name' => $name,
        '@nid' => implode(' , ', $node_title),
        '@url' => implode(' , ', $node_url),
        ]) . '</div>',
      ];
      
    $ajax_res->addCommand(new HtmlCommand('.output', $output));
    return $ajax_res;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(&$form, FormStateInterface $form_state) {

  }

}
