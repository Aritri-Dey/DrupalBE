<?php 

/**
 * @file
 * Generates markup to be displayed. Functionality in this Controller 
 * is wired to drupal in mymodule.routing.yml 
 */

namespace Drupal\module2\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class to implement controller to show hello message to user.
 */
class Module2Controller extends ControllerBase{
  /**
   * Function to return message along with currnt logged in user's name.
   * 
   *  @return array
   */
  public function helloUser() {
    return [
      '#type' => 'markup',
      '#markup' => t(string: 'Hello '. \Drupal::currentUser()->getAccountName()),
    ];
  }
}
