<?php 

/**
 * @file
 * Generates markup to be displayed. Functionality in this Controller 
 * is wired to drupal in db_module.routing.yml 
 */

namespace Drupal\db_module\Controller;

use Drupal;
use Drupal\Core\Controller\ControllerBase;

class DBController extends ControllerBase {

  /**
   * Function to show events on yearly, quarterly and type basis.
   * 
   *  @return array
   *    Returns render array.
   */
  public function showEvent() {
    
    $database = Drupal::database();
    // Selects and groups events on the basis of event type.
    $query = $database->select('node__field_events_type', 'a');
    $query->fields('a', [' field_events_type_value']);
    $query->addExpression('count(field_events_type_value)', 'field_events_type_value_count');
    $query->groupBy("a.field_events_type_value");
    $result = $query->execute();
    foreach ($result as $value) {
      $build[] = [
        'type' => $value->field_events_type_value,
        'count' => $value->field_events_type_value_count

      ];
    }

    // Selects and stores events on the basis of year.
    $query = $database->select('node__field_events_date', 'b');  
    $query->fields('b', ['field_events_date_value']);
    $query->addExpression('YEAR(field_events_date_value)', 'year') ;
    $yearly_count = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
    $year_arr = [];
    foreach ($yearly_count as $value) {
      $year_arr[$value['year']] = isset($year_arr[$value['year']]) ? ++$year_arr[$value['year']] : 1;
    }
  
    // Selects and stores evenst on the basis of yearly quarters.
    $query = $database->select('node__field_events_date', 'c');  
    $query->fields('c', ['field_events_date_value']);
    $query->addExpression('YEAR(field_events_date_value)', 'year') ;
    $query->addExpression('QUARTER(field_events_date_value)', 'quarter') ;
    $quarter_count = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
    // dd($quarter_count);
    $quarter_arr = [];
    foreach ($quarter_count as $value) {
      $quarter_arr[$value['year']][$value['quarter']] = isset($quarter_arr[$value['year']][$value['quarter']]) ? ++$quarter_arr[$value['year']][$value['quarter']] : 1;
    }

    // Returns all the grouped events to be rendered through template.
    return [
      '#theme' => 'db_module_events',
      '#value' => $build,
      '#yearly' => $year_arr,
      '#quarterly' => $quarter_arr,
    ];

  }

}
