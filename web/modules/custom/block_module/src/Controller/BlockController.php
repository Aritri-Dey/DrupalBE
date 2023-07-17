<?php 

/**
 * @file
 * Generates markup to be displayed. Functionality in this Controller 
 * is wired to drupal in block_module.routing.yml 
 */
namespace Drupal\block_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class to implement controller of block_module.
 */
class BlockController extends ControllerBase {
  
    /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function myPage() {
    return [
      '#markup' => t(string: 'This is a custom page!!!'),
    ];
  }
}
