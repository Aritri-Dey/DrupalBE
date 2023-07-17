<?php 

namespace Drupal\route_module\Routing ;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  public function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('route_module.helloUser')) {
      $route->setRequirement('_role', 'administrator + manager');
    }
  }
}
