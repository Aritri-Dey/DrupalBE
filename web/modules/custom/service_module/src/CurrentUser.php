<?php 

namespace Drupal\service_module;

use Drupal\Core\Session\AccountProxyInterface;

/**
 * Service class to get username of current user.
 * 
 *  @var string $currentUser
 *    To store curent user.
 */
class CurrentUser {

  /**
   *   @var object $currentUser
   *     Stores the current user account.
   */
  protected $currentUser;

  /**
   * Constructor to initiclise class variable.
   * 
   *  @param object $current_user
   *    Instance of AccountProxyInterface class. 
   */
  public function __construct(AccountProxyInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * Function to get username of the current user.
   * 
   *   @return string
   *     Returns account name of current user.
   *     
   */
  public function getUsername() {
    return $this->currentUser->getAccountName();
  }

  /**
   * Function to get id of the current user.
   * 
   *   @return string
   *     Returns id of the current user account.
   */
  public function getId() {
    return $this->currentUser->id();
  }

  /**
   * Function to get role of the current user.
   * 
   *   @return array
   *     Returns an array of roles.
   */
  public function getRole() {
    return $this->currentUser->getRoles();
  }
  
}
