<?php 

/**
 * @file
 * Generates markup to be displayed. Functionality in this Controller 
 * is wired to drupal in service_module.routing.yml 
 */

namespace Drupal\service_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\service_module\CurrentUser;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class to implement controller of service_module.
 */
class ServiceController extends ControllerBase {

  /**
   *   @var object $currentUser
   *     To store object of CurrentUser class.
   */
  protected $currentUser;

  /**
   * Constructor to initiclise class variable.
   * 
   *  @param object $current_user
   *    Instance of CurrentUser class. 
   */
  public function __construct(CurrentUser $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * The create() method sets up the dependency injection by fetching the 
   * service_module.current_user service from the container.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('service_module.current_user')
    );
  }
  
  /**
   * Function to display current user username using service dependency by 
   * calling the service class methods.
   * 
   *   @return array 
   *     Returns render array.
   */
  public function usernameDI() {
    $username = $this->currentUser->getUsername();
    $cachetags = ['user:' . $this->currentUser->getId()];
    // If user is not logged in then a message is displayed, else username is
    // displayed.
    if (!$this->currentUser->getId()) {
      return [
        '#type' => 'markup',
        '#cache' => [
          'tags' => $cachetags,
        ],
        '#markup' => t(string: 'Hello. Please login.'),
      ];
    }
    else {
      return [
        '#type' => 'markup',
        '#cache' => [
          'tags' => $cachetags,
        ],
        '#markup' => t(string: 'Hi @user',
          args: ['@user' => $username]),
      ];
    }
  }


  /**
   * Returns a simple page.
   *
   *   @return array
   *     A simple renderable array.
   */
  public function myPage() {
    return [
      '#markup' => t(string: 'This is the custom page of Service Module.'),
    ];
  }

}
