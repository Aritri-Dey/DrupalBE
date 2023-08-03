<?php 
/**
 * Contains event_module/src/EventSubscriber/NodeMessageSubscriber.php
 * 
 */

namespace Drupal\event_module\EventSubscriber;
 
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\event_module\Event\NodeMessageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class NodeMessageSubscriber implements EventSubscriberInterface {

  /**
   * Stores the node of the desired content type.
   */
  protected $node;

  /**
   * Stores object of EntityTypeManagerInterface interface.
   */
  protected $entityTypeManager;

  /**
   * Stores object of RouteMatchInterface interface.
   */
  protected $currentRouteMatch;

  /**
   * Constructor to initialize class variables.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, RouteMatchInterface $currentRouteMatch) {
    $this->entityTypeManager = $entityTypeManager;
    $this->currentRouteMatch = $currentRouteMatch;
    
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[NodeMessageEvent::EVENT_NAME][] = ['onNodeMessage'];
    $events[KernelEvents::VIEW][] = ['onView', 100];
    return $events;
  }

  /**
   * Function to define action to be performed when NodeMessageEvent is triggered.
   * 
   *   @param  object $event
   *     Stores object of NodeMessageEvent class.
   */
  public function onNodeMessage(NodeMessageEvent $event) {
    $message = $event->getMessage();
    \Drupal::messenger()->addStatus(t("This from NodeMessageEvent"));
  }

  /**
   * Function to define action to be performed when a node of movie_type is viewed.
   * 
   *  @param object $event
   *     Stores object of ViewEvent class.
   *    
   */
  public function onView(ViewEvent $event) {
    $node_param = $this->currentRouteMatch->getParameter('node');
    if ($node_param instanceof \Drupal\Core\Entity\EntityInterface) {
      $this->node = $node_param;
    
    if ($this->node->getType() == 'movie_type') {
      // Get the ID of the node.
      $node_id = $this->node->id();
      $source_entity = \Drupal\node\Entity\Node::load($node_id);
      if ($source_entity) {
        // Get the field value from the loaded source entity.
        $field_value = $source_entity->get('field_movie_type_price')->value;
        // Get amount from config form.
        $config = \Drupal::config('event_module.admin_settings');
        // Check whether movie is within budget or over budget.
        if ($config->get('amount') > $field_value) {
          $message = '<p><strong>The movie is under budget (from Event Module)</strong></p>';
        }
        else if ($config->get('amount') < $field_value) {
          $message = '<p><strong>The movie is over budget (from Event Module)</strong></p>';
        }
        else {
          $message = '<p><strong>The movie is within budget (from Event Module)</strong></p>';
        }
        // Add the message to the node's content.
        $build['my_message'] = [
          '#type' => 'markup',
          '#markup' => $message,
          '#prefix' => '<div class="my-message">',
          '#suffix' => '</div>',
          '#cache' => [
            'tags' => $config->getCacheTags(),
          ],
        ];
        $result = $event->getControllerResult();
        // Merging the result with node contents.
        $event->setControllerResult(array_merge($result, $build));
      }
    }}
  }
}
