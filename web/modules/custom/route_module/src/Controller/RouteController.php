<?php 

/**
 * @file
 * Generates markup to be displayed. Functionality in this Controller 
 * is wired to drupal in mymodule.routing.yml 
 */

namespace Drupal\route_module\Controller;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Class to implement controller of route_module.
 */
class RouteController extends ControllerBase {
  /**
   * Function to return given message.
   * 
   *  @return array
   *    Returns message.
   */
  public function helloMsg() {
    return [
      '#type' => 'markup',
      '#markup' => t(string: 'Hello Aritri Dey'),
    ];
  }

  /**
   * Function to return message along with names in the url.
   * 
   *  @return array
   */
  public function variableContent($name_1, $name_2) {
    return [
      '#type' => 'markup',
      '#markup' => t(string: 'Hello @name1 and @name2',
        args: ['@name1' => $name_1, '@name2' => $name_2]),
    ];
  }

  /**
   * Function to return message along with currnt logged in user's name.
   * 
   *  @return array
   */
  public function helloUser() {
    return [
      '#type' => 'markup',
      '#markup' => t(string: 'Hello, welcome '. \Drupal::currentUser()->getAccountName()),
    ];
  }

  /**
   * Checks access for a specific request.
   *
   *   @param \Drupal\Core\Session\AccountInterface $account
   *     Run access checks for this account.
   *
   *   @return \Drupal\Core\Access\AccessResultInterface
   *     The access result.
   */
  public function accessCheck(AccountInterface $account) {
    // Check for permission'test check'.
    $check = $account->hasPermission('test check');
    return AccessResult::forbiddenIf($check);
  }

}
